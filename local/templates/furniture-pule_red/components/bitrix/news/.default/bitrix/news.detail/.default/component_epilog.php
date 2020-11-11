<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (isset($arResult['REL_CANONICAL'])){
	 $APPLICATION->SetPageProperty("canonical_link",$arResult['REL_CANONICAL']);
}