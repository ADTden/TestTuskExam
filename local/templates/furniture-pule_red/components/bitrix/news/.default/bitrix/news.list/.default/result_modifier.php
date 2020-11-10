<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $APPLICATION;

$cp = $this->__component; // объект компонента

if (is_object($cp))
{+
    // добавим в arResult компонента два поля - MY_TITLE и IS_OBJECT
    $cp->arResult['SPECIALDATE'] = $arResult["ITEMS"][0]["DISPLAY_ACTIVE_FROM"];
    $cp->SetResultCacheKeys(array('SPECIALDATE'));
    // сохраним их в копии arResult, с которой работает шаблон
	  $arResult['SPECIALDATE'] = $cp->arResult['SPECIALDATE'];
  
}
?>