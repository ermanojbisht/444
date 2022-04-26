<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;
use TelegramNotifications\Messages\TelegramCollection;
use Log;

class TgNotification extends Notification implements  ShouldQueue
{
    use Queueable;

    private $lines;
    private $urls;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Array $lines,Array $urls)
    {
        $this->lines=$lines;
        $this->urls=$urls;
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

    public function toTelegram($notifiable)
    {
        if(isset($notifiable->name)){
            $content ="Namaskar ".$notifiable->name."\n";
        }else{
            $content ="Namaskar "."\n";
        }

        foreach ($this->lines as $line) {
            $content .=$line."\n";
        }

        $telegramModel= TelegramMessage::create()
            ->content($content);

        foreach ($this->urls as $name=>$url) {
           $telegramModel->button($name, $url);
        }

        return $telegramModel;

    }


}
