<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClubRejectedNotification extends Notification
{
    use Queueable;

    protected $club;
    protected $reason;

    /**
     * Create a new notification instance.
     */
    public function __construct($club, $reason)
    {
        $this->club = $club;
        $this->reason = $reason;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Thông báo: Yêu cầu thành lập Câu lạc bộ - ' . $this->club->name)
            ->greeting('Chào ' . ($this->club->leader->name ?? 'bạn') . '!')
            ->line('Chúng tôi rất tiếc phải thông báo rằng yêu cầu thành lập câu lạc bộ **' . $this->club->name . '** của bạn đã bị từ chối.')
            ->line('**Lý do từ chối:**')
            ->line($this->reason ?? 'Không có lý do cụ thể được cung cấp.')
            ->action('Xem chi tiết và chỉnh sửa', url('/leader/clubs/info?club_id=' . $this->club->id))
            ->line('Bạn có thể chỉnh sửa thông tin CLB và gửi lại yêu cầu phê duyệt mới.')
            ->line('Trân trọng!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'club_id' => $this->club->id,
            'club_name' => $this->club->name,
            'reason' => $this->reason,
            'message' => 'Yêu cầu lập CLB ' . $this->club->name . ' đã bị từ chối.',
        ];
    }
}
