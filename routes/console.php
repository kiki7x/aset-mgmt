<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Mengeksekusi command reminder setiap hari pada pukul 08:00 pagi
Schedule::command('app:whatsapp-reminder-command')->dailyAt('07:30');

// Monitoring heartbeat: jalan tiap menit, command menentukan monitor mana yang due
Schedule::command('app:monitor-heartbeat')->everyMinute();

// Cleanup data heartbeat lama, tiap hari pukul 01:00
Schedule::command('app:monitor-cleanup')->dailyAt('01:00');