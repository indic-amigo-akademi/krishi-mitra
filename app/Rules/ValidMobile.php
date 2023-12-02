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
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
     // //1) Begins with 0 or 91
    // 2) Then contains 7 or 8 or 9.
    // 3) Then contains 9 digits
    public function passes($attribute, $value)
    {
        //
        return preg_match('/^[789]\d{9}$/',$value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The mobile number should be valid containing 10 digits';
    }
}
