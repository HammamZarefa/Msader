<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use NotificationChannels\Telegram\TelegramMessage;
use NotificationChannels\Telegram\TelegramChannel;

class ExceptionNotificationTelegram extends Notification
{
    use Queueable;

    protected $message;
    protected $line;
    protected $file;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $line, $file)
    {
        $this->message = $message;
        $this->line = $line;
        $this->file = $file;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to(Config::get('basic.telegram_chat_id'))
            ->content("*" . "new Exception notification"
                . "*\n\n" . "Exception Message:  " . "*" . $this->message
                . "*\n\n" . "Exception line:  " . "*" . $this->line
                . "*\n\n" . "Exception file:  " . "*" . $this->file
                . "*\n"
            );
    }


}
