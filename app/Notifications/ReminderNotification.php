<?php

namespace App\Notifications;

use App\Models\Maintenances_scheduleModel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReminderNotification extends Notification
{
    use Queueable;

    protected Maintenances_scheduleModel $schedule;

    public function __construct(Maintenances_scheduleModel $schedule)
    {
        $this->schedule = $schedule;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $assetName = $this->schedule->asset?->name ?? '(unknown)';

        return [
            'message' => 'Pengingat: Pemeliharaan ' . $this->schedule->name . ' untuk ' . $assetName . ' akan jatuh tempo',
            'schedule_id' => $this->schedule->id,
            'url' => route('admin.pemeliharaan-preventif'),
            'color' => 'warning',
        ];
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
