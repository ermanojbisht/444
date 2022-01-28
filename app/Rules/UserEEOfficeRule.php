<?php

namespace App\Rules;

use App\Helpers\Helper;
use App\Models\User;
use Auth;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Request;

class UserEEOfficeRule implements Rule
{
    /**
     * Create a new rule instance.
     *nonMisworkPermission may be used if we allow non mis works
     *checkSelectedOffice , if form has both work code and ee office then check if they r same
     *officeFormField , ee office field name in form
     * @return void
     */
    protected $nonMisworkPermission;
    protected $checkSelectedOffice;
    protected $officeFormField;
    protected $customMsg='';
    public function __construct($nonMisworkPermission,$checkSelectedOffice,$officeFormField)
    {
        $this->nonMisworkPermission= $nonMisworkPermission;
        $this->checkSelectedOffice= $checkSelectedOffice;
        $this->officeFormField= $officeFormField;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(!$this->nonMisworkPermission){
            
            $user=Auth::User();
            $userAllowdOffice = $user->onlyEEOffice()->pluck('id');
            $divCodeFromWorkCode= Helper::before('W',$value);
            if(!$divCodeFromWorkCode){
                $this->customMsg="Work code does't follow correct patteren like 74W1975";
                return false;
            }
            if($this->checkSelectedOffice){
                $eeOfficeSelected=Request::get($this->officeFormField);
                if ($eeOfficeSelected != $divCodeFromWorkCode){
                    $this->customMsg="Selected Office and work code does't match";
                    return false;
                }
            }
            
            foreach ($userAllowdOffice as $key => $value) {
                if($value==$divCodeFromWorkCode){
                    return true;
                }
            }
                return false;
        }
        return true;   
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if($this->customMsg){
            return $this->customMsg;
        }
        return 'The :attribute is not applicable to logged user as defined in MISPWD.';
    }
}
