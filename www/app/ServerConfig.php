<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServerConfig extends Model
{
    protected $table = 'server_config';
    protected $primaryKey = 'serverid';
    public $timestamps = false;

    protected $guarded = [
        'name',
        'invite_url',
        'localisation_id'
    ];

    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    public function setCustomCommandAttribute($value)
    {
        $this->attributes['first_name'] = strtolower($value);
    }

    public function custom_commands()
    {
        return $this->hasMany('App\CustomCommands');
    }

    public function channels()
    {
        return $this->hasMany('App\Channels');
    }

    public function roles()
    {
        return $this->hasMany('App\Roles');
    }

    /**
     * Used for hasMany() relations. Would otherwise default to wrong key
     * @return string
     */
    public function getForeignKey()
    {
        return $this->primaryKey;
    }

    public function updateCustomCommands($commands)
    {
        if (!is_array($commands) && count($commands) == 0) {
            return false;
        }
        $commandKeys = array_column($commands, 'commandid');
        $deleteCommands = $this->custom_commands()->whereNotIn('commandid', $commandKeys);
        if ($deleteCommands->count() > 0) {
            $deleteCommands->delete();
        }
        //dd($commands);
        $this->custom_commands()->delete();
        $this->custom_commands()->createMany($commands);
        return true;
    }

    public function updateChannels($channels)
    {
        if (!is_array($channels) && count($channels) == 0) {
            return false;
        }
        $commandKeys = array_column($channels, 'commandid');
        $deleteChannels = $this->channels()->whereNotIn('commandid', $commandKeys);
        if ($deleteChannels->count() > 0) {
            $deleteChannels->delete();
        }
        foreach ($channels as $channel) {
            $this->channels()->updateOrCreate($channel);
        }
        return true;
    }

    public function updateRoles($roles)
    {
        if (!is_array($roles) && count($roles) == 0) {
            return false;
        }
        $commandKeys = array_column($roles, 'roleid');
        $deleteChannels = $this->roles()->whereNotIn('roleid', $commandKeys);
        if ($deleteChannels->count() > 0) {
            $deleteChannels->delete();
        }
        foreach ($roles as $role) {
            $this->roles()->updateOrCreate($role);
        }
        return true;
    }
}
