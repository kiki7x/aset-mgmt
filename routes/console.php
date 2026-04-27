<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\SendWhatsappNotification;
use App\Models\Maintenances_scheduleModel;
use Illuminate\Support\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('maintenance:remind-upcoming', function () {
    $groupId = env('FONNTE_GROUP_ID');
    if (! $groupId) {
        $this->comment('FONNTE_GROUP_ID belum dikonfigurasi.');
        return;
    }

    $targetDate = Carbon::now()->addWeek();
    $start = $targetDate->copy()->startOfDay();
    $end = $targetDate->copy()->endOfDay();

    $schedules = Maintenances_scheduleModel::with('asset')
        ->whereBetween('next_date', [$start->toDateString(), $end->toDateString()])
        ->get();

    if ($schedules->isEmpty()) {
        $this->comment('Tidak ada jadwal pemeliharaan yang perlu diingatkan minggu depan.');
        return;
    }

    foreach ($schedules as $schedule) {
        $assetName = $schedule->asset->name ?? 'Aset tidak diketahui';
        $dateText = Carbon::parse($schedule->next_date)->translatedFormat('d F Y');
        $message = "Pengingat: Pemeliharaan '{$schedule->name}' untuk aset {$assetName} akan dilakukan pada {$dateText}. Mohon siapkan tim dan persiapkan dokumen pendukung.";
        SendWhatsappNotification::dispatch($groupId, $message);
        $this->comment("Pengingat dikirim untuk jadwal ID {$schedule->id}.");
    }
})->purpose('Send WhatsApp reminders for maintenance scheduled 1 week ahead')->dailyAt('08:00');
