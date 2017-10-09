<?php

namespace Model;

use Dao;

function getProducts($order, $page)
{
    validateProductOrder($order);
    $limit = getProductsLimit($page);
    return Dao\getProductList($order, $limit[0], $limit[1]);
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