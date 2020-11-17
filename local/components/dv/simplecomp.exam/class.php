<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
 $arResult = array();
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
			"DETAIL_URL" => $arParams["DETAIL_URL"],
        );
		return $result;
		
    }

	

    public function makeArNews($id_news)
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
		return $arResult;
		
	}


		//создаем массив разделов привязанных к новостям
	public function makeArSections($id_catalog,$CODE_USER_PROP,$arResult)
	{

		$res = CIBlockSection::GetList([], ['IBLOCK_ID' => $id_catalog, $CODE_USER_PROP => $arResult["ELEMENTS"] ,"ACTIVE"=>"Y"], false, ['IBLOCK_ID', 'ID', "NAME", $CODE_USER_PROP]); //Получаем  разделоы привязанныу к новостям
		while($ress = $res->Fetch())
		{
			foreach ($ress[$CODE_USER_PROP] as $key => $value) {
				$arResult["ITEMS"][$value]["ID_SETCOIN"][]=$ress["ID"];
				$arResult["ITEMS"][$value]["NAME_SECTION"][]=$ress["NAME"];
			}
			$arResult["SECTIONS"][] =$ress["ID"];
		};
		return $arResult;
	}



	public function mexidAr($id_catalog,$arResult,$detail_url)
	{
		//создаем массив из элементов из этих расделов

		$arrFilter = array (
			"IBLOCK_ID" =>$id_catalog,
			"IBLOCK_LID" => SITE_ID,
			"SECTION_ID"=>$arResult["SECTIONS"],
			"ACTIVE" => "Y",
			);
		
			
		$catalogItems = array();
		$rsElement1 = CIBlockElement::GetList(false, $arrFilter , false, false, array("ID","NAME",'PROPERTY_PRICE','PROPERTY_ARTNUMBER','PROPERTY_MATERIAL',"IBLOCK_SECTION_ID","DETAIL_PAGE_URL")); 
		//Получаем элементы из разделов привязанных к новостям
		$rsElement1->SetUrlTemplates($detail_url);
		while ($row1 = $rsElement1->GetNext())
		{

			$arResult["CATALOG_ITEMS"][]=$row1;
				
		}
		return $arResult;
	}

			//формируем итоговый массив

	public function makeFinalAr($arResult)
	{
		foreach ($arResult["ITEMS"] as $key => $value)
		{
			foreach($arResult["CATALOG_ITEMS"] as $key => $value1)
			{ 
				if(in_array($value1["IBLOCK_SECTION_ID"], $value['ID_SETCOIN']))
				$arResult["ITEMS"][$value["ID"]]['CATALOG_ITEMS'][] = $value1;
			}
		}

		//количесвто выводимых элементов каталога.
		$arResult['COUNT_ITEMS'] = count($arResult["CATALOG_ITEMS"]);
			

		return $arResult;
	}


	public function Filter_F($arResult)
	{	$count=0;
		foreach ($arResult["ITEMS"] as $key => $value)
		{	$arFilterItems=array();
			foreach ($value['CATALOG_ITEMS'] as $key => $value1) {
				if($value1['PROPERTY_PRICE_VALUE']<= 1700 && $value1['PROPERTY_MATERIAL_VALUE'] == "Дерево, ткань" || $value1['PROPERTY_PRICE_VALUE'] < 1500 && $value1['PROPERTY_MATERIAL_VALUE']=="Металл, пластик" ){
					$arFilterItems[]=$value1;
					$count+=1 ;
				}
			}
			$arResult["ITEMS"][$value['ID']]["CATALOG_ITEMS"] = $arFilterItems;
			$arResult['COUNT_ITEMS'] = $count;
		}

		
		
			

		return $arResult;
	}

	
	public function executeComponent()
   	 {	
		if($this->startResultCache())
		{  
			$this->arResult = $this->makeArNews($this->arParams["ID_NEWS"]);
			$this->arResult = $this->makeArSections($this->arParams["ID_CATALOG"],$this->arParams["CODE_USER_PROP"],$this->arResult);
			$this->arResult = $this->mexidAr($this->arParams["ID_CATALOG"],$this->arResult,$this->arParams["DETAIL_URL"]);
			$this->arResult = $this->makeFinalAr($this->arResult);
		}

		if($_REQUEST["F"]){
			$this->arResult = $this->Filter_F($this->arResult);
		}
		
		$this->IncludeComponentTemplate();

		global $APPLICATION;
		$APPLICATION->SetTitle("В каталоге товаров представлено товаров: [".$this->arResult["COUNT_ITEMS"]."]");	
		return $this->arResult;
	}

}