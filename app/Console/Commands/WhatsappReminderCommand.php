<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:whatsapp-reminder-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengirimkan notifikasi WhatsApp via Fonnte berdasarkan H-minus dari field end';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today()->toDateString();

        $this->info("Memulai pengecekan reminder WhatsApp untuk tanggal: {$today}");

        // Query mencari data yang hasil pengurangan (end - reminder hari) adalah HARI INI
        // Asumsi: 'reminder' bertipe data INT dan satuannya adalah HARI
        $reminders = \App\Models\Maintenances_scheduleModel::with("asset")
            ->whereRaw("DATE(end - INTERVAL reminder DAY) = ?", [$today])
            ->get();

        if ($reminders->isEmpty()) {
            $this->info('Tidak ada reminder yang cocok untuk dieksekusi hari ini.');
            return Command::SUCCESS;
        }

        // Ambil token Fonnte dari file .env
        $fonnteToken = env('FONNTE_TOKEN');
        $fonnteTarget = env('FONNTE_GROUP_ID');

        if (!$fonnteToken) {
            $this->error('Token Fonnte belum diatur di file .env!');
            Log::error('WhatsApp Scheduler Gagal: FONNTE_TOKEN tidak ditemukan di .env');
            return Command::FAILURE;
        }

        foreach ($reminders as $data) {
            // Susun template pesan sesuai kebutuhan Anda
            // $pesan = "Halo Admin SAPA PPL,\n\nIni adalah pengingat bahwa pemeliharaan preventif *{$data->asset->name}* akan dilakukan pada *{$data->end}*.\n\nMohon segera lakukan pemeliharaan sebelum masa jatuh tempo. Terima kasih.";

            // 1. Format Tanggal agar lebih manusiawi (Contoh: 19 Mei 2026) dan Sisa Hari bilangan bulat
            $tanggalJatuhTempo = Carbon::parse($data->end)->translatedFormat('l d F Y');
            $sisaHari = Carbon::parse($data->end)->diffInDays(\Carbon\Carbon::today());

            // 2. Susun Pesan
                $pesan = "🗓️ *[PENGINGAT PEMELIHARAAN ASET]*\n\n";
                $pesan .= "Halo Admin SAPA PPL,\n\n";
                $pesan .= "Menginfokan bahwa aset *{$data->asset->classification->name}* *{$data->asset->name}* akan dijadwalkan untuk melakukan pemeliharaan *{$data->name}* dalam *{$sisaHari} hari ke depan*.\n\n";
                $pesan .= "📌 *Detail Aset:*\n";
                $pesan .= "• Nama Aset: *{$data->asset->name}*\n";
                $pesan .= "• Identitas Aset: *{$data->asset->tag}* | *{$data->asset->serial}*\n";
                $pesan .= "• Jatuh Tempo: *{$tanggalJatuhTempo}* ({$sisaHari} hari lagi})\n\n";
                $pesan .= "Mohon mulai menyiapkan rencana aksi, dokumen, atau anggaran yang diperlukan agar operasional tidak terganggu. Terima kasih! 🙏";
                $pesan .= "\n\n*Tindak lanjuti melalui tautan berikut.*";
                $pesan .= "\n👉 https://sapa.ppl.ac.id/admin/pemeliharaan-preventif";

            // 3. Kirim request ke API Fonnte menggunakan HTTP Client Laravel
            $response = Http::withHeaders([
                'Authorization' => $fonnteToken,
            ])->asForm()->post('https://api.fonnte.com/send', [
                        'target' => $fonnteTarget, // Ganti dengan nama field nomor WhatsApp di tabel Anda
                        'message' => $pesan,
                        'delay' => '2', // Delay antar pesan jika mengirim banyak sekaligus (opsional)
                    ]);

            // Catat log sukses atau gagal
            if ($response->successful()) {
                $this->info("Reminder berhasil dikirim ke nomor: " . $fonnteTarget);
            } else {
                $this->error("Gagal mengirim ke nomor: " . $fonnteTarget . " Respon: " . $response->body());
                Log::warning("Gagal mengirim reminder WA ke " . $fonnteTarget . " Respon: " . $response->body());
            }
        }

        $this->info('Proses pengiriman reminder selesai.');
        return Command::SUCCESS;
    }
}
