<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateJadwalPemeliharaanAsetRT extends Notification
{
    use Queueable;

    protected $maintenance_schedule;

    /**
     * Create a new notification instance.
     */
    public function __construct($maintenance_schedule)
    {
        $this->maintenance_schedule = $maintenance_schedule;
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
            'message' => 'Aset RT' . ' ' . $this->maintenance_schedule->asset->name . ' ' . 'dijadwalkan untuk pemeliharaan' . ' ' . $this->maintenance_schedule->name . ' ' . 'rutin setiap' . ' ' . $this->maintenance_schedule->frequency . ' ' . 'bulan sekali. Lalu pemeliharaan selanjutnya akan jatuh tempo pada tanggal' . ' ' . $this->maintenance_schedule->next_date,
            'maintenance_schedule_id' => $this->maintenance_schedule->id,
            'created_at' => now()->toDateTimeString(),
        ];
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
