<?require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');?>
<?
CModule::IncludeModule('iblock');
if($_REQUEST["NEWS_ID"]){
	$PROP = array();

	global $USER;
	if ($USER->IsAuthorized()){
		$rsUser = CUser::GetByID($USER->GetID());
		$arUser = $rsUser->Fetch();
		$PROP[16]="";
		//echo "<pre>"; print_r($arUser); echo "</pre>";
		$PROP[16]=" ".$arUser["ID"]." ".$arUser["LOGIN"]." ".$arUser["NAME"]." ".$arUser["LAST_NAME"];
	}else{
		$PROP[16]="Не авторизован";
	}

		
		
	$el = new CIBlockElement;

	
	$PROP[17]=$_REQUEST["NEWS_ID"];


	$arLoadProductArray = Array(
	  "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
	  "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
	  "IBLOCK_ID"      => 8,
	  "PROPERTY_VALUES"=> $PROP,
	  "NAME"           => "Жалоба на новость с ID ".$_REQUEST["NEWS_ID"],
	  "ACTIVE"         => "Y",            // активен
	  "DATE_ACTIVE_FROM" => date("d.m.Y"),
	  );

	if($PRODUCT_ID = $el->Add($arLoadProductArray)){
		 echo "Ваше мнение учтено №".$PRODUCT_ID;
		 if($_GET["NEWS_ID"])
			header('Location:/news/'.$_REQUEST["NEWS_ID"].'/?ADD=YES&ID_REPORT='.$PRODUCT_ID);}
	else{
	  echo "Ошибка!";
	}
}
?>
     