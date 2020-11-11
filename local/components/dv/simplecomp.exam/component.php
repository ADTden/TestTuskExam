<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arParams["F"] = $_REQUEST['F'];

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;
$countitems = 0;
if($this->startResultCache()){
	$arResult = $this->makeArResult($arParams["ID_CATALOG"],$arParams["CODE_USER_PROP"],$arParams["ID_NEWS"],$arParams["DETAIL_URL"],$arParams["F"]);
	$countitems = $arResult["COUNT_ITEMS"];
	$this->IncludeComponentTemplate();
}
$cnt = $this->getCount($arParams["ID_CATALOG"],$arParams["CODE_USER_PROP"],$arParams["ID_NEWS"],$arParams["DETAIL_URL"],$arParams["F"]);
$APPLICATION->SetTitle("В каталоге товаров представлено товаров: [".$cnt."]");	
?>