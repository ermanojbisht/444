<?php

namespace App\Http\Controllers;

use App\Models\User;
//use App\Notifications\WelcomeUserTG;
//use App\TgBotUpdate;
use Auth;
use Illuminate\Http\Request;
use Log;
use Redirect;
use Telegram\Bot\Laravel\Facades\Telegram;
use pschocke\TelegramLoginWidget\Facades\TelegramLoginWidget;

class TelegramBotController extends Controller
{
    /*public function __construct() {
    $this->middleware('auth');
    }*/

    /*public function updatedActivity()
    {
        $response = Telegram::getMe();
        $botId = $response->getId();
        $firstName = $response->getFirstName();
        $username = $response->getUsername();

        return "botId=$botId,firstName=$firstName, username=$username";
    }*/

    /**
     * [checkTelegramIdOfMessegedUser pollling/getupdate method for getting updates
     * @return [type] [description]
     */
    /*public function checkTelegramIdOfMessegedUser()
    {
        /* if (!Laratrust::isAbleTo('check_tel_id')) { //This will check the check_tel_id permission
        abort(403);
        }*/
        //$params['offset'] = $offset = TgBotUpdate::latest()->first()->update_id + 1;
        //$params ['limit']=100;
        //$updates = Telegram::getUpdates($params);
        //Log::info("updates = ".print_r($updates,true));
        //$updates = json_decode($updates,true);
        //$this->processUpdateFromTelegram($updates, false);
        // return view('useradmin.manage.users.chatids',compact('updates'));
    //}*/

    /**
     * [checkTelegramIdOfMessegedUserViaWebhook webhook system for getting updat]
     * @return [type] [description]
     */
    /*public function checkTelegramIdOfMessegedUserViaWebhook()
    {
        $updates = Telegram::getWebhookUpdates();
        //Log::info("updates = ".print_r($updates,true));
        $this->processUpdateFromTelegram($updates, true);

        return 'ok';
    }*/

    /**
     * @param $updates
     * @param $webhook
     */
    /*public function processUpdateFromTelegram($updates, $webhook)
    {
        if ($webhook) {
            $modifiedUpdates = [$updates];
        } else {
            $modifiedUpdates = $updates;
        }
        foreach ($modifiedUpdates as $key => $update) {
            $messageFoundFlag = false;
            //Log::info("update in processUpdateFromTelegram = ".print_r($update,true));
            if (isset($update['message'])) {
                $message = $update['message']; //user sent message
                $messageFoundFlag = true;
            } else {
                if (isset($update['my_chat_member'])) {
                    $message = $update['my_chat_member']; //user left
                } else {
                    $message = $update; //unknown
                }
            }
            $msg = TgBotUpdate::firstOrCreate(['update_id' => $update['update_id']], [
                'message' => $message
            ]);
            //Log::info("telegram msg = ".print_r($msg,true));
            if (0 == $msg->processed && $messageFoundFlag) {
                $msgRecived = " msg initiated";
                if (isset($msg->message['text'])) {
                    $msgRecived = "your Message: ".$msg->message['text']."\n";
                }
                $this->telmsg($msg->message['chat']['id'], "$msgRecived Thanks , we will process your request  shortly :  MISPWD http://pwduk.in  ");
                $msg->processed = 1;
                $msg->save();
                $this->telmsg(-476074323, json_encode($msg->message));
            }
            if (0 == $msg->processed && !$messageFoundFlag) {
                $this->telmsg(59509781, json_encode($msg->message));
            }
        }
    }*/

    /**
     * @param $chatId
     * @param $message
     */
    /*public function telmsg($chatId = 59509781, $message = "new msg")
    {
        return Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => $message
        ]);
    }*/

    /*public function createTelMsg()
    {
        $users = User::where('chat_id', '>', 211111)->orderBy('name')->get();

        return view('messages.index', compact('users'));
    }*/

    /**
     * @param request $request
     */
    /*public function processdoMsg(request $request)
    {
        $request->all();
        $msg = $request->msg;
        $usertype = $request->usertype;
        $users = $request->users;
        if ($msg) {
            foreach ($users as $key => $user) {
                Log::info("user = ".print_r($user, true));
                User::find($user)->notify(new WelcomeUserTG($msg));
            }
            flash()->overlay('office of each user has been updated', 'Success');

            return Redirect::back();
        }
    }*/

    public function connect()
    {
        return view('telegram.connect');
    }

    /**
     * @param Request $request
     */
    public function callback(Request $request)
    {
        /*Log::info("request = ".print_r($request->all(), true));*/
        if (!$telegramUser = TelegramLoginWidget::validate($request)) {
            return 'Telegram Response not valid';
        }
        if (Auth::user()->chat_id <= 10000) {
            //check if provided chat id already used
            $alreadyUserExistForThisChatID=User::where('chat_id', $telegramUser->get('id'))->first();
            if( $alreadyUserExistForThisChatID){
                return "Sorry provided Telegram credential / user is already affiliated with user:".$alreadyUserExistForThisChatID->name;
            }
            Auth::user()->update(['chat_id' => $telegramUser->get('id')]);

            return 'Telegram id updated , now next time you may login through telegram';
        }

        if (Auth::user()->chat_id == $telegramUser->get('id')) {
            return "User Telegram id already exist and same as now";
        }

        return Redirect::back();
    }

    /**
     * @param Request $request
     */
    public function telegramLogged(Request $request)
    {
        Log::info("request = ".print_r($request->all(), true));
        if (!$telegramUser = TelegramLoginWidget::validate($request)) {
            return 'Telegram Response not valid';
        } else {
            $user = User::where('chat_id', $telegramUser->get('id'))->first();
            if ($user) {
                Auth::login($user);

                return redirect()->intended('home');
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.'
            ]);
        }
    }

//$exifcom = 'cd /home/manoj/tg/ && ./bin/telegram-cli -k tg-server.pub -W -e msg Pooja  hello123';
    //$exifcom = 'sh telegram1.sh user#665326725 h0000';
    //$exifcom = 'echo "msg Pooja hgg222222222hh" | nc 127.0.0.1 1234';
    //return shell_exec($exifcom);
    //$exifcom = 'cd /home/manoj/tgscripts/generic/ && ./telegram1.sh user#665326725 hiiiii';
    //$exifcom = 'cd /home/manoj/tgscripts/generic/ && ls -lsa';
    //$process = new Process(['ls', '-lsa']);
    //$process = new Process('sh telegram1.sh user#665326725 h0000');
    //$process = Process::fromShellCommandline('/home/manoj/tgscripts/generic/telegram1.sh user#665326725 h0000');
    //$process->run();
    //$process->wait();
    // executes after the command finishes
    /*if (!$process->isSuccessful()) {
    throw new ProcessFailedException($process);
    }

    return $process->getOutput();*/

//$exifcom = 'cd tg/ && ./bin/telegram-cli -k tg-server.pub && msg Test  hello123';

//return shell_exec($exifcom);
    /* $search=1722;
    return $ForestProposal = \App\ForestProposal::whereRaw("find_in_set('".$search."',users_for_notification)")->get();*/
//->whereRaw("find_in_set('".$search."',users_for_notification)")
    /* $users->toQuery()->update([
    'status' => 'Administrator',
    ]);*/
//$loggedUser= Auth::user();
    /* return $user= \App\User::all()->where('chat_id','>',0)->filter(function($item) ,use $loggedUser {
if($loggedUser->id==$item->id){
return false;
}else{
return true;
}
});*/
}
