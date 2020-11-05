<?
AddEventHandler("main", "OnBuildGlobalMenu", "MyOnBuildGlobalMenu");
function MyOnBuildGlobalMenu(&$aGlobalMenu, &$aModuleMenu)
{	global $USER;
	$groupId=CUser::GetUserGroup($USER->GetID());
		if($groupId[0] == 5){
			unset($aGlobalMenu["global_menu_marketplace"]);
			unset($aGlobalMenu["global_menu_services"]);
			unset($aGlobalMenu["global_menu_settings"]);
			unset($aGlobalMenu["global_menu_desktop"]);
			unset($aGlobalMenu["global_menu_statistic"]);
			unset($aGlobalMenu["global_menu_landing"]);
			unset($aGlobalMenu["global_menu_store"]);
		}
		
		foreach($aModuleMenu as $key=>$value){
			if($value["icon"] == "fileman_sticker_icon" || $value["icon"] == "fav_menu_icon_yellow" || $value["icon"] == "user_menu_icon" || $value["icon"] == "sys_menu_icon" || $value["icon"] == "update_marketplace" || $value["icon"] == "iblock_menu_icon_settings"){
				unset($aModuleMenu[$key]);
			}
		}
}


?>