<?php

namespace Model;

use Dao;
use Cache;

function getProducts($order, $page)
{
    validateProductOrder($order);
    $pageCacheKey = getPageCacheKey($order, $page);
    $productIds = Cache\get($pageCacheKey);

    if ($productIds === NULL) {
        $limit = getProductsLimit($page);
        $productIds = Dao\getProductIdList($order, $limit[0], $limit[1]);
        Cache\set($pageCacheKey, $productIds);
    }

    $productsCacheKeys = array_map("Model\\getProductCacheKey", $productIds);
    $cacheProductsMap = Cache\getMulti($productsCacheKeys);
    $unknownIds = [];
    $unknownProductsMap = [];
    foreach ($productIds as $id) {
        if (!isset($cacheProductsMap[getProductCacheKey($id)])) {
            $unknownIds[] = $id;
        }

    }

    if (!empty($unknownIds)) {
        $unknownProducts = Dao\getProductsByArray($unknownIds);
        $objToCache = [];
        foreach ($unknownProducts as $product) {
            $unknownProductsMap[$product['id']] = $product;
            $objToCache[getProductCacheKey($product['id'])] = $product;
        }
        Cache\setMulti($objToCache);
    }

    $products = [];
    foreach ($productIds as $id) {
        $cacheKey = getProductCacheKey($id);
        if (isset($cacheProductsMap[$cacheKey])) {
            $products[] = $cacheProductsMap[$cacheKey];
        } elseif (isset($unknownProductsMap[$id])) {
            $products[] = $unknownProductsMap[$id];
        }
    }
    return [
        'products' => $products,
        'max_page' => getMaxPage(),
        'current_page' => $page
    ];
}


function getMaxPage()
{
    $maxPage = Cache\get('max_page');
    if ($maxPage === NULL) {
        $count = Dao\countProducts();
        $maxPage = ceil($count / getConfig()['page_size']);
        Cache\set('max_page', $maxPage);
    }
    return $maxPage;
}

function addProduct($name, $description, $price, $img)
{
    $errors = validateProduct($name, $description, $price, $img);

    $product = product(0, $name, $description, $price, $img);
    if (empty($errors)) {
        $product['id'] = Dao\addProduct($product);
        clearFullPageCacheFromProduct($product);
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
            $product = product($id, $name, $description, $price, $img);
            Dao\updateProduct($product);

            Cache\set(getProductCacheKey($product['id']), $product);

            if ($price !== $product['price']) {
                clearPageCacheFromProduct($product, 'price');
            }

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
    clearFullPageCacheFromProduct($product);
    Cache\delete(getProductCacheKey($id));
}

function clearFullPageCacheFromProduct($product)
{
    clearPageCacheFromProduct($product, 'id');
    clearPageCacheFromProduct($product, 'price');
}

function clearPageCacheFromProduct($product, $order)
{
    switch ($order) {
        case 'id':
            $productsNumber = Dao\countProductsBeforeId($product['id']);
            break;
        case 'price':
            $productsNumber = Dao\countProductsBeforePrice($product['price']);
            break;
        default:
            throw new \Exception("Error");
    }

    $resetStartPage = ceil($productsNumber / getConfig()['page_size']);
    $maxPage = getMaxPage();

    $keys = getPageKeys($order, $resetStartPage, $maxPage);
    Cache\deleteMulti($keys);
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