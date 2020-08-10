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
        'auto_announce',
        'muted_until'
    ];

    protected $casts = [
        'channelid' => 'string',
        'ignored' => 'boolean',
        'auto_announce' => 'boolean',
    ];

    protected $hidden = [
        'serverid'
    ];

    protected function performInsert(Builder $query)
    {
        $this->muted_until = (new DateTime())->setDate(1,1,1)->setTime(0,0,0,0);
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
