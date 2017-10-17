<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channels extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'channelid',
        'ignored',
        'temporary',
        'muted_until'
    ];

    public function server_config()
    {
        return $this->belongsTo('App\ServerConfig');
    }

    public function getForeignKey()
    {
        return 'serverid';
    }
}
