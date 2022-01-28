@component('mail::message')
Dear {{$user->name}}
@component('mail::panel')
Your account has been activated. You may login.<br>
Login Credentials: <br>
<ul>
	<li>user name is your mail id:  {{$user->email}}</li>
	<li>Password: {{config('site.defaultPass')}}</li>
</ul>
@component('mail::button', ['url' => 'http://pwduk.in:81/pwd'])
MISPWD
@endcomponent
@if($user->chat_id<10000)
If you have not installed Telegram app then install the application.<br>
After installation follow these 2 step <br>
Step 1-search for 'PWD Uttarakhand Alarms' or mkb_bg_bot on telegram app<br>
step 2- Send a message about himself ' like name, contact no, unique email id and office name' on 'PWD Uttarakhand Alarms'.<br>
You may follow this video. 
@component('mail::button', ['url' => 'http://pwduk.in:81/dms/index.php/download/128-website-software-trainning-material/1276-subscribe-telegram-bot-for-pwd-alerts','color' => 'green'])
Trainning video for above process
@endcomponent
<small>(Telegram is a cross-platform cloud-based instant messaging app avilable on android, ios and pc)https://telegram.org/</small>
@endif
@endcomponent
@if($user->remark)
<small>**{{$user->remark}}</small><br>
@endif
Thanks,<br>
{{ config('app.name') }}
@endcomponent
