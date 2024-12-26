<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$nav = new \Bitrix\Main\UI\PageNavigation('report_list');
$nav->allowAllRecords(false)->setPageSize($arParams['NUM_PAGE'])->initFromUri();
$nav->setRecordCount($arResult['COUNT']);

?>

<?
$APPLICATION->IncludeComponent(
    "otus:table.views",
    "list",
    array(
        "NUM_PAGE" => 20,
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600"
    )
);
?>

