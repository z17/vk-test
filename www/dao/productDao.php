<?php

namespace Dao;

use PDO;

function getConnection()
{
    static $base = NULL;

    if ($base == NULL) {
        $dbConfig = getConfig()['db'];
        $base = new PDO("mysql:host=" . $dbConfig['host'] . ";dbname=" . $dbConfig['name'], $dbConfig['user'], $dbConfig['password']);
        $base->query("set names utf8");
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
    return $base->lastInsertId();
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

function countProducts()
{
    $query = "SELECT COUNT(id) AS count FROM product";
    $base = getConnection();
    $sql = $base->prepare($query);
    $sql->execute();
    return (int)$sql->fetch()['count'];
}

function countProductsBeforeId($id) {
    $query = "SELECT COUNT(ID) as count FROM product WHERE :id > id";
    $base = getConnection();
    $sql = $base->prepare($query);
    $sql->bindParam(':id', $id);
    $sql->execute();
    return (int)$sql->fetch()['count'];
}

function countProductsBeforePrice($price) {
    $query = "SELECT COUNT(ID) as count FROM product WHERE :price > price";
    $base = getConnection();
    $sql = $base->prepare($query);
    $sql->bindParam(':price', $price);
    $sql->execute();
    return (int)$sql->fetch()['count'];
}

function getProductList($orderType, $limitStart, $limitEnd)
{
    $query = "
      SELECT 
        p.id, p.name, p.description, p.price, p.img 
      FROM product p
      JOIN (
	    SELECT id FROM product ORDER BY $orderType LIMIT :start, :end 
      ) AS i ON i.id = p.id
      ORDER BY $orderType";
    $base = getConnection();
    $sql = $base->prepare($query);
    $sql->bindParam(':start', $limitStart, PDO::PARAM_INT);
    $sql->bindParam(':end', $limitEnd, PDO::PARAM_INT);
    $sql->execute();

    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    return fetchProducts($result);
}

function getProductIdList($orderType, $limitStart, $limitEnd)
{
    $query = "SELECT id FROM product ORDER BY $orderType LIMIT :start, :end ";
    $base = getConnection();
    $sql = $base->prepare($query);
    $sql->bindParam(':start', $limitStart, PDO::PARAM_INT);
    $sql->bindParam(':end', $limitEnd, PDO::PARAM_INT);
    $sql->execute();

    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    return array_map(function ($v) {
        return $v['id'];
    }, $result);
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
        return product(
            $result['id'],
            $result['name'],
            $result['description'],
            $result['price'],
            $result['img']
        );
    }
    return NULL;
}

function getProductsByArray(array $arrayId)
{
    $in = str_repeat('?,', count($arrayId) - 1) . '?';
    $query = 'SELECT id, name, description, price, img FROM product WHERE id IN (' . $in . ')';
    $base = getConnection();
    $sql = $base->prepare($query);
    $sql->execute($arrayId);
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    return fetchProducts($result);

}

function fetchProducts($dbResult)
{
    return array_map(function ($product) {
        return product(
            $product['id'],
            $product['name'],
            $product['description'],
            $product['price'],
            $product['img']
        );
    }, $dbResult);
}

