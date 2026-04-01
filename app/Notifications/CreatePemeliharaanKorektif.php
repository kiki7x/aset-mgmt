<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Services\FonnteService;

class CreatePemeliharaanKorektif extends Notification
{
    use Queueable;

    protected $maintenance;

    /**
     * Create a new notification instance.
     */
    public function __construct($maintenance)
    {
        $this->maintenance = $maintenance;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // return ['mail', 'database'];
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Aset' . ' ' . $this->maintenance->asset->name . ' ' . 'dijadwalkan untuk pemeliharaan' . ' ' . $this->maintenance_schedule->name . ' ' . 'rutin setiap' . ' ' . $this->maintenance_schedule->frequency . ' ' . 'bulan sekali. Lalu pemeliharaan selanjutnya akan jatuh tempo pada tanggal' . ' ' . $this->maintenance_schedule->next_date,
            'maintenance' => $this->maintenance->id,
            'created_at' => now()->toDateTimeString(),
        ];
    }

    public function toWhatsapp($notifiable): array
    {
        $service = new FonnteService();
        $message = "Halo {$notifiable->name}, Pemeliharaan Korektif baru saja ditambahkan";
        return $service->sendMessage($notifiable->phone, $message);
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
