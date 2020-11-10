<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="news-list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<dl class="block-list">
<?foreach($arResult["ITEMS"] as $arItem):?>
		<dt><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></dt>
		<b><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem['PROPERTIES']["TITLE_EN"]["VALUE"]?></a></b>
		
		<div><?echo $arItem['PROPERTIES']["PREW_EN"]["VALUE"]["TEXT"]?></div>
<?endforeach;?>
</dl>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>
