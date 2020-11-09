<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();



$arResult['ID_CATALOG'] = $arParams["ID_CATALOG"];
$arResult['ID_NEWS'] = $arParams["ID_NEWS"];
$arResult['CODE_USER_PROP'] = $arParams["CODE_USER_PROP"];
$arResult['ID_CATALOG'] = date($arParams["ID_CATALOG"]);
$bUSER_HAVE_ACCESS = true;
//Режим редактирования включён?
if ($APPLICATION->GetShowIncludeAreas())
{
	
$this->AddIncludeAreaIcons(
	Array( //массив кнопок toolbar'a
		Array(
			"ID" => "Идентификатор кнопки",
			"TITLE" => "ИБ в админке",
			"URL" => "http://testtusk/bitrix/admin/iblock_element_admin.php?IBLOCK_ID=".$arParams["ID_NEWS"]."&type=news&lang=ru&apply_filter=Y", //или javascript:MyJSFunction ()
			"ICON" => "menu-delete", //CSS-класс с иконкой
			"IN_PARAMS_MENU" => true, //показать в контекстном меню
			"IN_MENU" => false //показать в подменю компонента
		)
	)
);

}


if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;

$arParams["ID_CATALOG"] = intval($arParams["ID_CATALOG"]);

	
	use Bitrix\Main\Context,
	Bitrix\Main\Type\DateTime,
	Bitrix\Main\Loader,
	Bitrix\Iblock;
	
	if($_REQUEST["F"]){
		COption::SetOptionString("main", "component_cache_on", "N");
	}else{
		COption::SetOptionString("main", "component_cache_on", "Y");
	}
	
	if($arNavigation["PAGEN"]==0 && $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"]>0)
		$arParams["CACHE_TIME"] = $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"];
	
	$arResult["COUNT_ITEMS"] = 0;
	$arResult["ITEMS"] = array(); 
	$arResult["ELEMENTS"] = array();
	$arFilter = array (
		"IBLOCK_ID" => $arParams["ID_NEWS"],
		"IBLOCK_LID" => SITE_ID,
		"ACTIVE" => "Y",
		"CHECK_PERMISSIONS" => $arParams['CHECK_PERMISSIONS'] ? "Y" : "N",
	);
	
	
	
	$rsElement = CIBlockElement::GetList($arSort, $arFilter , false, array("nPageSize" => $arParams['NEWS_COUNT']), array("*")); //Получаем Элементы инфоблока новости
	$rsElement->NavStart($arParams['NEWS_COUNT']);
	$arResult['NAV'] = $rsElement;
	
	
  
	while ($row = $rsElement->Fetch())
	{
		$id = (int)$row['ID'];
		$arResult["ITEMS"][$id] = $row;
		$arResult["ELEMENTS"][] = $id;

		$id_sections = array();
		$name_sections= array();

        $res = CIBlockSection::GetList([], ['IBLOCK_ID' => $arParams["ID_CATALOG"], $arParams["CODE_USER_PROP"] => $row["ID"] ,"ACTIVE"=>"Y"], false, ['IBLOCK_ID', 'ID', "NAME", 'UF_NEWS_LINK']); //Получаем  разделоы привязанныу к новостям
		while($ress = $res->Fetch()){
		$value = $ress["ID"];
		$id_sections[]=$value;
		$name_sections[]=$ress["NAME"];
		};
		
		$arResult["ITEMS"][$id]["CATALOG_SECTIONS"] = $name_sections;
		
		$arrFilter = array (
		"IBLOCK_ID" =>$arResult['ID_CATALOG'],
		"IBLOCK_LID" => SITE_ID,
		"SECTION_ID"=>$id_sections,
		"ACTIVE" => "Y",
		);
	
		$id1 =0;
		$rsElement1 = CIBlockElement::GetList(false, $arrFilter , false, false, array("*")); //Получаем элементы из разделов привязанных к новостям
		$rsElement1->SetUrlTemplates($arParams["DETAIL_URL"]); //Применяем к ссылкам шаблон
		while ($row1 = $rsElement1->GetNext())
		{	$prop=CIBlockElement::GetByID($row1["ID"])->GetNextElement()->GetProperties();
			
			
			if($_REQUEST["F"] ){
				if($prop['PRICE']["VALUE"] <= 1700 && $prop['MATERIAL']["VALUE"] == "Дерево, ткань" || $prop['PRICE']["VALUE"] < 1500 && $prop['MATERIAL']["VALUE"]=="Металл, пластик" ){
					$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1] = $row1;
					$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1]["PROP"]["PRICE"] = $prop['PRICE']["VALUE"];
					$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1]["PROP"]["ARTNUMBER"] = $prop['ARTNUMBER']["VALUE"];
					$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1]["PROP"]["MATERIAL"] = $prop['MATERIAL']["VALUE"];
					$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1]["DETAIL_URL"] =$row1["DETAIL_PAGE_URL"];
			
				}
				}else{
					$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1] = $row1;
					$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1]["PROP"]["PRICE"] = $prop['PRICE']["VALUE"];
					$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1]["PROP"]["ARTNUMBER"] = $prop['ARTNUMBER']["VALUE"];
					$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1]["PROP"]["MATERIAL"] = $prop['MATERIAL']["VALUE"];
					$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1]["DETAIL_URL"] =$row1["DETAIL_PAGE_URL"];

				}
			
			$id1=$id1+1;
		}
		unset($row1);
		
		$count=count($arResult["ITEMS"][$id]["CATALOG_ITEMS"]);
	$arResult["COUNT_ITEMS"] = $arResult["COUNT_ITEMS"] + $count;
	$APPLICATION->SetTitle("В каталоге товаров представлено товаров: [".$arResult["COUNT_ITEMS"]."]");
		
	}
	if($this->startResultCache(false, array(($arParams["CACHE_GROUPS"]==="N"? false: $USER->GetGroups()), $bUSER_HAVE_ACCESS, $arNavigation, $arrFilter, $pagerParameters)))
	{
	 $this->setResultCacheKeys(array(
		"ID",
		"IBLOCK_TYPE_ID",
		"LIST_PAGE_URL",
		"NAV_CACHED_DATA",
		"NAME",
		"SECTION",
		"ELEMENTS",
		"IPROPERTY_VALUES",
		"ITEMS_TIMESTAMP_X",
	));
	 $this->IncludeComponentTemplate();
	}  

	
	unset($row);
  
	$arResult['ITEMS'] = array_values($arResult['ITEMS']);

  	 
	
	
	

	
?>