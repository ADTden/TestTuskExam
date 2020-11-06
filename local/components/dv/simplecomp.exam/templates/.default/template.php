<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
 
?>
<?foreach($arResult["ITEMS"] as $arItem){?>
<div class="main-item">
	<br>
	<div class="name"><b><?=$arItem["NAME"]?></b></div>
	<br>
	<?foreach($arItem["CATALOG_ITEMS"] as $arCatItem){?>
		<div class="catalogs-item">
			<div class="item"><?=$arCatItem["NAME"]?> - <?=$arCatItem["PROP"]["PRICE"]?> - <?=$arCatItem["PROP"]["MATERIAL"]?> - <?=$arCatItem["PROP"]["ARTNUMBER"]?>  <a href="<?=$arCatItem["DETAIL_PAGE_URL"]?>">Подробнее</a></div>
		</div>
	<?}?>
</div>
<?}?>	
