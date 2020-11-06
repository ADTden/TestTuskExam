<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();



$arResult['ID_CATALOG'] = $arParams["ID_CATALOG"];
$arResult['ID_NEWS'] = $arParams["ID_NEWS"];
$arResult['CODE_USER_PROP'] = $arParams["CODE_USER_PROP"];
$arResult['ID_CATALOG'] = date($arParams["ID_CATALOG"]);
$arParams["ID_CATALOG"] = intval($arParams["ID_CATALOG"]);
$arParams["CHECK_PERMISSIONS"] = $arParams["CHECK_PERMISSIONS"]!="N";


if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;

	use Bitrix\Main\Context,
	Bitrix\Main\Type\DateTime,
	Bitrix\Main\Loader,
	Bitrix\Iblock;
	
	//$arResult["COUNT_ITEMS"] = 0;
	$arResult["ITEMS"] = array(); 
	$arResult["ELEMENTS"] = array();
	
	$rsUser = CUser::GetByID($USER->GetID());
	$arUser = $rsUser->Fetch();
	
	
	$filter = Array($arParams["CODE_USER_PROP"]=>$arUser[$arParams["CODE_USER_PROP"]],"!ID"=>$USER->GetID());
	
	$rsElement = CUser::GetList(($by="NAME"), ($order="desc"), $filter); // выбираем пользователей
	while ($row = $rsElement->GetNext())
	{	
		$id = (int)$row['ID'];
		$arResult["ITEMS"][$id] = $row;
		$arResult["ELEMENTS"][] = $id;
		

		

		
		$arrFilter = array (
		"IBLOCK_ID" =>$arParams["ID_CATALOG"],
		"IBLOCK_LID" => SITE_ID,
		$arParams["CODE_AUTHOR"] => $row["ID"],
		"ACTIVE" => "Y",
		"PROPERTY_AUTHOR"=>$id,
		"CHECK_PERMISSIONS" => $arParams['CHECK_PERMISSIONS'] ? "Y" : "N",
		);
	
		$id1 =0;

		$rsElement1 = CIBlockElement::GetList(false, $arrFilter , false, false, array("ID","IBLOCK_ID","NAME","IBLOCK_SECTION_ID","PROPERTY_AUTHOR")); //Получаем элементы из разделов привязанных к новостям
		while ($row1 = $rsElement1->GetNext())
		{	$arResult["COUNT_ITEMS"][]=$row1["ID"];
	
			if($row1["PROPERTY_AUTHOR_VALUE"] == $USER->GetID()){
				$arResult["USER"][] = $row1["ID"];
			}
			if(in_array( $row1["ID"], $arResult["USER"])){}else{
			$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1] = $row1;
			$prop=CIBlockElement::GetByID($row1["ID"])->GetNextElement()->GetProperties();
			
			$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1]["DETAIL_URL"] =$row1["DETAIL_PAGE_URL"];
			$id1=$id1+1;
			}
		}
		unset($row);
		
		
		
	}
	unset($row);

	$arResult['ITEMS'] = array_values($arResult['ITEMS']);
	$arResult["COUNT_ITEMS"] = array_unique($arResult["COUNT_ITEMS"]);
	$APPLICATION->SetTitle("Новостей: [".count($arResult["COUNT_ITEMS"])."]");
	
$this->IncludeComponentTemplate();
?>