<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$relLink="";
$arSelect = Array("NAME");
	$arFilter = Array("IBLOCK_ID"=>$arParams["DISPLAY_REL_ID"], "PROPERTY_NEWS"=> $arResult["ID"], "ACTIVE"=>"Y");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(false), $arSelect);
	while($ob = $res->GetNextElement())
	{
	 $arFields = $ob->GetFields();
	 $relLink="<link rel='canonical' href=".$arFields["NAME"].">";
	
	}

$cp = $this->__component; // объект компонента

if (is_object($cp))
{
   // добавим в arResult компонента поля
   $cp->arResult['REL_CANONICAL'] = $relLink;
   $cp->SetResultCacheKeys(array('REL_CANONICAL'));

   // сохраним их в копии arResult, с которой работает шаблон
   $arResult['REL_CANONICAL'] = $cp->arResult['REL_CANONICAL'];
}


?> 