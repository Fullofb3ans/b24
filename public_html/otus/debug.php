<?php 

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

$APPLICATION -> setTitle('Пример отладки');
\Bitrix\Main\Diag\Debug::dump([1, 2, 3, 4]);
$APPLICATION -> setTitle('Дз №1');
$now = new DateTime();

\Bitrix\Main\Diag\Debug::dumpToFile($now, 'otusDz.log');
getSql();

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';

?>