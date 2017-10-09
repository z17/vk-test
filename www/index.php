<?php

require_once 'config.php';
require_once 'dao/productDao.php';
require_once 'controller/controllers.php';
require_once 'model/product.php';
require_once 'model/productHelper.php';
require_once 'view/view.php';
require_once 'product.php';

$path = isset($_SERVER["PATH_INFO"]) ? $_SERVER["PATH_INFO"] : '';

switch ($path) {
    case '/':
        Controller\main();
        break;
    case '/add':
        Controller\addProduct();
        break;
    case '/update/':
        Controller\updateProduct();
        break;
    case '/delete/':
        Controller\deleteProduct();
        break;
    default:
        break;
}
