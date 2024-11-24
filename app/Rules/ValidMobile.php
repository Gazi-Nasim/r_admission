<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidMobile implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        if ( strlen($value) != 11 ) return false;

        if ( !is_numeric($value) ) return false;

        $prefix       = substr($value, 0, 3);
        $valid_prefix = array('013', '014', '015', '016', '017', '018', '019');

        return in_array($prefix, $valid_prefix);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid Mobile Number.';
    }
}
