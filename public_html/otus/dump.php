<?php 

$now = new DateTime();

\Bitrix\Main\Diag\Debug::dumpToFile($now, 'otusDz.log');

?>