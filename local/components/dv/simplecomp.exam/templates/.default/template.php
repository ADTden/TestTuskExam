<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
 
?>
<?foreach($arResult["ITEMS"] as $arItem){?>
<div class="main-item">
	<br>
	<div class="name">[<?=$arItem["ID"]?>] <?=$arItem["LOGIN"]?></div>
	<br>
	<?foreach($arItem["CATALOG_ITEMS"] as $arCatItem){?>
		<div class="catalogs-item">
			<div class="item"><?=$arCatItem["NAME"]?></div>
		</div>
	<?}?>
</div>
<?}?>	
