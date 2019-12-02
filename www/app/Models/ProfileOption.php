<?php

namespace Valkyrja\models;

use Illuminate\Database\Eloquent\Model;

class ProfileOption extends Model
{
    public $table = "profile_options";
    public $timestamps = false;
    protected $primaryKey = 'option';
    protected $fillable = [
        'property_order',
        'option',
        'option_alt',
        'label',
        'inline',
    ];

    protected $casts = [
        'property_order' => 'integer',
        'option' => 'string',
        'option_alt' => 'string',
        'label' => 'string',
        'inline' => 'boolean',
    ];

    protected $hidden = [
        'serverid'
    ];

    public function serverConfig()
    {
        return $this->belongsTo('Valkyrja\Models\ServerConfig');
    }

    public function getForeignKey()
    {
        return 'serverid';
    }
}
