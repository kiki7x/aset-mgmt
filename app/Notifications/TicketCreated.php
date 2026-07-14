<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TicketCreated extends Notification
{
    use Queueable;

    protected $ticket;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Tiket baru: ' . $this->ticket->ticket . ' - ' . $this->ticket->subject,
            'ticket_id' => $this->ticket->id,
            'url' => route('admin.tiket.show', $this->ticket->id),
            'color' => 'info',
        ];
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
