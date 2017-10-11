<?php

function product($id, $name, $description, $price, $img)
{
    return [
        'id' => (int)$id,
        'name' => $name,
        'description' => $description,
        'price' => (int)$price,
        'img' => $img
    ];
}