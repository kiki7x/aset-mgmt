<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\TicketsModel;

class TicketsObserver
{
    public function created(TicketsModel $ticket): void
    {
        ActivityLog::create([
            'user_id'      => auth()->id(),
            'loggable_type' => get_class($ticket),
            'loggable_id'   => $ticket->id,
            'event'         => 'created',
            'description'   => ($ticket->nama ?? auth()->user()?->name) . ' membuat tiket ' . $ticket->ticket,
            'new_values'    => $ticket->toArray(),
            'ip_address'    => request()->ip(),
        ]);
    }

    public function updated(TicketsModel $ticket): void
    {
        if ($ticket->isDirty()) {
            ActivityLog::create([
                'user_id'      => auth()->id(),
                'loggable_type' => get_class($ticket),
                'loggable_id'   => $ticket->id,
                'event'         => 'updated',
                'description'   => auth()->user()?->name . ' mengubah tiket ' . $ticket->ticket,
                'old_values'    => $ticket->getOriginal(),
                'new_values'    => $ticket->getChanges(),
                'ip_address'    => request()->ip(),
            ]);
        }
    }

    public function deleted(TicketsModel $ticket): void
    {
        ActivityLog::create([
            'user_id'      => auth()->id(),
            'loggable_type' => get_class($ticket),
            'loggable_id'   => $ticket->id,
            'event'         => 'deleted',
            'description'   => auth()->user()?->name . ' menghapus tiket ' . $ticket->ticket,
            'old_values'    => $ticket->toArray(),
            'ip_address'    => request()->ip(),
        ]);
    }
}
