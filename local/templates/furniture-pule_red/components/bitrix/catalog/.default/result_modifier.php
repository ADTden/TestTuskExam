<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?

$arSelect = Array("ID", "NAME", "PROPERTY_META_TITLE","PROPERTY_META_DESCRIPTION");
$arFilter = Array("IBLOCK_ID"=>6, "NAME"=>$APPLICATION->GetCurPage() );
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
while($ob = $res->GetNextElement())
{
 $arFields = $ob->GetFields();

 $APPLICATION->SetPageProperty('description',$arFields['PROPERTY_META_DESCRIPTION_VALUE']);
 $APPLICATION->SetPageProperty('title',$arFields['PROPERTY_META_TITLE_VALUE']);
}
 
?>


