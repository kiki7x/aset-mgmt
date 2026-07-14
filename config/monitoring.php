<?php

return [
    'retention_days' => env('MONITOR_RETENTION_DAYS', 730), // default 2 tahun
    'default_interval' => env('MONITOR_DEFAULT_INTERVAL', 5), // menit
];
