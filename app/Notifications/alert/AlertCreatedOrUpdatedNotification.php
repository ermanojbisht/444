<?php

namespace App\Notifications\alert;

use App\Helpers\Helper;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class AlertCreatedOrUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $alertProject;
    public $user;
    public $key;
    public $msg;
    public function __construct($alertProject,$user,$key)
    {
        $this->alertProject=$alertProject;
        $this->user=$user;
        $this->key=$key;
        $this->makeMsg();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //return ['mail'];//,TelegramChannel::class,'database'
        return ['mail',TelegramChannel::class,'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        //although direct mail msg may be made but we have created a markdown mail
        return (new MailMessage)
        ->subject($this->msg['subject']." ".now())
        ->markdown('notification.alertCreatedOrUpdated',$this->msg);
    }
    /**
     * [toTelegram description]
     * @param  [type] $notifiable [description]
     * @return [type]             [description]
     */
    public function toTelegram($notifiable)
    {
        $makeMsg=$this->msg;
        $msg="*".$makeMsg['subject']."*\n".
            $makeMsg['greeting']."\n".        
            $makeMsg['alert_for']."\n".        
            "*".$makeMsg['work_name']."*\n".        
            "Details are:"."\n".        
            "Refference no:".$makeMsg['refference_no']."\n".        
            "Issuing authority:".$makeMsg['issuing_authority']."\n".        
            "contractor details:".$makeMsg['contractor_details']."\n".        
            "Amount in Lakh:".$makeMsg['amount']."\n".        
            "Valid upto:".$makeMsg['valid_upto']."\n".        
            $makeMsg['closing_lines']."\n";   
            

        return TelegramMessage::create()
            // Optional recipient user id.
            //->to($notifiable->chat_id)
            // Markdown supported.
            ->content($msg);
            //->button('Visit Timeline', $url);
            // (Optional) Blade template for the content.
            // ->view('notification', ['url' => $url])
            // (Optional) Inline Buttons  
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
    public function toDatabase($notifiable)
    {
        return $this->msg;
    }

    public function makeMsg()
    {
        $alertProject=$this->alertProject;
        //$counter=$alertProject->userForNotification[$this->key]->pivot->counter;
        $AlertType=$alertProject->AlertType;       
        $alert_for="Alert For : $AlertType->type";        
        $work_name=$alertProject->project_detail;
        if(Helper::isStringValidWorkCode($work_name)){
            $work_name=$alertProject->workDashboard->WORK_name;
            $work_name=$work_name."(".$alertProject->project_detail.")";
        }
        $createrName=User::find($alertProject->created_by)->name;
        if($alertProject->created_at==$alertProject->updated_at){
            //new Alert
            $subject='New '.$AlertType->type.' added by '.$createrName;
        }else{
            //Alert updated
            $subject='Updation of '.$AlertType->type.' added by '.$createrName;
        }
         
       $this->msg= [
            'subject'=>$subject,            
            'greeting'=>"Dear ".$this->user->name,
            'alert_for'=>$alert_for,
            'work_name'=>"Work Name : ".$work_name,
            'refference_no'=>$alertProject->refference_no,
            'issuing_authority'=>$alertProject->issuing_authority,
            'contractor_details'=>$alertProject->contractor_details,
            'amount'=>$alertProject->amount,
            'valid_upto'=>$alertProject->valid_upto,
            'closing_lines'=>"Please regularly monitor relevent documents and take necessery action. Thank you for being with us!",
        ];
    }
}
