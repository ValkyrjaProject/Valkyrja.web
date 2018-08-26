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

    public function getAttributeValue($key)
    {
        $value = $this->getAttributeFromArray($key);
        if ($this->isColorAttribute($key)) {
            return "#".str_pad(dechex($value), 6, "0", STR_PAD_LEFT);
        }

        return parent::getAttributeValue($key);
    }

    public function setAttribute($key, $value)
    {
        $parent = parent::setAttribute($key, $value);
        if ($this->isColorAttribute($key)) {
            $this->attributes[$key] = hexdec($value);
        }
        return $parent;
    }

    protected function isColorAttribute($key) {
        return preg_match('/^color_/', $key);
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

    public function profile_options()
    {
        return $this->hasMany('App\ProfileOptions');
    }

    public function role_groups()
    {
        return $this->hasMany('App\RoleGroups');
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
        $this->custom_commands()->whereNotIn('commandid', $commands)->delete();
        foreach ($commands as $command) {
            $this->custom_commands()->updateOrInsert(
                [
                    'serverid' => $this->serverid,
                    'commandid' => $command['commandid']
                ], $command);
        }
        return true;
    }

    public function updateChannels($channels)
    {
        if (!is_array($channels) && count($channels) == 0) {
            return false;
        }
        $commandKeys = array_column($channels, 'channelid');
        $deleteChannels = $this->channels()->whereNotIn('channelid', $commandKeys);
        if ($deleteChannels->count() > 0) {
            $deleteChannels->update(['ignored' => 0]);
        }
        foreach ($channels as $channel) {
            //$this->channels()->updateOrCreate($channel);
            $this->channels()->updateOrCreate(['channelid' => $channel['channelid']], $channel);
        }
        return true;
    }

    public function updateRoles($roles)
    {
        if (!is_array($roles) && count($roles) == 0) {
            return false;
        }
        $commandKeys = array_column($roles, 'roleid');
        $deleteRoles = $this->roles()->whereNotIn('roleid', $commandKeys);
        if ($deleteRoles->count() > 0) {
            $deleteRoles->delete();
        }
        foreach ($roles as $role) {
            $this->roles()->updateOrCreate(['roleid' => $role['roleid']], $role);
        }
        return true;
    }

    public function updateProfileOptions($profile_options)
    {
        if (!is_array($profile_options) && count($profile_options) == 0) {
            return false;
        }
        $commandKeys = array_column($profile_options, 'option');
        $toBeDeleted = $this->profile_options()->whereNotIn('option', $commandKeys);
        if ($toBeDeleted->count() > 0) {
            $toBeDeleted->delete();
        }
        foreach ($profile_options as $profile_option) {
            $this->profile_options()->updateOrCreate(['option' => $profile_option['option']], $profile_option);
        }
        return true;
    }

    public function updateRoleGroups($role_groups)
    {
        if (!is_array($role_groups) && count($role_groups) == 0) {
            return false;
        }
        $commandKeys = array_column($role_groups, 'groupid');
        $toBeDeleted = $this->role_groups()->whereNotIn('groupid', $commandKeys);
        if ($toBeDeleted->count() > 0) {
            $toBeDeleted->delete();
        }
        foreach ($role_groups as $role_group) {
            $this->role_groups()->updateOrCreate(['groupid' => $role_group['groupid']], $role_group);
        }
        return true;
    }
}
