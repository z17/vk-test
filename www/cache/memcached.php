<?php

namespace Cache;

Use Memcached;

function getMemcached()
{
    static $m = NULL;

    if (!class_exists('Memcached')) {
        return null;
    }

    if ($m == NULL) {
        $cacheConfig = getConfig()['cache'];
        $m = new Memcached();
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
    if ($m -> getResultCode() === Memcached::RES_NOTFOUND) {
        return NULL;
    }
    return $result;
}

function getMulti($keys) {
    $m = getMemcached();
    if ($m == NULL) {
        return [];
    }
    return $m->getMulti($keys);
}

function delete($key) {
    $m = getMemcached();
    if ($m == NULL) {
        return;
    }
    $m->delete($key);
}

function deleteMulti(array $keys) {
    $m = getMemcached();
    if ($m == NULL) {
        return;
    }
    $m->deleteMulti($keys);
}

function set($key, $object)
{
    $m = getMemcached();
    if ($m == NULL) {
        return;
    }

    $m->set($key, $object, getConfig()['cache']['lifetime']);
}

function setMulti(array $data) {
    $m = getMemcached();
    if ($m == NULL) {
        return;
    }

    $m->setMulti($data, getConfig()['cache']['lifetime']);
}