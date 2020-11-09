<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?echo time();?>
<br>
Фильтр: <a href="/ex2/simplecomp/?F=Y">/ex2/simplecomp/?F=Y</a>

<?foreach($arResult["ITEMS"] as $arItem){?>
<div class="main-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
	<br>
	<div class="name"><b><?=$arItem["NAME"]?></b> - <?=$arItem['DATE_ACTIVE_FROM']?> (<?echo implode(', ', $arItem["CATALOG_SECTIONS"]);?>)</div>
	<br>
	<?foreach($arItem["CATALOG_ITEMS"] as $arCatItem){?>
			<?$arPrices[] = $arCatItem["PROP"]["PRICE"]; ?>
		<div class="catalogs-item">
			<div class="item"><?=$arCatItem["NAME"]?> - <?=$arCatItem["PROP"]["PRICE"]?> - <?=$arCatItem["PROP"]["MATERIAL"]?> - <?=$arCatItem["PROP"]["ARTNUMBER"]?>   (<?=$arCatItem["DETAIL_URL"]?>)</div>
		</div>
	<?}?>
</div>
<?=$arResult["NAV_STRING"]?>
<?}?>

<?$navStr = $arResult['NAV']->GetPageNavStringEx($navComponentObject, "Страницы:", "");?>
	<br /><?=$navStr;?>

<?
$arResult['VAR_X'] = "<div style='color:red; margin: 34px 15px 35px 15px'>---Мин. цена: ".min($arPrices)." Макс. цена: ".max($arPrices)." ---</div>";
$this->__component->setResultCacheKeys(array('VAR_X'));
?>	


