<?

AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("MyClass", "OnBeforeIBlockElementUpdate"));

class MyClass
{
    function OnBeforeIBlockElementUpdate(&$arFields)
    {  if($arFields["IBLOCK_ID"] == 2){
		   $res = CIBlockElement::GetList(array(), array("ID" => $arFields["ID"]) , false, false, array("ID","SHOW_COUNTER"));
		   if($arRes = $res->GetNext())
		   {
			   $arItem["SHOW_COUNTER"] = intval($arRes["SHOW_COUNTER"]);
		   }
	   
				if($arFields["ACTIVE"]=="N" && $arItem['SHOW_COUNTER'] > 2 ){
				global $APPLICATION;
				$APPLICATION->throwException("Товар невозможно деактивировать, у него ".$arItem['SHOW_COUNTER']." просмотров");
				return false;
				}
		}
    }
}
?>