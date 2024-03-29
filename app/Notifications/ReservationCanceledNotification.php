<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservationCanceledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly int $reservationId)
    {
        $this->afterCommit();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject(__('Reservation #:reservationId canceled', ['reservationId' => $this->reservationId]))
            ->line(__('Your reservation #:reservationId has been canceled.', ['reservationId' => $this->reservationId]));
    }
}
