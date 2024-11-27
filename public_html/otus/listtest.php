<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

$APPLICATION -> setTitle('Тест пейдж');

use Bitrix\Iblock\Iblock;

$iblockId = 17;
$iblockElementId = 65;

$iblock = Iblock::wakeUp($iblockId);
$element = $iblock -> getEntityDataClass()::getByPrimary($iblockElementUd)->fetchObject();

pr($element);


require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';

?>