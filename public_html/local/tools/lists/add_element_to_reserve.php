<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

if (!CModule::IncludeModule('iblock')) {
    die();
}

$iblockId = $_POST['iblockId'];
$fields = $_POST['fields'];

$el = new CIBlockElement;

$reserveArray = Array(
    "IBLOCK_ID"      => $iblockId,
    "NAME"           => $fields['NAME'],
    "ACTIVE"         => "Y",
    "PROPERTY_VALUES"=> array(
        "FIO_RESERVE" => $fields['FIO_RESERVE'],
        "DATE_RESERVE" => $fields['DATE_RESERVE'],
        "PROTSEDURA_RESERVE" => $fields['PROTSEDURA_RESERVE']
    )
);

$elementId = $el->Add($reserveArray);

if($elementId) {
    echo json_encode(['success' => true, 'id' => $elementId]);
} else {
    echo json_encode(['success' => false, 'error' => $el->LAST_ERROR]);
}