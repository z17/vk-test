<?php

function product($id, $name, $description, $price, $img)
{
    return [
        'id' => $id,
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'image' => $img
    ];
}