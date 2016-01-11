<?php
/**
 * Created by PhpStorm.
 * User: caipeichao
 * Date: 4/3/14
 * Time: 5:15 PM
 */

/**
 * 自动缓存
 * @param $key
 * @param $interval
 * @param $func
 * @return mixed
 */
function op_cache($key, $func, $interval) {
    $result = S($key);
    if(!$result) {
        $result = $func();
        S($key, $result, $interval);
    }
    return $result;
}