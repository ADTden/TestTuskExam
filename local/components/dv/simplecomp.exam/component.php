<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arResult['ID_CATALOG'] = $arParams["ID_CATALOG"];
$arResult['ID_NEWS'] = $arParams["ID_NEWS"];
$arResult['CODE_USER_PROP'] = $arParams["CODE_USER_PROP"];
$arResult['ID_CATALOG'] = date($arParams["ID_CATALOG"]);


if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;

$arParams["ID_CATALOG"] = intval($arParams["ID_CATALOG"]);

	
	use Bitrix\Main\Context,
	Bitrix\Main\Type\DateTime,
	Bitrix\Main\Loader,
	Bitrix\Iblock;
 $rsIBlock = CIBlock::GetList(array(), array(
			"ACTIVE" => "Y",
			"ID" =>$arParams["ID_NEWS"],
		));
 	$arResult = $rsIBlock->GetNext();
	
	$arResult["ITEMS"] = array();
	$arResult["ELEMENTS"] = array();
	$arFilter = array (
		"IBLOCK_ID" => $arResult["ID"],
		"IBLOCK_LID" => SITE_ID,
		"ACTIVE" => "Y",
		"CHECK_PERMISSIONS" => $arParams['CHECK_PERMISSIONS'] ? "Y" : "N",
	);
	$rsElement = CIBlockElement::GetList($arSort, $arFilter , false, false, array("ID","NAME"));
	while ($row = $rsElement->Fetch())
	{
		$id = (int)$row['ID'];
		$arResult["ITEMS"][$id] = $row;
		$arResult["ELEMENTS"][] = $id;
		
		$id_sections = array();
		$arFilter = array("ID"=>1);

        $res = CIBlockSection::GetList([], ['IBLOCK_ID' => $arParams["ID_CATALOG"], 'UF_NEWS_LINK' => $row["ID"]], false, ['IBLOCK_ID', 'ID', 'UF_NEWS_LINK']);
		while($ress = $res->Fetch()){
		$value = $ress["ID"];
		$id_sections[]=$value;};
		
		
		$arrFilter = array (
		"IBLOCK_ID" =>$arResult['ID_CATALOG'],
		"IBLOCK_LID" => SITE_ID,
		"SECTION_ID"=>$id_sections,
		"ACTIVE" => "Y",
		);
	
		$id1 =0;
		$rsElement1 = CIBlockElement::GetList(false, $arrFilter , false, false, false);
		while ($row1 = $rsElement1->Fetch())
		{	
			$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1++] = $row1["NAME"];
			
		}
		unset($row);
		
		
		
	}
	unset($row);
	
	
	
	

	
		if (!empty($arResult['ITEMS']))
	{
		$elementFilter = array(
			"IBLOCK_ID" =>$arParams["ID_NEWS"],
			"IBLOCK_LID" => SITE_ID,
			"ID" => $arResult["ELEMENTS"]
		);

	
		
	}

	$arResult['ITEMS'] = array_values($arResult['ITEMS']);
	
	
$this->IncludeComponentTemplate();
?>