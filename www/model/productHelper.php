<?php
namespace Model;

function validateProductOrder($order)
{
    if (!in_array($order, ['id', 'price'])) {
        throw new \Exception('Invalid order type');
    }
}

function validateProduct($name, $description, $price, $img)
{
    $errors = [];
    if ($name == NULL) {
        $errors[] = 'Empty name';
    }
    if ($price == NULL) {
        $errors[] = 'Empty price';
    }
    if ($description == NULL) {
        $errors[] = 'Empty description';
    }
    if ($img == NULL) {
        $errors[] = 'Empty image';
    }
    if (!ctype_digit($price)) {
        $errors[] = 'Invalid price';
    }
    return $errors;
}

function getProductsLimit($pageNumber)
{
    $productsPerPage = getConfig()['page_size'];

    if (!is_numeric($pageNumber) or $pageNumber === 0) {
        $pageNumber = 1;
    }
    return [
        ($pageNumber - 1) * $productsPerPage,
        $productsPerPage
    ];
}

function getProductCacheKey($id)
{
    return 'product_' . $id;
}


function getPageCacheKey($order, $page)
{
    return $order . "_" . $page;
}

function getPageKeys($order, $startPage, $maxPage) {
    $keys = [];
    for ($i = $startPage; $i <= $maxPage; $i++) {
        $keys[]= getPageCacheKey($order, $i);
    }
    return $keys;
}