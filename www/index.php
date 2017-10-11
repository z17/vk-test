<?php

require_once 'config.php';
require_once 'data/product.php';
require_once 'dao/productDao.php';
require_once 'cache/memcached.php';
require_once 'controller/controllers.php';
require_once 'model/product.php';
require_once 'model/productHelper.php';
require_once 'view/view.php';

$path = isset($_SERVER["REDIRECT_URL"]) ? $_SERVER["REDIRECT_URL"] : '';

try {
    switch ($path) {
        case '':
            Controller\main();
            break;
        case '/add/':
            Controller\addProduct();
            break;
        case '/update/':
            Controller\updateProduct();
            break;
        case '/delete/':
            Controller\deleteProduct();
            break;
        case '/generate/':
            Controller\generateTestData();
            break;
        default:
            throw new Exception("404");
            break;
    }
} catch (Exception $e) {
    Controller\error($e);
}
