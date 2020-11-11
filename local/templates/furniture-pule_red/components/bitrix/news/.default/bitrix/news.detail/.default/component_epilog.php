<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (isset($arResult['ID_CANONICAL'])){
	$arSelect = Array("NAME");
	$arFilter = Array("IBLOCK_ID"=>$arParams["DISPLAY_REL_ID"], "PROPERTY_NEWS"=> $arResult['ID_CANONICAL'], "ACTIVE"=>"Y");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(false), $arSelect);
	while($ob = $res->GetNextElement())
	{
	 $arFields = $ob->GetFields();
	 $APPLICATION->SetPageProperty("canonical_link","<link rel='canonical' href=".$arFields["NAME"].">");
	}
}