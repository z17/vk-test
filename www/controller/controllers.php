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

}

function updateProduct()
{
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    $data = Model\updateProduct($id);

}

function deleteProduct()
{

}
