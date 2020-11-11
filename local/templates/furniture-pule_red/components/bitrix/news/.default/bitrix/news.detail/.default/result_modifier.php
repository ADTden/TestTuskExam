<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$cp = $this->__component; // объект компонента

if (is_object($cp))
{
   // добавим в arResult компонента поля
   $cp->arResult['ID_CANONICAL'] = $arResult["ID"];
   $cp->SetResultCacheKeys(array('ID_CANONICAL'));

   // сохраним их в копии arResult, с которой работает шаблон
   $arResult['ID_CANONICAL'] = $cp->arResult['ID_CANONICAL'];
}


?> 