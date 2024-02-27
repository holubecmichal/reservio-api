<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservationCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly Reservation $reservation)
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
        return (new MailMessage)
            ->subject(__('Reservation #:reservationId created', ['reservationId' => $this->reservation->getId()]))
            ->line(__('Your reservation #:reservationId, from :start_at to :end_at, has been created.', [
                'reservationId' => $this->reservation->getId(),
                'start_at' => $this->reservation->getStartAt()->format('d.m.Y H:i:s'),
                'end_at' => $this->reservation->getEndAt()->format('d.m.Y H:i:s'),
            ]));
    }
}
