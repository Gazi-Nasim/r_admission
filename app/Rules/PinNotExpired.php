<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class PinNotExpired implements Rule
{

    protected $codeTime;
    protected $PIN_EXPIRATION_TIME = 20;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($codeTime)
    {
        $this->codeTime = $codeTime;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $timeDiff = $this->codeTime->diffInMinutes(Carbon::now());

        return ($timeDiff < $this->PIN_EXPIRATION_TIME);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Code Expired. Go back and try again.';
    }

}
