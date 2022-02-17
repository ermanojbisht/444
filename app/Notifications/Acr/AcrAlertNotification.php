<?php

namespace App\Notifications\Acr;

use App\Models\Acr\Acr;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class AcrAlertNotification extends Notification implements ShouldQueue
{
    /**
     * @var mixed
     */
    public $user;
    /**
     * @var mixed
     */
    public $userPendingAcrs;
    /**
     * @var mixed
     */
    public $msg;

    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $userPendingAcrs)
    {
        //
        $this->user = $user;
        $this->userPendingAcrs = $userPendingAcrs;
        $this->makeMsg();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed   $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed                                            $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * [toTelegram description]
     * @param  [type] $notifiable     [description]
     * @return [type] [description]
     */
    public function toTelegram($notifiable)
    {
        $count = $this->userPendingAcrs->count();

        $body = "$count no of ACR are pending on your part. Please go through HRMS web portal .";
        $url = 'https://mis.pwduk.in/hrms';

        $msg = "*".'ACR Notification'."*\n".
        "Dear ".$this->user->name."\n".
            $body."\n".
            "You are hereby intimated for futher action."."\n".
            'Please regularly monitor relevent website/documents and take necessery action. Thank you for being with us!.'."\n";

        return TelegramMessage::create()
        // Optional recipient user id.
        //->to($notifiable->chat_id)
        // Markdown supported.
            ->content($msg)
            ->button('Visit HRMS', $url);
        // (Optional) Blade template for the content.
        // ->view('notification', ['url' => $url])
        // (Optional) Inline Buttons
        //
        /*return TelegramFile::create()
    ->content($msg)
    ->document($acr->pdfFullFilePath, 'acr_'.$acr->employee_id.'_id_'.$acr->id.'.pdf');*/
    }

    public function makeMsg()
    {
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed   $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
