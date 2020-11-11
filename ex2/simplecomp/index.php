<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент");
?><?$APPLICATION->IncludeComponent(
	"dv:simplecomp.exam", 
	".default", 
	array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CODE_USER_PROP" => "UF_AUTHOR_TYPE",
		"ID_CATALOG" => "1",
		"ID_NEWS" => "1",
		"COMPONENT_TEMPLATE" => ".default",
		"DETAIL_URL" => "/products/#SECTION_ID#/#ID#/",
		"CODE_AUTHOR" => "PROPERTY_AUTHOR"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>