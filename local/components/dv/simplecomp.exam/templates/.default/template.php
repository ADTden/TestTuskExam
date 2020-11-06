<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

?>
Фильтр: <a href="/ex2/simplecomp/?F=Y">/ex2/simplecomp/?F=Y</a>
<?foreach($arResult["ITEMS"] as $arItem){
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => "Удалить?"));?>
<div class="main-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
	<br>
	<div class="name"><b><?=$arItem["NAME"]?></b> - <?=$arItem['DATE_ACTIVE_FROM']?> (<?echo implode(', ', $arItem["CATALOG_SECTIONS"]);?>)</div>
	<br>
	<?foreach($arItem["CATALOG_ITEMS"] as $arCatItem){
		$this->AddEditAction($arCatItem['ID'], $arCatItem['EDIT_LINK'], CIBlock::GetArrayByID($arCatItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arCatItem['ID'], $arCatItem['DELETE_LINK'], CIBlock::GetArrayByID($arCatItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => "Удалить?"));?>
	
		<div class="catalogs-item" id="<?=$this->GetEditAreaId($arCatItem['ID']);?>">
			<div class="item"><?=$arCatItem["NAME"]?> - <?=$arCatItem["PROP"]["PRICE"]?> - <?=$arCatItem["PROP"]["MATERIAL"]?> - <?=$arCatItem["PROP"]["ARTNUMBER"]?>   (<?=$arCatItem["DETAIL_URL"]?>)</div>
		</div>
	<?}?>
</div>
<?}?>	

