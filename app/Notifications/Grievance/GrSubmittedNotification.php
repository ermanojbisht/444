<?php

namespace App\Notifications\Grievance;

use App\Models\HrGrievance\HrGrievance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GrSubmittedNotification extends Notification
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $creater=$this->hrGrievance->creator;
        $updationDate=$this->hrGrievance->updated_at->format('d M y');
        switch ($this->milestone) {
            case 'submit':
                $cc=[]; //employee and final person
                if($creater->email){
                    $cc[]=$creater->email;
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
            case 'final':
                $cc=[]; //final and draft person
                $line='Grievance from '. $creater->shriName .
                ' has been finalised with due diligence. If You are unsatisfied then may file further grievance  through the web portal.';
                break;
        }


        return (new MailMessage)
                    ->subject('Grievance '.$this->hrGrievance->id.' on'.now())
                    ->line($line)
                    ->line('Thank you ! We all here to develop a better work culture')
                    ->cc($cc);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
