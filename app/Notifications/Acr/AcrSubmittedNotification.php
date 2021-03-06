<?php

namespace App\Notifications\Acr;

use App\Models\Acr\Acr;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramFile;
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
    public function __construct($acr, $reportingEmployee, $targetDutyType,$msg=false)
    {
        //
        $this->acr = $acr;
        $this->msg = $msg;
        $this->targetDutyType = $targetDutyType;
        $this->reportingEmployee = $reportingEmployee;

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
            case 'acknowledge':
                $body .= $acr->employee->name.' \'s  '.$this->msg. '. Please visit your inbox section at HRMS/Track AR portal.';
                break;
            case 'report':
                $body .= $acr->employee->name.' has submiited his/her self appraisal on '.$acr->submitted_at->format('d M Y').'. Please visit your inbox section at HRMS/Track AR portal.';
                break;
            case 'review':
                $body .= $acr->employee->name.'\'s performance report has been reported by '.$acr->userOnBasisOfDuty('report')->name.'  on '.$acr->report_on->format('d M Y ').' . Please visit your inbox section at HRMS/Track AR portal.';
                break;
            case 'accept':
                    $body .= $acr->employee->name.'\'s performance report has been reviewed by '.$acr->userOnBasisOfDuty('review')->name.'  on '.$acr->review_on->format('d M Y ').' . Please visit your inbox section at HRMS/Track AR portal.';
                break;
            case 'correctnotice':
                    $body .= $acr->employee->name.'\'s performance report has been corrected on '.$acr->updated_at->format('d M Y ').' . Please visit your inbox section at HRMS/Track AR portal.';
                break;
            case 'submit':
                 if($acr->isTwoStep){
                    $body .= 'Your performance report has been reviewed by '.$acr->userOnBasisOfDuty('review')->name.'  on '.$acr->review_on->format('d M Y ').' . Please visit your myacr section at HRMS/Track AR portal.';
                }else{
                    $body .= 'Your performance report has been acccepted by '.$acr->userOnBasisOfDuty('accept')->name.'  on '.$acr->accept_on->format('d M Y ').' . Please visit your myacr section at HRMS/Track AR portal.';
                }
                break;
            case 'reject':
                $body .= 'Your performance report has been rejected by '.$acr->rejectUser()->name.'  on '.$acr->rejectionDetail->created_at->format('d M Y ').' . '."\n".
                'Comment By rejection authority : '.$acr->rejectionDetail->remark."\n".
                'Please visit your myacr section at HRMS/Track AR portal and recreate your acr .';
                break;

            default:
                // code...
                break;
        }

        $telegramMessage = "*".'ACR Notification'."*\n".
        "Dear ".$this->reportingEmployee->name."\n".
        $body."\n".
        'ACR Period : '.$acr->from_date->format('d M Y').' to '.$acr->to_date->format('d M Y')."\n".
            "You are hereby intimated for futher action."."\n".
            'Please regularly monitor relevent website/documents and take necessery action. Thank you for being with us!.'."\n";

        //return TelegramMessage::create()
        // Optional recipient user id.
        //->to($notifiable->chat_id)
        // Markdown supported.
         //   ->content($msg)
        //->button('Visit Timeline', $url);
        // (Optional) Blade template for the content.
        // ->view('notification', ['url' => $url])
        // (Optional) Inline Buttons
        //
        return TelegramFile::create()
        ->content($telegramMessage)
        ->document($acr->pdfFullFilePath, 'acr_'.$acr->employee_id.'_id_'.$acr->id.'.pdf');
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
