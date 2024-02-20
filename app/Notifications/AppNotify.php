<?php

namespace App\Notifications;

use App\Channels\FirebaseChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppNotify extends Notification
{
    use Queueable;

    public  $title;
    public  $message;
    public  $fcmToken;
    public $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title, $message, $fcmTokens, $data = null)
    {
        $this->title = $title;
        $this->message = $message;
        $this->fcmToken = $fcmTokens;
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($notifiable->hasPushToken()) {
            return ['database', FirebaseChannel::class];
        } else {
            return ['database'];
        }
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */

    public function toFirebase($notifiable)
    {

        return (new FirebaseChannel());
    }

    public function toDatabase($notifiable)
    {
        return  [
            'title' => $this->title,
            'body' => $this->message,
            'data' => $this->data,

        ];
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
}
