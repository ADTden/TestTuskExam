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

AddEventHandler('main', 'OnEpilog', '_Check404Error', 1);
function _Check404Error(){
 if (defined('ERROR_404') && ERROR_404 == 'Y') {
	
 global $APPLICATION;
  CEventLog::Add(array(
         "SEVERITY" => "INFO",
         "AUDIT_TYPE_ID" => "ERROR_404",
         "MODULE_ID" => "main",
         "DESCRIPTION" => $APPLICATION->GetCurPage(),
      ));
 $APPLICATION->RestartBuffer();
 include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/header.php';
 include $_SERVER['DOCUMENT_ROOT'] . '/404.php';
 include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/footer.php';

 }
}


?>