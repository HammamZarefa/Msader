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
            ->content("*"."new order notification"
                      ."*\n\n" . "service name:  " . "*".$this->data['service_name']
                      ."*\n\n" . "service type:  " . "*".$this->data['service_type']
                      ."*\n\n" . "quantity:  " . "*".$this->data['quantity']
                      ."*\n"
                      )
            ->button('View Details',  $this->url);

    }


}
