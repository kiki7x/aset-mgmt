<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class EditAsetTik extends Notification
{
    use Queueable;

    protected $asettik;

    public function __construct($asettik)
    {
        $this->asettik = $asettik;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Aset TIK diedit: ' . $this->asettik->name,
            'asettik_id' => $this->asettik->id,
            'url' => route('admin.asettik.overview', $this->asettik->id),
            'color' => 'primary',
        ];
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
