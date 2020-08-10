<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ReactionRoles extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = ['serverid', 'messageid', 'emoji'];
    protected $fillable = [
        'roleid',
        'messageid',
        'emoji',
    ];

    protected $casts = [
        'roleid' => 'string',
        'messageid' => 'string',
    ];

    protected $hidden = [
        'serverid'
    ];

    /**
     * {@inheritdoc}
     */
    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where($this->primaryKey[0], '=', $this->getAttribute($this->primaryKey[0]))
            ->where($this->primaryKey[1], '=', $this->getAttribute($this->primaryKey[1]))
            ->where($this->primaryKey[2], '=', $this->getAttribute($this->primaryKey[2]));
        return $query;
    }

    public function getForeignKey()
    {
        return 'serverid';
    }
}
