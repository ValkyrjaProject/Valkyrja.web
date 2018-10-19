<?php

namespace Valkyrja\Models\Sample;

use Illuminate\Database\Eloquent\Model;

class DiscordUser extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $table = "web__discord_users";
    protected $fillable = [
        'id',
        'name',
        'discriminator',
        'avatar',
        'verified',
        'email',
    ];
}
