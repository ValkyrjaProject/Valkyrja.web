<?php

namespace Botwinder\Models\Sample;

use Illuminate\Database\Eloquent\Model;

class DiscordRole extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $table = "web__discord_roles";
    protected $fillable = [
        'id',
        'name',
        'color',
        'position',
    ];

    protected $casts = [
        'id' => 'string',
        'guild_id' => 'string',
    ];


    public function guild()
    {
        return $this->belongsTo('Botwinder\Models\Sample\DiscordGuild');
    }

    public function getForeignKey()
    {
        return 'guild_id';
    }
}
