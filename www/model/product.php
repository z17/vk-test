<?php

namespace Model;

use Dao;
use Cache;

function getProducts($order, $page)
{
    validateProductOrder($order);
    $limit = getProductsLimit($page);

    $cacheKey = $order . '_' . $page;
    $cachedData = Cache\get($cacheKey);
    if ($cachedData !== NULL) {
        return [
            'products' => $cachedData['products'],
            'max_page' => $cachedData['max_page'],
            'current_page' => $page
        ];
    }

    $products = Dao\getProductList($order, $limit[0], $limit[1]);
    $count = Dao\countProducts();
    $maxPage = ceil($count / getConfig()['page_size']);

    $resultObject = [
        'products' => $products,
        'max_page' => $maxPage,
    ];

    Cache\set($cacheKey, $resultObject);
    $resultObject['current_page'] = $page;
    return $resultObject;
}

function addProduct($name, $description, $price, $img)
{
    $errors = validateProduct($name, $description, $price, $img);

    $product = product(0, $name, $description, $price, $img);
    if (empty($errors)) {
        Dao\addProduct($product);
    }

    return [
        'errors' => $errors,
        'product' => $product
    ];
}

function updateProduct($tryToAdd, $id, $name, $description, $price, $img)
{
    $product = Dao\getProduct($id);

    if ($product == NULL) {
        throw new \Exception("Unknown product");
    }
    $errors = NULL;
    if ($tryToAdd) {
        $errors = validateProduct($name, $description, $price, $img);

        if (empty($errors)) {
            // todo: may be I should reset memcached, but I haven't any information for it in task
            $product = product($id, $name, $description, $price, $img);
            Dao\updateProduct($product);
        }
    }
    return [
        'errors' => $errors,
        'product' => $product
    ];
}

function deleteProduct($id)
{
    $product = Dao\getProduct($id);

    if ($product == NULL) {
        throw new \Exception("Unknown product");
    }

    Dao\deleteProduct($id);

}

function generateTestData()
{
    throw new \Exception("Unsupported operation");

    // todo: add many rows in one query
    $descData = file_get_contents('./resources/test-data.txt');
    $descArray = explode("\n", $descData);
    $count = 1000000;
    for ($i = 0; $i < $count; $i++) {
        $description = $descArray[rand(0, sizeof($descArray) - 1)];
        $name = mb_substr($description, 0, rand(10, 25));
        $price = rand(50, 1000000);
        $product = product(0, $name, $description, $price, '');
        Dao\addProduct($product);
    }
}

function processError(\Exception $exception)
{
    return $exception->getMessage();
}