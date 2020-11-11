<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;

if (isset($arResult['SET_DESCRIPTION']) || isset($arResult['SET_TITLE']) ){
	$APPLICATION->SetPageProperty('description',$arResult['SET_DESCRIPTION']);
	$APPLICATION->SetPageProperty('title',$arResult['SET_TITLE']);	
}
    
?>