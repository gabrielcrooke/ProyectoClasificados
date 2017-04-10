<?php


function osc_cache_add($key, $data, $expire = 0) {
    $key .= osc_current_user_locale();
    return Object_Cache_Factory::newInstance()->add($key, $data, $expire);
}

function osc_cache_close() {
    return Object_Cache_Factory::newInstance()->close();
}

function osc_cache_delete($key) {
    $key .= osc_current_user_locale();
    return Object_Cache_Factory::newInstance()->delete($key);
}

function osc_cache_flush() {
    return Object_Cache_Factory::newInstance()->flush();
}

function osc_cache_init() {
    Object_Cache_Factory::newInstance();
}

function osc_cache_get($key, &$found) {
    $key .= osc_current_user_locale();
    return Object_Cache_Factory::newInstance()->get($key, $found);
}

function osc_cache_set($key, $data, $expire = 0) {
    $key .= osc_current_user_locale();
    return Object_Cache_Factory::newInstance()->set($key, $data, $expire);
}
?>