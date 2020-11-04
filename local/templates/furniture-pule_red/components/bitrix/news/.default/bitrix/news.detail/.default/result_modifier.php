<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arSelect = Array("ID", "NAME");
$arFilter = Array("IBLOCK_ID"=>$APPLICATION->GetProperty('canonical_id'), "PROPERTY_NEWS"=>$arResult["ID"], "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(false), $arSelect);
while($ob = $res->GetNextElement())
{
 $arFields = $ob->GetFields();
 $APPLICATION->SetPageProperty("canonical_link","<link rel='canonical' href=".$arFields["NAME"].">");
}
?> 