<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

$APPLICATION -> setTitle('Дз №1');

$now = new DateTime();

\Bitrix\Main\Diag\Debug::dumpToFile($now, 'otusDz.log');

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';