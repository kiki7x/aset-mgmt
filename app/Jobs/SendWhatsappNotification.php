<?php

namespace App\Jobs;

use App\Services\FonnteService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWhatsappNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $target;
    protected $message;

    // Tentukan jumlah percobaan jika gagal
    public $tries = 2;

    public function __construct($target, $message)
    {
        $this->target = $target;
        $this->message = $message;
    }

    public function handle(FonnteService $fonnteService)
    {
        // Logika pengiriman dilakukan di sini (background)
        $fonnteService->sendMessage($this->target, $this->message);
    }
}
