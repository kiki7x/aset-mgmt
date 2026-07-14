<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CreateAsetTik extends Notification
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
            'message' => 'Aset TIK baru ditambahkan: ' . $this->asettik->name,
            'asettik_id' => $this->asettik->id,
            'created_by' => $this->asettik->created_by,
            'url' => route('admin.asettik.overview', $this->asettik->id),
            'color' => 'success',
        ];
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
