<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\MaintenancesModel;

class MaintenancesObserver
{
    private function getDescription(MaintenancesModel $maintenance, string $event): string
    {
        $user = auth()->user()?->name ?? 'System';
        $assetName = $maintenance->asset?->name ?? '(unknown)';

        return match ($event) {
            'created' => "{$user} membuat pemeliharaan {$assetName}",
            'updated' => "{$user} mengubah pemeliharaan {$assetName}",
            'deleted' => "{$user} menghapus pemeliharaan {$assetName}",
            default => "{$user} melakukan {$event} pada pemeliharaan {$assetName}",
        };
    }

    public function created(MaintenancesModel $maintenance): void
    {
        ActivityLog::create([
            'user_id'      => auth()->id(),
            'loggable_type' => get_class($maintenance),
            'loggable_id'   => $maintenance->id,
            'event'         => 'created',
            'description'   => $this->getDescription($maintenance, 'created'),
            'new_values'    => $maintenance->toArray(),
            'ip_address'    => request()->ip(),
        ]);
    }

    public function updated(MaintenancesModel $maintenance): void
    {
        if ($maintenance->isDirty()) {
            ActivityLog::create([
                'user_id'      => auth()->id(),
                'loggable_type' => get_class($maintenance),
                'loggable_id'   => $maintenance->id,
                'event'         => 'updated',
                'description'   => $this->getDescription($maintenance, 'updated'),
                'old_values'    => $maintenance->getOriginal(),
                'new_values'    => $maintenance->getChanges(),
                'ip_address'    => request()->ip(),
            ]);
        }
    }

    public function deleted(MaintenancesModel $maintenance): void
    {
        ActivityLog::create([
            'user_id'      => auth()->id(),
            'loggable_type' => get_class($maintenance),
            'loggable_id'   => $maintenance->id,
            'event'         => 'deleted',
            'description'   => $this->getDescription($maintenance, 'deleted'),
            'old_values'    => $maintenance->toArray(),
            'ip_address'    => request()->ip(),
        ]);
    }
}
