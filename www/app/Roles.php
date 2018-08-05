<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'roleid';
    protected $fillable = [
        'roleid',
        'permission_level',
        'public_id',
        'antispam_ignored',
        'level'
    ];

    protected $casts = [
        'roleid' => 'string',
        'public_id' => 'string',
        'level' => 'string',
        'permission_level' => 'string',
        'antispam_ignored' => 'boolean'
    ];

    protected $hidden = [
        'serverid'
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
