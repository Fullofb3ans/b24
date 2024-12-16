<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

$APPLICATION->setTitle('Тест валют');

$APPLICATION->IncludeComponent(
    "otus:table.views",
    "list",
    array(
        "NUM_PAGE" => 20,
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600"
    )
);

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
?>