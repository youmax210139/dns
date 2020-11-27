<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class DomainNotification extends Notification
{
    use Queueable;

    protected $domain;
    protected $user;
    protected $action;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($domain, $user, $action)
    {
        $this->domain = $domain;
        $this->user = $user;
        $this->action = $action;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toSlack($notifiable)
    {
        if(env('SLACK_HOOK') == null) return;
        $message = "{$this->user} {$this->action} Domain[{$this->domain}]";

        return (new SlackMessage)
            ->from('DNS Robot', ':robot_face:')
            ->to('#domains')
            ->content("{$this->action} Domain Operation")
            ->attachment(function ($attachment) use ($message) {
                $attachment->title("{$this->user->name } {$this->action} Domain[ID:{$this->domain->id}]")
                    ->fields([
                        'Name' => $this->domain->name,
                        'Platform' => $this->domain->platform_name,
                    ]);
            });
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    /**
     * Determine which queues should be used for each notification channel.
     *
     * @return array
     */
    public function viaQueues()
    {
        return [
            'slack' => 'slack-queue',
        ];
    }
}
