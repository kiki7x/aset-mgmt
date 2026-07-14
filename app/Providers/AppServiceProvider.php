<?php

namespace App\Providers;

use App\Models\AssetsModel;
use App\Models\MaintenancesModel;
use App\Models\TicketsModel;
use App\Observers\AssetsObserver;
use App\Observers\MaintenancesObserver;
use App\Observers\TicketsObserver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrap();

        AssetsModel::observe(AssetsObserver::class);
        TicketsModel::observe(TicketsObserver::class);
        MaintenancesModel::observe(MaintenancesObserver::class);

        try {
            $configs = DB::table('config')->where('name', 'like', 'fonnte_%')->get();
            foreach ($configs as $cfg) {
                $key = str_replace('fonnte_', '', $cfg->name);
                config(["fonnte.{$key}" => $cfg->value]);
            }

            $mailConfigs = DB::table('config')->where('name', 'like', 'mail_%')->get();
            foreach ($mailConfigs as $cfg) {
                $key = str_replace('mail_', '', $cfg->name);
                if (in_array($key, ['host', 'port', 'username', 'password', 'encryption'])) {
                    $value = $key === 'encryption' && $cfg->value === 'null' ? null : $cfg->value;
                    config(["mail.mailers.smtp.{$key}" => $value]);
                } elseif ($key === 'from_address') {
                    config(['mail.from.address' => $cfg->value]);
                } elseif ($key === 'from_name') {
                    config(['mail.from.name' => $cfg->value]);
                }
            }

            $monitorConfigs = DB::table('config')->where('name', 'like', 'monitor_%')->get();
            foreach ($monitorConfigs as $cfg) {
                $key = str_replace('monitor_', '', $cfg->name);
                if (in_array($key, ['retention_days', 'default_interval'])) {
                    config(["monitoring.{$key}" => (int) $cfg->value]);
                }
            }
        } catch (\Exception $e) {
            // table config mungkin belum ada saat migrasi pertama
        }
    }
}
