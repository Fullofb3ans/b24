<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

$APPLICATION -> setTitle('Пример отладки');
\Bitrix\Main\Diag\Debug::dump([1, 2, 3, 4]);
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';