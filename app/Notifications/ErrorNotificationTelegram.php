<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use NotificationChannels\Telegram\TelegramMessage;

class ErrorNotificationTelegram extends Notification
{
    use Queueable;

    protected $message;
    protected $input;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message,$input)
    {
        $this->message = $message;
        $this->input = $input;
       
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
            ->content("*"."new Exception notification"
                      ."*\n\n" . "Exception Message:  " . "*".$this->message
                      ."*\n\n" . "Exception input:  " . "*".$this->input
                      ."*\n"

                    );

    }

   
}
