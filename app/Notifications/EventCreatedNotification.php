<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Event;
use App\Models\Club;

class EventCreatedNotification extends Notification
{
    use Queueable;

    protected $event;
    protected $club;

    /**
     * Create a new notification instance.
     */
    public function __construct(Event $event, Club $club)
    {
        $this->event = $event;
        $this->club = $club;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // Defaulting to database channel
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Sự kiện mới từ câu lạc bộ ' . $this->club->name)
            ->action('Xem chi tiết', url('/member/events/' . $this->event->id))
            ->line('Cảm ơn bạn đã sử dụng ứng dụng của chúng tôi!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'event_id' => $this->event->id,
            'event_title' => $this->event->title,
            'club_id' => $this->club->id,
            'club_name' => $this->club->name,
            'start_time' => $this->event->start_time,
            'message' => 'Sự kiện mới: ' . $this->event->title . ' từ CLB ' . $this->club->name,
            'link' => route('member.events.index'),
        ];
    }
}
