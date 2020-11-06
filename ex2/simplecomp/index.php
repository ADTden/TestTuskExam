<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент");
?><?$APPLICATION->IncludeComponent(
	"dv:simplecomp.exam", 
	".default", 
	array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CODE_USER_PROP" => "PROPERTY_FIRM",
		"ID_CATALOG" => "2",
		"ID_NEWS" => "7",
		"COMPONENT_TEMPLATE" => ".default",
		"DETAIL_URL" => "/products/#SECTION_ID#/#ID#/"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>