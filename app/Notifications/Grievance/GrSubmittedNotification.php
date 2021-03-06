<?php

namespace App\Notifications\Grievance;

use App\Channels\SmsChannel;
use App\Channels\SmsMessage;
use App\Models\HrGrievance\HrGrievance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class GrSubmittedNotification extends Notification implements ShouldQueue
{
    public $hrGrievance;
    public $milestone;

    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(HrGrievance $hrGrievance, $milestone)
    {
        //
        $this->hrGrievance = $hrGrievance;
        $this->milestone = $milestone;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if($notifiable->chat_id>10000){
            return ['mail',TelegramChannel::class];
        }
        return ['mail', SmsChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        list($line,$cc)=$this->makeMsg();      

        return (new MailMessage)
                    ->subject('Grievance '.$this->hrGrievance->id.' on'.now())
                    ->line($line)
                    ->line('Thank you ! We all here to develop a better work culture')
                    ->cc($cc);
    }

    public function toTelegram($notifiable)
    {        
        list($line,$cc)=$this->makeMsg();
        return TelegramMessage::create()->content($line);          
    }

    public function toSms($notifiable)
    {
        list($line,$cc)=$this->makeMsg();
        return (new SmsMessage )
                ->templateId('1507162892814168027')
                ->to($notifiable->contact_no)
                ->line($line);
    }

    public function makeMsg()
    {
        $creater=$this->hrGrievance->creator;
        $updationDate=$this->hrGrievance->updated_at->format('d M y');
        $cc=[]; 
        switch ($this->milestone) {
            case 'submit':
                //employee and final person
                if($creater->email){
                    $cc[]=$creater->email;
                }
                $finalPerson=$this->hrGrievance->userFor('hr-gr-final');
                if( $finalPerson ){
                    $cc[]=$finalPerson->email;
                }
                $line='A new Grievance has been recieved from '.
                $creater->shriName .' on '. $updationDate.
                ' Please Acknowledge dissatisfaction,Define the problem,Get the facts, Analyse and decide, Follow up .';
                break;
            case 'draft':
                $cc=[]; //none
                $line='Grievance from '.  $creater->shriName .
                ' has been worked by drafting officer on '. $updationDate.' Please Analyse and decide and do further action .';
                break;
            case 'final'://final and draft person
                $finalPerson=$this->hrGrievance->userFor('hr-gr-final');
                if( $finalPerson ){
                    $cc[]=$finalPerson->email;
                } 
                $draftPerson=$this->hrGrievance->userFor('hr-gr-draft');
                if( $draftPerson ){
                    $cc[]=$draftPerson->email;
                } 
                $line='Grievance from '. $creater->shriName .
                ' has been finalised with due diligence. If You are unsatisfied then may file further grievance  through the web portal.';
                break;
        }
        return [$line,$cc];
    }

    
}
