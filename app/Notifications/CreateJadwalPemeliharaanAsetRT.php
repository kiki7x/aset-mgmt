<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CreateJadwalPemeliharaanAsetRT extends Notification
{
    use Queueable;

    protected $maintenance_schedule;

    public function __construct($maintenance_schedule)
    {
        $this->maintenance_schedule = $maintenance_schedule;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $asset = $this->maintenance_schedule->asset;
        return [
            'message' => 'Jadwal pemeliharaan baru: ' . ($asset?->name ?? '(unknown)') . ' - ' . $this->maintenance_schedule->name,
            'maintenance_schedule_id' => $this->maintenance_schedule->id,
            'url' => $asset ? route('admin.asetrt.overview', $asset->id) : route('admin.pemeliharaan-preventif'),
            'color' => 'info',
        ];
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
