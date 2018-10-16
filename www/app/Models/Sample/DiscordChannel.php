<?php

namespace Botwinder\Models\Sample;

use Illuminate\Database\Eloquent\Model;

class DiscordChannel extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $table = "web__discord_channels";
    protected $fillable = [
        'id',
        'name',
        'type',
        'guild_id',
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
