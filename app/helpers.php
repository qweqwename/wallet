<?php

use Illuminate\Support\Facades\Route;

if(!function_exists('active_link')){
    function active_link($name, $active = 'active'){
        return Route::is($name) ? $active : '';
    }
}
