<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

?>
<?foreach($arResult["ITEMS"] as $arItem){?>
<div class="main-item">
	<br>
	<div class="name"><b><?=$arItem["NAME"]?></b> - <?=$arItem['DATE_ACTIVE_FROM']?> (<?echo implode(', ', $arItem["NAME_SECTION"]);?>)</div>
	<br>
	<?foreach($arItem["CATALOG_ITEMS"] as $arCatItem){?>
		<div class="catalogs-item">
			<div class="item"><?=$arCatItem["NAME"]?> - <?=$arCatItem["PROPERTY_PRICE_VALUE"]?> - <?=$arCatItem["PROPERTY_MATERIAL_VALUE"]?> - <?=$arCatItem["PROPERTY_ARTNUMBER_VALUE"]?></div>
		</div>
	<?}?>
</div>
<?}?>	

