<?php

namespace Cache;

function getMemcached()
{
    static $m = NULL;

    if (!class_exists('\Memcached')) {
        return null;
    }

    if ($m == NULL) {
        $cacheConfig = getConfig()['cache'];
        $m = new \Memcached();
        $m->addServer($cacheConfig['host'], $cacheConfig['port']);
    }
    return $m;
}

function get($key)
{
    $m = getMemcached();
    if ($m == NULL) {
        return NULL;
    }
    $result = $m->get($key);
    if ($result === false) {
        return NULL;
    }
    return $result;
}

function set($key, $object)
{
    $m = getMemcached();
    if ($m == NULL) {
        return;
    }

    $m->set($key, $object, getConfig()['cache']['lifetime']);
}

