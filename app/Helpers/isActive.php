<?php

if (!function_exists('isActive')) {
    function isActive($href, $class = 'active') {
        return $class = (strpos(Route::currentRouteName(), $href) === 0 ? $class : '');
    }
    
    function menuOpen($href, $class = 'menu-open') {
        return $class = (strpos(Route::currentRouteName(), $href) === 0 ? $class : '');
    }

}