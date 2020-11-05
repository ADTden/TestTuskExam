<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
 $arComponentParameters = array(
"GROUPS" => array(),
"PARAMETERS" => array(


"ID_CATALOG" => array(
"PARENT" => "BASE",
"NAME" => "ID инфоблока с каталогом товаров",
"TYPE" => "STRING",
"MULTIPLE" => "N",
"DEFAULT" => "",
),
"ID_NEWS" => array(
"PARENT" => "BASE",
"NAME" => "ID инфоблока с новостями",
"TYPE" => "STRING",
"MULTIPLE" => "N",
"DEFAULT" => "",
),
"CODE_USER_PROP" => array(
"PARENT" => "BASE",
"NAME" => "Код пользовательского свойства разделов каталога, в котором хранится привязка к новостям",
"TYPE" => "STRING",
"MULTIPLE" => "N",
"DEFAULT" => "",
),

"CACHE_TIME"  =>  array("DEFAULT"=>36000000),
		


),
);
?>