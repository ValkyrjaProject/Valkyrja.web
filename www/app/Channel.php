<?php

namespace Botwinder;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
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
        $this->muted_until = (new DateTime())->setTimestamp(0);
        return parent::performInsert($query);
    }

    public function serverConfig()
    {
        return $this->belongsTo('Botwinder\ServerConfig');
    }

    public function getForeignKey()
    {
        return "serverid";
    }
}
