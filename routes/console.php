<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Mengeksekusi command reminder setiap hari pada pukul 08:00 pagi
Schedule::command('reminder:whatsapp-reminder-command')->dailyAt('07:30');