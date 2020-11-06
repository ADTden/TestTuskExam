<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
 
?>
Фильтр: <a href="/ex2/simplecomp/?F=Y">/ex2/simplecomp/?F=Y</a>
<?foreach($arResult["ITEMS"] as $arItem){?>
<div class="main-item">
	<br>
	<div class="name"><b><?=$arItem["NAME"]?></b> - <?=$arItem['DATE_ACTIVE_FROM']?> (<?echo implode(', ', $arItem["CATALOG_SECTIONS"]);?>)</div>
	<br>
	<?foreach($arItem["CATALOG_ITEMS"] as $arCatItem){?>
		<div class="catalogs-item">
			<div class="item"><?=$arCatItem["NAME"]?> - <?=$arCatItem["PROP"]["PRICE"]?> - <?=$arCatItem["PROP"]["MATERIAL"]?> - <?=$arCatItem["PROP"]["ARTNUMBER"]?>   (<?=$arCatItem["DETAIL_URL"]?>)</div>
		</div>
	<?}?>
</div>
<?}?>	

