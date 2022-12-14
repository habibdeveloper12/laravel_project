<?php

namespace App\Notifications;

use Illuminate\Http\Request;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\DB;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class GenericNotification extends Notification
{
    use Queueable;
    public $title, $body;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title, $body)
    {
        //
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        $time = \Carbon\Carbon::now();

        return (new WebPushMessage)
            // ->id($notification->id)
            ->title($this->title)
            ->icon(url('/push.png'))
            ->body($this->body);
        //->action('View account', 'view_account');
    }


}
