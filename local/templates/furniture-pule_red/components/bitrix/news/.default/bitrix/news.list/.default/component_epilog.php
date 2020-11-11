<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;

if (isset($arResult['SPECIALDATE']) && $arParams["DISPLAY_SPECIALDATE"] == "Y"){

   	$APPLICATION->SetPageProperty("specialdate",$arResult['SPECIALDATE']);
}
?>

