<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;
echo $cp->arResult['SPECIALDATE'];
if (isset($arResult['SPECIALDATE']) && $arParams["DISPLAY_SPECIALDATE"] == "Y")
	echo $cp->arResult['SPECIALDATE'];
   	$APPLICATION->SetPageProperty("specialdate",$cp->arResult['SPECIALDATE'])
?>

