<?php

namespace App\Rules;

use App\User;
use Illuminate\Contracts\Validation\Rule;

class StatusUserRule implements Rule
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
    public function passes($attribute, $value)
    {
        return User::where('email', $value)->where('status', 1)->first() ? true : false ;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Email Not Verification Click Resend <a href="#">Activation</a>';
    }
}
