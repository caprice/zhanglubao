<?php
 
if(!function_exists('boolval')) {
    function boolval($x) {
        return $x ? true : false;
    }
}

function arrayval($x) {
    return is_array($x) ? $x : array();
}