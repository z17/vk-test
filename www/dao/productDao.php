<?php

namespace Dao;

use PDO;

function getConnection()
{
    static $base = NULL;

    if ($base == NULL) {
        $dbConfig = getConfig()['db'];
        $base = new PDO("mysql:host=" . $dbConfig['host'] . ";dbname=" . $dbConfig['name'], $dbConfig['user'], $dbConfig['password']);
    }
    return $base;
}

function addProduct($product)
{
    $query = 'INSERT INTO product (name, price, img, description) VALUES (:name, :price, :img, :description)';
    $base = getConnection();
    $sql = $base->prepare($query);
    $sql->bindParam(':name', $product['name']);
    $sql->bindParam(':description', $product['description']);
    $sql->bindParam(':price', $product['price']);
    $sql->bindParam(':img', $product['img']);
    $sql->execute();
}

function updateProduct($product)
{
    $query = 'UPDATE product SET 
      name = :name,
      description = :description,
      price = :price,
      img = :img
    WHERE id = :id';
    $base = getConnection();
    $sql = $base->prepare($query);
    $sql->bindParam(':name', $product['name']);
    $sql->bindParam(':description', $product['description']);
    $sql->bindParam(':price', $product['price']);
    $sql->bindParam(':img', $product['img']);
    $sql->bindParam(':id', $product['id']);
    $sql->execute();
}

function deleteProduct($id)
{
    $query = "DELETE FROM product WHERE id = :id";
    $base = getConnection();
    $sql = $base->prepare($query);
    $sql->bindParam(':id', $id);
    $sql->execute();
}

function getProductList($orderType, $limitStart, $limitEnd)
{
    $query = "SELECT id, name, description, price, img FROM product ORDER BY $orderType LIMIT :start, :end";
    $base = getConnection();
    $sql = $base->prepare($query);
    $sql->bindParam(':start', $limitStart, PDO::PARAM_INT);
    $sql->bindParam(':end', $limitEnd, PDO::PARAM_INT);
    $sql->execute();

    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    $products = [];
    foreach ($result as $product) {
        $products[] = product(
            $product['id'],
            $product['name'],
            $product['description'],
            $product['price'],
            $product['img']
        );
    }
    return $products;
}

function getProduct($id)
{
    $query = "SELECT id, name, description, price, img FROM product WHERE id = :id";
    $base = getConnection();
    $sql = $base->prepare($query);
    $sql->bindParam(':id', $id);
    $sql->execute();

    $result = $sql->fetch(PDO::FETCH_ASSOC);
    if ($result !== false) {
        return $products[] = product(
            $result['id'],
            $result['name'],
            $result['description'],
            $result['price'],
            $result['img']
        );
    }
    return NULL;
}