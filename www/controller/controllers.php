<?php

namespace Controller;

use Model;
use View;

function main()
{
    $order = isset($_GET['order']) ? $_GET['order'] : 'id';
    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    $data = Model\getProducts($order, $page);
    View\main($data);
}

function addProduct()
{
    $method = $_SERVER['REQUEST_METHOD'];
    $data = NULL;

    if ($method === 'POST') {
        $name = isset($_POST['name']) ? $_POST['name'] : NULL;
        $description = isset($_POST['description']) ? $_POST['description'] : NULL;
        $price = isset($_POST['price']) ? $_POST['price'] : NULL;
        $img = isset($_POST['img']) ? $_POST['img'] : NULL;

        $data = Model\addProduct($name, $description, $price, $img);
    }

    View\add($data);
}

function updateProduct()
{
    $tryToAdd = $_SERVER['REQUEST_METHOD'] === 'POST' ? true : false;
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $name = isset($_POST['name']) ? $_POST['name'] : NULL;
    $description = isset($_POST['description']) ? $_POST['description'] : NULL;
    $price = isset($_POST['price']) ? $_POST['price'] : NULL;
    $img = isset($_POST['img']) ? $_POST['img'] : NULL;

    $data = Model\updateProduct($tryToAdd, $id, $name, $description, $price, $img);

    View\update($data);
}

function deleteProduct()
{
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    Model\deleteProduct($id);

    View\delete();
}

function generateTestData() {
    Model\generateTestData();
}

function error($exception)
{
    $message = Model\processError($exception);
    View\error($message);
}