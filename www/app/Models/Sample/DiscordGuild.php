<?php

namespace Botwinder\Models\Sample;

use Illuminate\Database\Eloquent\Model;

class DiscordGuild extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $table = "web__discord_guilds";
    protected $fillable = [
        'name',
        'icon',
        'owner',
        'owner_id',
        'permissions',
    ];

    protected $casts = [
        'id' => 'string',
        'owner_id' => 'string',
    ];

    public function __get($key)
    {
        if ($key === "roles") {
            return $this->roles();
        }
        else if ($key === "channels") {
            return $this->channels();
        }
        return parent::__get($key);
    }

    public function roles()
    {
        return $this->hasMany('Botwinder\Models\Sample\DiscordRole');
    }

    public function channels()
    {
        return $this->hasMany('Botwinder\Models\Sample\DiscordChannel');
    }

    public function getForeignKey()
    {
        return 'guild_id';
    }
}
