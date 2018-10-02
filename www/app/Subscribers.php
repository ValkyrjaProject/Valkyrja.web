<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscribers extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'userid';
    protected $fillable = [
        'has_bonus',
        'premium',
    ];

    protected $casts = [
        'has_bonus' => 'boolean',
        'premium' => 'boolean',
    ];
}
