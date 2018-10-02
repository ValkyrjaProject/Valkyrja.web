<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partners extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'serverid';
    protected $fillable = [
        'serverid',
        'premium',
    ];

    protected $casts = [
        'serverid' => 'integer',
        'premium' => 'boolean',
    ];
}
