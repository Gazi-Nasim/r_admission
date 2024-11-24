<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidPin implements Rule
{
    private $verification_code;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($verification_code)
    {
        $this->verification_code = $verification_code;
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
        return $value == $this->verification_code;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid verification code';
    }
}
