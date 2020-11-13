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
        );
		return $result;
		
    }


	




    public function makeArResult($id_catalog,$CODE_USER_PROP,$id_news)
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

		






		//создаем массив из элементов новостей

		$rsElement = CIBlockElement::GetList($arSort, $arFilter , false, false, array("ID","NAME","DATE_ACTIVE_FROM","PROPERTY_*")); //Получаем Элементы инфоблока новости
		while ($row = $rsElement->Fetch())
		{
			$id = (int)$row['ID'];
			$arResult["ITEMS"][$id] = $row;
			$arResult["ELEMENTS"][] = $id;	

		}


		//создаем массив разделов привязанных к новостям

		$sectionsId = array();

		$res = CIBlockSection::GetList([], ['IBLOCK_ID' => $id_catalog, $CODE_USER_PROP => $arResult["ELEMENTS"] ,"ACTIVE"=>"Y"], false, ['IBLOCK_ID', 'ID', "NAME", 'UF_NEWS_LINK']); //Получаем  разделоы привязанныу к новостям
		while($ress = $res->Fetch())
		{
			foreach ($ress[$CODE_USER_PROP] as $key => $value) {
				$arResult["ITEMS"][$value]["ID_SETCOIN"][]=$ress["ID"];
				$arResult["ITEMS"][$value]["NAME_SECTION"][]=$ress["NAME"];
			}
			$sectionsId[] =$ress["ID"];
		};




		//создаем массив из элементов из этих расделов

		$arrFilter = array (
			"IBLOCK_ID" =>$arParams["ID_CATALOG"],
			"IBLOCK_LID" => SITE_ID,
			"SECTION_ID"=>$sectionsId,
			"ACTIVE" => "Y",
			);
		
			
			$catalogItems = array();
			$rsElement1 = CIBlockElement::GetList(false, $arrFilter , false, false, array("ID","NAME",'PROPERTY_PRICE','PROPERTY_ARTNUMBER','PROPERTY_MATERIAL',"IBLOCK_SECTION_ID")); //Получаем элементы из разделов привязанных к новостям
			while ($row1 = $rsElement1->Fetch())
			{	

				$catalogItems[]=$row1;
				
			}



			//формируем итоговый массив


			foreach ($arResult["ITEMS"] as $key => $value)
			{
				foreach($catalogItems as $key => $value1)
				{ 
					if(in_array($value1["IBLOCK_SECTION_ID"], $value['ID_SETCOIN']))
					$arResult["ITEMS"][$value["ID"]]['CATALOG_ITEMS'][] = $value1;
				}
			}

			//количесвто выводимых элементов каталога.
			$arResult['COUNT_ITEMS'] = count($catalogItems);
			

			return $arResult;
	}
	
	public function executeComponent()
   			 {	
				if($this->startResultCache()){
					
					$this->arResult = $this->makeArResult($this->arParams["ID_CATALOG"],$this->arParams["CODE_USER_PROP"],$this->arParams["ID_NEWS"]);
					$this->IncludeComponentTemplate();
				}

				global $APPLICATION;
				$APPLICATION->SetTitle("В каталоге товаров представлено товаров: [".$this->arResult["COUNT_ITEMS"]."]");	
				return $this->arResult;
			}

}
