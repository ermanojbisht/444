<?php

namespace App\Rules;

use App\Models\WorkDetail;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Request;

class DateNotGreaterThen implements Rule
{
    /**
     * @var mixed
     */
    private $customMsg;
    /**
     * @var mixed
     */
    private $AA_DATE;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($customMsg)
    {
        $this->customMsg = $customMsg;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(Request::get('WORK_code')!=''){//for bond without work , no check required
            $work = WorkDetail::find(Request::get('WORK_code'));
            $this->AA_DATE = $work->AA_DATE;
            $thisdate = Carbon::parse($value);
            return $thisdate->gt($this->AA_DATE);
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
        if ($this->customMsg) {
            return $this->customMsg.' '.$this->AA_DATE->format('Y-m-d');
        }

        return 'Date cannot be less then work sanction date';
    }
}
