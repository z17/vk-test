<?php

namespace View;

// todo: вынести в константы title и пути

function main($productsArray)
{
    $productHtml = file_get_contents('./resources/template/product.html');

    $content = '';
    foreach ($productsArray as $product) {
        $currentHtml = $productHtml;
        $currentHtml = str_replace('[[id]]', $product['id'], $currentHtml);
        $currentHtml = str_replace('[[image]]', $product['img'], $currentHtml);
        $currentHtml = str_replace('[[name]]', $product['name'], $currentHtml);
        $currentHtml = str_replace('[[price]]', $product['price'], $currentHtml);
        $currentHtml = str_replace('[[description]]', $product['description'], $currentHtml);
        $content .= $currentHtml;
    }

    $main = file_get_contents('./resources/template/main.html');
    $main = str_replace('[[products]]', $content, $main);
    echo prepareTemplate($main, 'Главная');
}

function add($data)
{
    $content = file_get_contents('./resources/template/add.html');
    $status = '';
    $name = '';
    $image = '';
    $price = '';
    $description = '';
    if ($data != NULL) {
        if (!empty($data['errors'])) {
            $status = implode(', ', $data['errors']);
            $name = $data['product']['name'];
            $image = $data['product']['img'];
            $price = $data['product']['price'];
            $description = $data['product']['description'];
        } else {
            $status = 'Ok';
        }
    }
    $content = str_replace('[[status]]', $status, $content);
    $content = str_replace('[[name]]', $name, $content);
    $content = str_replace('[[img]]', $image, $content);
    $content = str_replace('[[price]]', $price, $content);
    $content = str_replace('[[description]]', $description, $content);
    echo prepareTemplate($content, 'Добавить продукт');
}

function update($data) {
    $product = $data['product'];

    $errors = '';
    if (!empty($data['errors'])) {
        $errors = implode(', ', $data['errors']);
    }

    $content = file_get_contents('./resources/template/update.html');
    $content = str_replace('[[id]]', $product['id'], $content);
    $content = str_replace('[[name]]', $product['name'], $content);
    $content = str_replace('[[img]]', $product['img'], $content);
    $content = str_replace('[[price]]', $product['price'], $content);
    $content = str_replace('[[description]]', $product['description'], $content);
    $content = str_replace('[[errors]]', $errors, $content);
    echo prepareTemplate($content, 'Редактировать продукт');
}

function delete() {
    $content = file_get_contents('./resources/template/delete.html');
    echo prepareTemplate($content, 'Продукт удалён');
}

function prepareTemplate($content, $title)
{
    $template = file_get_contents('./resources/template/template.html');
    $html = str_replace('[[title]]', $title, $template);
    $html = str_replace('[[content]]', $content, $html);
    return $html;

}