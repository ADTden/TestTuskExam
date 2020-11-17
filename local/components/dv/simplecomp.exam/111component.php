<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arParams["CHECK_PERMISSIONS"] = $arParams["CHECK_PERMISSIONS"]!="N";


if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;

if($this->startResultCache()){
	$arResult = $this->makeArResult($arParams["AUTHOR"],$arParams["CODE_USER_PROP"],$arParams["ID_NEWS"]);
	$this->IncludeComponentTemplate();
}
$APPLICATION->SetTitle("Новостей: [".count($arResult["COUNT_ITEMS"])."]");
?>