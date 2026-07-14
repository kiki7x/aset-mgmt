<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\AssetsModel;

class AssetsObserver
{
    public function created(AssetsModel $asset): void
    {
        ActivityLog::create([
            'user_id'      => auth()->id(),
            'loggable_type' => get_class($asset),
            'loggable_id'   => $asset->id,
            'event'         => 'created',
            'description'   => auth()->user()?->name . ' membuat aset ' . $asset->name,
            'new_values'    => $asset->toArray(),
            'ip_address'    => request()->ip(),
        ]);
    }

    public function updated(AssetsModel $asset): void
    {
        if ($asset->isDirty()) {
            ActivityLog::create([
                'user_id'      => auth()->id(),
                'loggable_type' => get_class($asset),
                'loggable_id'   => $asset->id,
                'event'         => 'updated',
                'description'   => auth()->user()?->name . ' mengubah aset ' . $asset->name,
                'old_values'    => $asset->getOriginal(),
                'new_values'    => $asset->getChanges(),
                'ip_address'    => request()->ip(),
            ]);
        }
    }

    public function deleted(AssetsModel $asset): void
    {
        ActivityLog::create([
            'user_id'      => auth()->id(),
            'loggable_type' => get_class($asset),
            'loggable_id'   => $asset->id,
            'event'         => 'deleted',
            'description'   => auth()->user()?->name . ' menghapus aset ' . $asset->name,
            'old_values'    => $asset->toArray(),
            'ip_address'    => request()->ip(),
        ]);
    }
}
