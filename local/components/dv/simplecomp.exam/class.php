<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

class CDemoSqr extends CBitrixComponent
{
    //Родительский метод проходит по всем параметрам переданным в $APPLICATION->IncludeComponent
    //и применяет к ним функцию htmlspecialcharsex. В данном случае такая обработка избыточна.
    //Переопределяем.
    public function onPrepareComponentParams($arParams)
    {
        $result = array(
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => isset($arParams["CACHE_TIME"]) ?$arParams["CACHE_TIME"]: 36000000,
            "ID_CATALOG" => intval($arParams["ID_CATALOG"]),
			"CODE_USER_PROP" => $arParams["CODE_USER_PROP"],
			"ID_NEWS" => intval($arParams["ID_NEWS"]),
			"DETAIL_URL"=>$arParams["DETAIL_URL"],
			"F"=>$arParams["F"],
			
        );
        return $result;
    }

    public function makeArResult($id_catalog,$CODE_USER_PROP,$id_news,$detail_url,$f)
    {
		$arResult["COUNT_ITEMS"] = 0;
		$arResult["ITEMS"] = array(); 
		$arResult["ELEMENTS"] = array();
			$arFilter = array (
		"IBLOCK_ID" => $id_news,
		"IBLOCK_LID" => SITE_ID,
		"ACTIVE" => "Y",
		"CHECK_PERMISSIONS" => $arParams['CHECK_PERMISSIONS'] ? "Y" : "N",
	);
	$count = 0;
	$rsElement = CIBlockElement::GetList($arSort, $arFilter , false, false, array("ID","NAME","DATE_ACTIVE_FROM")); //Получаем Элементы инфоблока новости
	while ($row = $rsElement->Fetch())
	{
		$id = (int)$row['ID'];
		$arResult["ITEMS"][$id] = $row;
		$arResult["ELEMENTS"][] = $id;
		
		
		$id_sections = array();
		$name_sections= array();

        $res = CIBlockSection::GetList([], ['IBLOCK_ID' => $id_catalog, $CODE_USER_PROP => $row["ID"] ,"ACTIVE"=>"Y"], false, ['IBLOCK_ID', 'ID', "NAME", 'UF_NEWS_LINK']); //Получаем  разделоы привязанныу к новостям
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
		$rsElement1 = CIBlockElement::GetList(false, $arrFilter , false, false, array("ID","IBLOCK_ID","CODE","NAME","IBLOCK_SECTION_ID","DETAIL_PAGE_URL")); //Получаем элементы из разделов привязанных к новостям
		$rsElement1->SetUrlTemplates($detail_url); //Применяем к ссылкам шаблон
		echo $arParams["DETAIL_URL"];
		while ($row1 = $rsElement1->GetNext())	
		{	$prop=CIBlockElement::GetByID($row1["ID"])->GetNextElement()->GetProperties();
			if($f){
				if($prop['PRICE']["VALUE"] <= 1700 && $prop['MATERIAL']["VALUE"] == "Дерево, ткань" || $prop['PRICE']["VALUE"] < 1500 && $prop['MATERIAL']["VALUE"]=="Металл, пластик" ){
					$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1] = $row1;
					$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1]["PROP"]["PRICE"] = $prop['PRICE']["VALUE"];
					$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1]["PROP"]["ARTNUMBER"] = $prop['ARTNUMBER']["VALUE"];
					$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1]["PROP"]["MATERIAL"] = $prop['MATERIAL']["VALUE"];
					$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1]["DETAIL_URL"] =$row1["DETAIL_PAGE_URL"];
				}
				$id1=$id1+1;
				}else{
				$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1] = $row1;
				$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1]["PROP"]["PRICE"] = $prop['PRICE']["VALUE"];
				$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1]["PROP"]["ARTNUMBER"] = $prop['ARTNUMBER']["VALUE"];
				$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1]["PROP"]["MATERIAL"] = $prop['MATERIAL']["VALUE"];
				$arResult["ITEMS"][$id]["CATALOG_ITEMS"][$id1]["DETAIL_URL"] =$row1["DETAIL_PAGE_URL"];
				$id1=$id1+1;
			}
				
		}
		unset($row);
	}
	
	unset($row);
			$arResult['ITEMS'] = array_values($arResult['ITEMS']);
        return $arResult;
    }
	
	 public function getCount($id_catalog,$CODE_USER_PROP,$id_news,$detail_url,$f)
    {
	
		$arResult["COUNT_ITEMS"] = 0;
		$arResult["ITEMS"] = array(); 
		$arResult["ELEMENTS"] = array();
			$arFilter = array (
		"IBLOCK_ID" => $id_news,
		"IBLOCK_LID" => SITE_ID,
		"ACTIVE" => "Y",
		"CHECK_PERMISSIONS" => $arParams['CHECK_PERMISSIONS'] ? "Y" : "N",
	);
	$count = 0;
	$rsElement = CIBlockElement::GetList($arSort, $arFilter , false, false, array("ID","NAME","DATE_ACTIVE_FROM")); //Получаем Элементы инфоблока новости
	while ($row = $rsElement->Fetch())
	{
		$id = (int)$row['ID'];
		$arResult["ITEMS"][$id] = $row;
		$arResult["ELEMENTS"][] = $id;
		
		
		$id_sections = array();
		$name_sections= array();

        $res = CIBlockSection::GetList([], ['IBLOCK_ID' => $id_catalog, $CODE_USER_PROP => $row["ID"] ,"ACTIVE"=>"Y"], false, ['IBLOCK_ID', 'ID', "NAME", 'UF_NEWS_LINK']); //Получаем  разделоы привязанныу к новостям
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
		$rsElement1 = CIBlockElement::GetList(false, $arrFilter , false, false, array("ID","IBLOCK_ID","CODE","NAME","IBLOCK_SECTION_ID","DETAIL_PAGE_URL")); //Получаем элементы из разделов привязанных к новостям
		$rsElement1->SetUrlTemplates($detail_url); //Применяем к ссылкам шаблон
		echo $arParams["DETAIL_URL"];
		while ($row1 = $rsElement1->GetNext())	
		{	$prop=CIBlockElement::GetByID($row1["ID"])->GetNextElement()->GetProperties();
			if($f){
				if($prop['PRICE']["VALUE"] <= 1700 && $prop['MATERIAL']["VALUE"] == "Дерево, ткань" || $prop['PRICE']["VALUE"] < 1500 && $prop['MATERIAL']["VALUE"]=="Металл, пластик" ){
					$count++;
				}
				}else{
					$count++;
			}
		}
		unset($row);
		
	
		
	}
	
	unset($row);
			$arResult["COUNT_ITEMS"] = $count;
        return $arResult["COUNT_ITEMS"];
	}
	
}?>