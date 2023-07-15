<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use NotificationChannels\Telegram\TelegramMessage;
use NotificationChannels\Telegram\TelegramChannel;

class TelegramNotification extends Notification
{
    use Queueable;

    protected $url;
    private $data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($url, $data)
    {
        $this->url = $url->link;
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
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable){
        // dd($this->data);
        return TelegramMessage::create()
            ->to(Config::get('basic.telegram_chat_id'))
            ->content("*"."🔥 New order! 🔥"
                      ."*\n" . "Service:  " . "*".@$this->data['service_name']
                      ."*\n" . "User:  " . "*".@$this->data['user']
                      ."*\n" . "quantity:  " . "*".@$this->data['quantity']
                      ."*"
                      )
            ->button('View Details',  $this->url);

    }


}
