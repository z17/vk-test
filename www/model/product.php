<?php

namespace Model;

function getProducts($order, $page) {
    return [
        product(1, 'Test 1', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', 512, 'https://www.crystals.ru/uploads/local/field_photo/article_670/vozvrat-tovara.png'),
        product(2, 'Test 2', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', 512, 'https://www.crystals.ru/uploads/local/field_photo/article_670/vozvrat-tovara.png'),
        product(3, 'Test 3', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', 512, 'https://www.crystals.ru/uploads/local/field_photo/article_670/vozvrat-tovara.png'),
        product(4, 'Test 4', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', 512, 'https://www.crystals.ru/uploads/local/field_photo/article_670/vozvrat-tovara.png'),
        product(5, 'Test 5', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', 512, 'https://www.crystals.ru/uploads/local/field_photo/article_670/vozvrat-tovara.png')
    ];
}

function addProduct($product) {

}

function updateProduct($product) {
    return $product;
}

function deleteProduct($id) {
    
}