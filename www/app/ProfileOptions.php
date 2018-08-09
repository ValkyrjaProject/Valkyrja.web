<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProfileOptions extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = ['serverid', 'option'];
    protected $fillable = [
        'option',
        'option_alt',
        'label',
        'property_order',
        'inline'
    ];

    protected $casts = [
        'option' => 'string',
        'option_alt' => 'string',
        'label' => 'string',
        'property_order' => 'integer',
        'inline' => 'boolean'
    ];

    /**
     * {@inheritdoc}
     */
    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where($this->primaryKey[0], '=', $this->getAttribute($this->primaryKey[0]))
            ->where($this->primaryKey[1], '=', $this->getAttribute($this->primaryKey[1]));
        return $query;
    }

    public function server_config()
    {
        return $this->belongsTo('App\ServerConfig');
    }

    public function getForeignKey()
    {
        return 'serverid';
    }
}
