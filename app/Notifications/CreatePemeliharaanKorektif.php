<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CreatePemeliharaanKorektif extends Notification
{
    use Queueable;

    protected $maintenance;

    public function __construct($maintenance)
    {
        $this->maintenance = $maintenance;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $assetName = $this->maintenance->asset?->name ?? '(unknown)';
        return [
            'message' => 'Pemeliharaan korektif baru: ' . $assetName,
            'maintenance_id' => $this->maintenance->id,
            'url' => route('admin.pemeliharaan-korektif'),
            'color' => 'warning',
        ];
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
