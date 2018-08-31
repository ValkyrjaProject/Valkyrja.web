<?php

namespace Botwinder;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'roleid';
    protected $fillable = [
        'roleid',
        'permission_level',
        'public_id'
    ];

    protected $casts = [
        'roleid' => 'string',
        'public_id' => 'string',
        'level' => 'string',
        'permission_level' => 'string'
    ];

    protected $hidden = [
        'serverid'
    ];

    public function serverConfig()
    {
        return $this->belongsTo('Botwinder\ServerConfig');
    }

    public function getForeignKey()
    {
        return 'serverid';
    }
}
