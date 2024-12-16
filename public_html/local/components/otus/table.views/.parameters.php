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
    $arCurrencies[$arCurrency["CURRENCY"]] = "[" . $arCurrency["CURRENCY"] . "] " . $arCurrency["FULL_NAME"];
}

$arComponentParameters = array(
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
