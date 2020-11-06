<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();



$arResult['ID_CATALOG'] = $arParams["ID_CATALOG"];
$arResult['ID_NEWS'] = $arParams["ID_NEWS"];
$arResult['CODE_USER_PROP'] = $arParams["CODE_USER_PROP"];
$arResult['ID_CATALOG'] = date($arParams["ID_CATALOG"]);
$arParams["ID_CATALOG"] = intval($arParams["ID_CATALOG"]);
$arParams["CHECK_PERMISSIONS"] = $arParams["CHECK_PERMISSIONS"]!="N";
$arParams["DETAIL_URL"]=trim($arParams["DETAIL_URL"]);

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;

	use Bitrix\Main\Context,
	Bitrix\Main\Type\DateTime,
	Bitrix\Main\Loader,
	Bitrix\Iblock;
	
	$arResult["COUNT_ITEMS"] = 0;
	$arResult["ITEMS"] = array(); 
	$arResult["ELEMENTS"] = array();
	$arFilter = array (
		"IBLOCK_ID" => $arParams["ID_NEWS"],
		"IBLOCK_LID" => SITE_ID,
		"ACTIVE" => "Y",
		"CHECK_PERMISSIONS" => $arParams['CHECK_PERMISSIONS'] ? "Y" : "N",
	);
	$rsElement = CIBlockElement::GetList($arSort, $arFilter , false, false, array("ID","IBLOCK_ID","SRCTION_ID","NAME","DATE_ACTIVE_FROM")); //Получаем Элементы инфоблока новости
	while ($row = $rsElement->Fetch())
	{
		$id = (int)$row['ID'];
		$arResult["ITEMS"][$id] = $row;
		$arResult["ELEMENTS"][] = $id;


		$arResult["COUNT_ITEMS"] =count($arResult["ITEMS"]);

		
		$arrFilter = array (
		"IBLOCK_ID" =>$arResult['ID_CATALOG'],
		"IBLOCK_LID" => SITE_ID,
		$arParams["CODE_USER_PROP"] => $row["ID"],
		"ACTIVE" => "Y",
		"CHECK_PERMISSIONS" => $arParams['CHECK_PERMISSIONS'] ? "Y" : "N",
		);
	
		$id1 =0;

		$rsElement1 = CIBlockElement::GetList(false, $arrFilter , false, false, array("ID","IBLOCK_ID","NAME","IBLOCK_SECTION_ID")); //Получаем элементы из разделов привязанных к новостям
		$rsElement1->SetUrlTemplates($arParams["DETAIL_URL"]); //Применяем к ссылкам шаблон
		while ($row1 = $rsElement1->GetNext())
		{	
	
	
			$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1] = $row1;
			$prop=CIBlockElement::GetByID($row1["ID"])->GetNextElement()->GetProperties();
			$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1]["PROP"]["PRICE"] = $prop['PRICE']["VALUE"];
			$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1]["PROP"]["ARTNUMBER"] = $prop['ARTNUMBER']["VALUE"];
			$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1]["PROP"]["MATERIAL"] = $prop['MATERIAL']["VALUE"];
			$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1]["DETAIL_URL"] =$row1["DETAIL_PAGE_URL"];
			$id1=$id1+1;
		}
		unset($row);
		
		
		
	}
	unset($row);

	$arResult['ITEMS'] = array_values($arResult['ITEMS']);
	
	$APPLICATION->SetTitle("Разделов: [".$arResult["COUNT_ITEMS"]."]");
	
$this->IncludeComponentTemplate();
?>