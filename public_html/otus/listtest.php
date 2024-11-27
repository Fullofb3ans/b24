<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

$APPLICATION -> setTitle('Тест пейдж');

use Bitrix\Iblock\Iblock;

$iblockId = 17;
$iblockElementId = 30;

$iblock = Iblock::wakeUp($iblockId);
$element = $iblock -> getEntityDataClass()::getByPrimary($iblockElementId)->fetchObject();

$name = $element->get('NAME');

pr($name);

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';

?>