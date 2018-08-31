<?php

namespace Botwinder\Http;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class Helpers {
    public static function setActive($path, $active = 'is-active') {
        return  Str::contains(Request::path(), $path) ? $active : '';
    }
}
