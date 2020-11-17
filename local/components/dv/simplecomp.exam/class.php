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

    public function takeUsersList($CODE_USER_PROP)
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
			
		}
		unset($row);
        return $arResult;
	}
	

	public function makeArNews($CODE_AUTHOR,$id_news,$arResult)
    {	global $USER;
		$arrFilter = array (
			"IBLOCK_ID" =>$id_news,
			"IBLOCK_LID" => SITE_ID,
			$CODE_AUTHOR => $arResult["ELEMENTS"],
			"ACTIVE" => "Y",
			"CHECK_PERMISSIONS" => $arParams['CHECK_PERMISSIONS'] ? "Y" : "N",
			);
		
			$id1 =0;

			$rsElement1 = CIBlockElement::GetList(false, $arrFilter , false, false, array("ID","IBLOCK_ID","NAME","IBLOCK_SECTION_ID","PROPERTY_AUTHOR")); 
			while ($row1 = $rsElement1->Fetch())
			{	$arResult["COUNT_ITEMS"][]=$row1["ID"];
		
				if($row1["PROPERTY_AUTHOR_VALUE"] == $USER->GetID()){
					$arResult["USER"][] = $row1["ID"];
				}
				if(in_array( $row1["ID"], $arResult["USER"])){}else{
				$arResult["NEWS"][]= $row1;
			
				$id1=$id1+1;
				}
			}
			return $arResult;

	}

	public function makeFinalAr($arResult)
    {
		foreach ($arResult['ITEMS'] as $key => $value) {
			foreach ($arResult['NEWS'] as $key => $value1) {
				if($value["ID"] == $value1["PROPERTY_AUTHOR_VALUE"])
				$arResult['ITEMS'][$value["ID"]]["NEWS"][]=$value1;
				$news[]=$value1["ID"];
			}
		}
			$arResult["COUNT_ITEMS"] = array_unique($news);
			return $arResult;

	}


	public function executeComponent()
   			 {	
				if($this->startResultCache()){
					
					$this->arResult = $this->takeUsersList($this->arParams["CODE_USER_PROP"]);
					$this->arResult = $this->makeArNews($this->arParams["ID_CATALOG"],$this->arParams["ID_NEWS"],$this->arResult);
					$this->arResult = $this->makeFinalAr($this->arResult);


					$this->IncludeComponentTemplate();
				}

				global $APPLICATION;
				$APPLICATION->SetTitle("В каталоге товаров представлено товаров: [".count($this->arResult["COUNT_ITEMS"])."]");	
				return $this->arResult;
			}
}?>