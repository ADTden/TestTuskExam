<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if(!CModule::IncludeModule("iblock"))
	return;

 $arComponentParameters = array(
"GROUPS" => array(),
"PARAMETERS" => array(


"ID_NEWS" => array(
"PARENT" => "BASE",
"NAME" => "ID инфоблока с новостями",
"TYPE" => "STRING",
"MULTIPLE" => "N",
"DEFAULT" => "",
),

"CODE_AUTHOR" => array(
"PARENT" => "BASE",
"NAME" => "Код свойства информационного блока, в котором хранится Автор",
"TYPE" => "STRING",
"MULTIPLE" => "N",
"DEFAULT" => "",
),

"CODE_USER_PROP" => array(
"PARENT" => "BASE",
"NAME" => "Код пользовательского свойства пользователей, в котором хранится тип автора",
"TYPE" => "STRING",
"MULTIPLE" => "N",
"DEFAULT" => "",
),

"CACHE_TIME"  =>  array("DEFAULT"=>36000000),
		


),
);

?>