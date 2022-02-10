<?php

namespace App\Notifications\Acr;

use App\Models\Acr\Acr;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class AcrSubmittedNotification extends Notification implements ShouldQueue
{
    /**
     * @var mixed
     */
    public $acr;
    /**
     * @var mixed
     */
    public $targetDutyType;
    /**
     * @var mixed
     */
    public $reportingEmployee;
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
    public function __construct($acr, $reportingEmployee, $targetDutyType)
    {
        //
        $this->acr = $acr;
        $this->targetDutyType = $targetDutyType;
        $this->reportingEmployee = $reportingEmployee;
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
        $targetDutyType = $this->targetDutyType;
        $acr = $this->acr;
        $body='';
        switch ($targetDutyType) {
            case 'report':
                $body .= $acr->employee->name.' has subitted his/her self appraisal on '.$acr->submitted_at->format('d M Y').'Please visit your inbox section at HRMS/Track AR portal.';
                break;
            case 'review':
                $body .= $acr->employee->name.'\'s performance report has been reported by '.$acr->userOnBasisOfDuty('report')->name.'  on '.$acr->report_on->format('d M Y ').'Please visit your inbox section at HRMS/Track AR portal.';
                break;
            case 'accept':
                $body .= $acr->employee->name.'\'s performance report has been reviewed by '.$acr->userOnBasisOfDuty('review')->name.'  on '.$acr->review_on->format('d M Y ').'Please visit your inbox section at HRMS/Track AR portal.';
                break;
            case 'submit':
                $body .= 'Your performance report has been acccepted by '.$acr->userOnBasisOfDuty('accept')->name.'  on '.$acr->accept_on->format('d M Y ').'Please visit your myacr section at HRMS/Track AR portal.';
                break;

            default:
                // code...
                break;
        }
        $msg = "*".'ACR Notification'."*\n".
        "Dear ".$this->reportingEmployee->name."\n".
        $body."\n".
        'ACR Period : '.$acr->from_date->format('d M Y').' to '.$acr->to_date->format('d M Y')."\n".
            "You are hereby intimated for futher action."."\n".
            'Please regularly monitor relevent website/documents and take necessery action. Thank you for being with us!.'."\n";

        return TelegramMessage::create()
        // Optional recipient user id.
        //->to($notifiable->chat_id)
        // Markdown supported.
            ->content($msg)
            ->document($acr->pdfFullFilePath, 'acr_'.$acr->employee_id.'_id_'.$acr->id.'.pdf');
        //->button('Visit Timeline', $url);
        // (Optional) Blade template for the content.
        // ->view('notification', ['url' => $url])
        // (Optional) Inline Buttons
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
