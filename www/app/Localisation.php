<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Localisation extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    public $table = 'localisation';
    protected $primaryKey = 'id';

    protected $guarded = [
        'id'
    ];

    protected $hidden = [
        'id'
    ];

    public static function getDefaults()
    {
        $results = DB::select('
            SELECT column_name, column_default 
            FROM information_schema.columns 
            WHERE 
                table_schema = ? 
                AND table_name = ?
                AND column_name != "id"
        ', [env('DB_DATABASE'), "localisation"]);

        // Flatten the results to get an array of the default values
        return collect($results)->flatMap(function ($r) {
            $map = [];
            $map[$r->column_name] = preg_replace('/\\\\\\\n/', '\\r\\n', trim($r->column_default, "'"));
            return $map;
        });
    }
}
