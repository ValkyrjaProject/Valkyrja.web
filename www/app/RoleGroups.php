<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RoleGroups extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = ['serverid', 'groupid'];
    protected $fillable = [
        'groupid',
        'role_limit',
        'name',
    ];

    protected $casts = [
        'groupid' => 'integer',
        'role_limit' => 'integer',
        'name' => 'string',
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

    public function getForeignKey()
    {
        return 'serverid';
    }
}
