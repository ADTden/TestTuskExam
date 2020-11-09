<?

AddEventHandler("main", "OnBeforeEventAdd", "onBeforeEventAdd");

    function onBeforeEventAdd(&$event, &$lid, &$arFields, &$messageId, &$files, &$languageId)
    {	if($messageId == 7){
			global $USER;
			if ($USER->IsAuthorized()) {
				$arFields["AUTHOR"] = "Пользователь авторизован: ".$USER->GetID()." (".$USER->GetLogin().") ".$USER->GetFullName().", данные из формы: ".$arFields["AUTHOR"];
			}else{
				$arFields["AUTHOR"] = "Пользователь не авторизован, данные из формы: ".$arFields["AUTHOR"];
			}
			return $arFields;
		}
	}


AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "OnBeforeIBlockElementUpdateHandler");


    function OnBeforeIBlockElementUpdateHandler(&$arFields) {
        if ($arFields['IBLOCK_ID'] == 3) {
            CBitrixComponent::clearComponentCache('dv:simplecomp.exam');
        }
    }


?>