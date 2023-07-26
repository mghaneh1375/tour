<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class InForm implements Rule
{
    private $ids = [];
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($ids)
    {
        $counter = 0;
        foreach ($ids as $id)
            $this->ids[$counter++] = $id->id;
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
        return in_array($value, $this->ids);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
