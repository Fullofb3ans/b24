<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arCurrentValues */

if(!CModule::IncludeModule("iblock"))
	return;

if(!CModule::IncludeModule("currency"))
    return;

// Получаем список валют
$arCurrencies = array();
$rsCurrencies = CCurrency::GetList(($by="sort"), ($order="asc"));
while ($arCurrency = $rsCurrencies->Fetch())
{
    $arCurrencies[$arCurrency["CURRENCY"]] = $arCurrency["CURRENCY"];
}

$arComponentParameters = array(
    "GROUPS" => array(
        "LIST"=>array(
            "NAME"=>GetMessage("GRID_PARAMETERS"),
            "SORT"=>"300"
        )
    ),
    "PARAMETERS" => array(
        "CURRENCY" => array(
            "PARENT" => "LIST",
            "NAME" => "Валюта",
            "TYPE" => "LIST",
            "VALUES" => $arCurrencies,
            "DEFAULT" => "RUB"
        )
    )
);
