<?php

namespace Model;

use Dao;

function getProducts($order, $page) {
    // todo: validation $order, $page, generate LIMIT from $page
    return Dao\getProductList($order, 0, 10);
}

function addProduct($product) {

}

function updateProduct($product) {
    return $product;
}

function deleteProduct($id) {
    
}