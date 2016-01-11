<?php
 
 
function query_user($fields, $uid = null)
{
     
 
}

function read_query_user_cache($uid, $field)
{
    return S("query_user_{$uid}_{$field}");
}

function write_query_user_cache($uid, $field, $value)
{
    return S("query_user_{$uid}_{$field}", $value, 1800);
}

function clean_query_user_cache($uid, $field)
{
    if (is_array($field)) {
        foreach ($field as $field_item) {
            S("query_user_{$uid}_{$field_item}", null);
        }
    }
    S("query_user_{$uid}_{$field}", null);
}