<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meetings extends Model
{
    /**
     * Transform the body cell to markdown
     *
     * @param $value
     * @return string
     */
    public function getBodyAttribute($value)
    {
        return markdown($value);
    }
}
