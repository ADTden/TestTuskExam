<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;

if($this->startResultCache()){
	$arResult = $this->makeArResult($arParams["ID_CATALOG"],$arParams["CODE_USER_PROP"],$arParams["ID_NEWS"]);
	$this->IncludeComponentTemplate();
}
$APPLICATION->SetTitle("В каталоге товаров представлено товаров: [".$arResult["COUNT_ITEMS"]."]");	
?>