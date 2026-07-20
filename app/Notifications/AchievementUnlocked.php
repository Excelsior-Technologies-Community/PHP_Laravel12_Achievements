<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AchievementUnlocked extends Notification implements ShouldQueue
{
    use Queueable;

    public $achievement;

    /**
     * Create a new notification instance.
     */
    public function __construct($achievement)
    {
        $this->achievement = $achievement;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🎉 Achievement Unlocked: ' . $this->achievement['title'])
            ->greeting('Congratulations!')
            ->line('You have unlocked the achievement: ' . $this->achievement['title'])
            ->line($this->achievement['description'])
            ->action('View Achievements', url('/achievements'))
            ->line('Keep up the great work!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->achievement['title'],
            'description' => $this->achievement['description'],
            'icon' => $this->achievement['icon'],
            'type' => 'achievement_unlocked',
        ];
    }
}
