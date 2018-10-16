<?php

namespace Botwinder\Models;

use Illuminate\Database\Eloquent\Model;

class CustomCommand extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'commandid',
        'response',
        'description'
    ];
    protected $hidden = [
        'serverid'
    ];

    public function serverConfig()
    {
        $this->belongsTo('Botwinder\Models\ServerConfig');
    }

    /**
     * Used for hasMany() relations. Would otherwise default to wrong key
     * @return string
     */
    public function getForeignKey()
    {
        return 'serverid';
    }
}
