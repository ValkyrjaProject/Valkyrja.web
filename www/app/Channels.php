<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Channels extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'channelid';
    protected $fillable = [
        'channelid',
        'ignored',
        'muted_until'
    ];

    protected $casts = [
        'channelid' => 'string',
        'ignored' => 'boolean',
    ];

    protected function performInsert(Builder $query)
    {
        return parent::performInsert($query);
    }

    public function server_config()
    {
        return $this->belongsTo('App\ServerConfig');
    }

    public function getForeignKey()
    {
        return 'serverid';
    }
}
