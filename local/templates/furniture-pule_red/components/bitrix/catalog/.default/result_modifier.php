<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?global $APPLICATION;
$IBLOCK_ID_METATEGS =6;
$arSelect = Array("PROPERTY_META_TITLE","PROPERTY_META_DESCRIPTION");
$arFilter = Array("IBLOCK_ID"=>$IBLOCK_ID_METATEGS, "NAME"=>$APPLICATION->GetCurPage() );
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
 $arFields = $ob->GetFields();
	$description = $arFields['PROPERTY_META_DESCRIPTION_VALUE'];
	$title = $arFields['PROPERTY_META_TITLE_VALUE'];
 
}
 


$cp = $this->__component; // объект компонента

if (is_object($cp))
{
    // добавим в arResult компонента два поля - MY_TITLE и IS_OBJECT
    $cp->arResult['SET_DESCRIPTION'] = $description;
    $cp->arResult['SET_TITLE'] = $title;
    $cp->SetResultCacheKeys(array('SET_DESCRIPTION','SET_TITLE'));
    // сохраним их в копии arResult, с которой работает шаблон
    $arResult['SET_DESCRIPTION'] = $cp->arResult['SET_DESCRIPTION'];
    $arResult['SET_TITLE'] = $cp->arResult['SET_TITLE'];

} 
 
 
 
?>


