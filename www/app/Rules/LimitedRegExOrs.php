<?php

namespace Valkyrja\Rules;

use Illuminate\Contracts\Validation\Rule;

class LimitedRegExOrs implements Rule
{
    protected $limit;
    protected $count = 0;

    /**
     * Create a new rule instance.
     *
     * @param int $limit - How many ors you want to limit to
     */
    public function __construct($limit = 6)
    {
        $this->limit = $limit;
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
        $this->count = preg_match_all("/\\|/", $value) - preg_match_all("/\\\/", $value);
        return $this->count <= $this->limit;
    }
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute can have at most '.$this->limit.' RegEx OR statements ('.$this->count.' given).';
    }
}
