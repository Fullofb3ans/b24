<?php 

use Bitrix\iblock\iblock;
Loader::includeModule('iblock');

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

$APPLICATION -> setTitle('Тест пейдж');

$iblockId = 16;
$iblockElementId = 29;

$arFilter = ['IBLOCK_ID' => $iblockId, 'ACTIVE'=> 'Y'];
$arSelect = ['ID', 'NAME', 'CODE', 'PROPERTY_MODEL'];

$res = CIBlockElement::getList([], $arfilter, false, [], $arSelect);
while($arFields = $res-> fetch())
{
    pr($arFields);
}


require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';

?>