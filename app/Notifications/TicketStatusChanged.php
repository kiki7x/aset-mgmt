<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TicketStatusChanged extends Notification
{
    use Queueable;

    protected $ticket;
    protected $oldStatus;
    protected $newStatus;

    public function __construct($ticket, string $oldStatus, string $newStatus)
    {
        $this->ticket = $ticket;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Status tiket ' . $this->ticket->ticket . ' berubah: ' . $this->oldStatus . ' → ' . $this->newStatus,
            'ticket_id' => $this->ticket->id,
            'url' => route('admin.tiket.show', $this->ticket->id),
            'color' => 'warning',
        ];
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
