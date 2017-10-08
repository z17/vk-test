<?php

namespace View;

function main($productsArray)
{
    $productHtml = file_get_contents('./resources/template/main.html');

    $content = '';
    foreach ($productsArray as $product) {
        $currentHtml = $productHtml;
        $currentHtml = str_replace('[[id]]', $product['id'], $currentHtml);
        $currentHtml = str_replace('[[image]]', $product['image'], $currentHtml);
        $currentHtml = str_replace('[[name]]', $product['name'], $currentHtml);
        $currentHtml = str_replace( '[[price]]', $product['price'], $currentHtml);
        $currentHtml = str_replace('[[description]]', $product['description'], $currentHtml);
        $content .= $currentHtml;
    }

    $html = file_get_contents('./resources/template/template.html');
    $html = str_replace('[[title]]', 'Главная - Vk Test', $html);
    $html = str_replace('[[content]]', $content, $html);
    echo $html;
}


function api()
{

}