<?php

namespace App\Console\Commands;

use App\Models\Maintenances_scheduleModel;
use App\Models\ReminderLog;
use App\Models\User;
use App\Notifications\ReminderNotification;
use App\Services\FonnteService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class WhatsappReminderCommand extends Command
{
    protected $signature = 'app:whatsapp-reminder-command';

    protected $description = 'Mengirim notifikasi WhatsApp via Fonnte & notifikasi database berdasarkan H-minus dari field end';

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        $this->info("Memulai pengecekan reminder untuk tanggal: {$today}");

        $schedules = Maintenances_scheduleModel::with('asset', 'asset.classification')
            ->whereRaw("DATE(end - INTERVAL reminder DAY) = ?", [$today])
            ->where('status', 'Aktif')
            ->where(function ($q) {
                $q->whereNull('last_reminder_sent_at')
                    ->orWhereDate('last_reminder_sent_at', '<', $today);
            })
            ->get();

        if ($schedules->isEmpty()) {
            $this->info('Tidak ada reminder yang cocok untuk hari ini.');
            return Command::SUCCESS;
        }

        $fonnte = new FonnteService();
        $successCount = 0;
        $failCount = 0;

        foreach ($schedules as $schedule) {
            $tanggalJatuhTempo = Carbon::parse($schedule->end)->translatedFormat('l d F Y');
            $sisaHari = Carbon::parse($schedule->end)->diffInDays(Carbon::today());

            $pesan = "🗓️ *[PENGINGAT PEMELIHARAAN ASET]*\n\n";
            $pesan .= "Halo Admin SAPA PPL,\n\n";
            $pesan .= "Menginfokan bahwa aset *{$schedule->asset?->classification?->name}* *{$schedule->asset?->name}* akan dijadwalkan untuk melakukan pemeliharaan *{$schedule->name}* dalam *{$sisaHari} hari ke depan*.\n\n";
            $pesan .= "📌 *Detail Aset:*\n";
            $pesan .= "• Nama Aset: *{$schedule->asset?->name}*\n";
            $pesan .= "• Identitas Aset: *{$schedule->asset?->tag}* | *{$schedule->asset?->serial}*\n";
            $pesan .= "• Jatuh Tempo: *{$tanggalJatuhTempo}* ({$sisaHari} hari lagi)\n\n";
            $pesan .= "Mohon mulai menyiapkan rencana aksi, dokumen, atau anggaran yang diperlukan agar operasional tidak terganggu. Terima kasih! 🙏";
            $pesan .= "\n\n*Tindak lanjuti melalui tautan berikut.*";
            $pesan .= "\n👉 https://sapa.ppl.ac.id/admin/pemeliharaan-preventif";

            $response = $fonnte->sendMessage(config('fonnte.group_id'), $pesan);
            $isSuccess = isset($response['status']) && $response['status'] === true;

            ReminderLog::create([
                'maintenance_schedule_id' => $schedule->id,
                'sent_at' => now(),
                'channel' => 'whatsapp',
                'status' => $isSuccess ? 'sent' : 'failed',
                'response' => json_encode($response),
            ]);

            if ($isSuccess) {
                $this->info("WA reminder berhasil dikirim untuk jadwal: {$schedule->name}");
                $successCount++;

                $schedule->update(['last_reminder_sent_at' => now()]);

                $pic = User::find($schedule->asset?->user_id);
                if ($pic) {
                    $pic->notify(new ReminderNotification($schedule));
                    $this->info("Notifikasi database terkirim ke PIC: {$pic->name}");
                }
            } else {
                $this->error("Gagal mengirim WA untuk jadwal: {$schedule->name}");
                $failCount++;
            }
        }

        $this->info("Selesai. Berhasil: {$successCount}, Gagal: {$failCount}");
        return Command::SUCCESS;
    }
}
