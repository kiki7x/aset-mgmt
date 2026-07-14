<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class EditAsetRT extends Notification
{
    use Queueable;

    protected $asetrt;

    public function __construct($asetrt)
    {
        $this->asetrt = $asetrt;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Aset RT diedit: ' . $this->asetrt->name,
            'asetrt_id' => $this->asetrt->id,
            'url' => route('admin.asetrt.overview', $this->asetrt->id),
            'color' => 'primary',
        ];
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
