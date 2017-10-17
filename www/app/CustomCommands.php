<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomCommands extends Model
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

    public function server_config()
    {
        $this->belongsTo('App\ServerConfig');
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
