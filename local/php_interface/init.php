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


function CheckUserCount(){
	
$date = COption::GetOptionString("main","last_date",false,"s1");

$countNewUsers = 0;

$filter = Array();

$rsUsers = CUser::GetList(($by="personal_country"), ($order="desc"), $filter); // выбираем пользователей
$is_filtered = $rsUsers->is_filtered; // отфильтрована ли выборка ?
$rsUsers->NavStart(50); // разбиваем постранично по 50 записей

while($rsUsers->NavNext(true, "f_")) :
	if(ConvertDateTime($date, "DD.MM.YY") <= ConvertDateTime($f_DATE_REGISTER, "DD.MM.YY")){
	$countNewUsers ++;
	}	 
endwhile;


$filter = Array(
 "GROUPS_ID"           => 1
);

$days = (ConvertDateTime(date("d.m.Y"), "DD.MM.YY") - ConvertDateTime($date, "DD.MM.YY"))+1;

$rsUsers = CUser::GetList(($by="personal_country"), ($order="desc"), $filter); // выбираем пользователей
$is_filtered = $rsUsers->is_filtered; // отфильтрована ли выборка ?
$rsUsers->NavStart(50); // разбиваем постранично по 50 записей
echo $rsUsers->NavPrint(GetMessage("PAGES")); // печатаем постраничную навигацию
while($rsUsers->NavNext(true, "f_")) :	 
	
	$mess ="на сайте зарегистрировано ".$countNewUsers." пользователей за ".$days;
	
	$arEventFields = array(
		"MESSAGE"             => $mess,
		"EMAIL_TO"            => $f_EMAIL,
    );
	CEvent::Send("COUNT_NEW_USERS", "S1", $arEventFields);	
endwhile;

COption::SetOptionString("main", "last_date", date("d.m.Y"), "STRING", 's1');
return "CheckUserCount();";
}
?>