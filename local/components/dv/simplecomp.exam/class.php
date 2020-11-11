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
            "CODE_AUTHOR" => $arParams["CODE_AUTHOR"],
			"CODE_USER_PROP" => $arParams["CODE_USER_PROP"],
			"ID_NEWS" => intval($arParams["ID_NEWS"]),
        );
        return $result;
    }

    public function makeArResult($CODE_AUTHOR,$CODE_USER_PROP,$id_news)
    {
		global $USER;
	$arResult["ITEMS"] = array(); 
	$arResult["ELEMENTS"] = array();
	
	$rsUser = CUser::GetByID($USER->GetID());
	$arUser = $rsUser->Fetch();
	
	
	$filter = Array($CODE_USER_PROP=>$arUser[$CODE_USER_PROP],"!ID"=>$USER->GetID());
	
	$rsElement = CUser::GetList(($by="NAME"), ($order="desc"), $filter); // выбираем пользователей
	while ($row = $rsElement->Fetch())
	{	
		$id = (int)$row['ID'];
		$arResult["ITEMS"][$id] = $row;
		$arResult["ELEMENTS"][] = $id;
		

		

		
		$arrFilter = array (
		"IBLOCK_ID" =>$id_news,
		"IBLOCK_LID" => SITE_ID,
		$CODE_AUTHOR => $row["ID"],
		"ACTIVE" => "Y",
		"PROPERTY_AUTHOR"=>$id,
		"CHECK_PERMISSIONS" => $arParams['CHECK_PERMISSIONS'] ? "Y" : "N",
		);
	
		$id1 =0;

		$rsElement1 = CIBlockElement::GetList(false, $arrFilter , false, false, array("ID","IBLOCK_ID","NAME","IBLOCK_SECTION_ID","PROPERTY_AUTHOR")); //Получаем элементы из разделов привязанных к новостям
		while ($row1 = $rsElement1->Fetch())
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
        return $arResult;
    }
}?>