<?php

/*
	Interface of Bitrix API replacement
	
	@license http://sam.zoy.org/wtfpl WTFPL
	This program is free software. It comes without any warranty, to
	the extent permitted by applicable law. You can redistribute it
	and/or modify it under the terms of the Do What The Fuck You Want
	To Public License, Version 2, as published by Sam Hocevar. See
	http://sam.zoy.org/wtfpl/COPYING for more details.
*/

class CApplication
{
	public function GetCurDir() { return BXFreeInterface::GetCurDir(); }
	public function GetCurPage() { return BXFreeInterface::GetCurPage(); }
	public function GetTemplatePath($str) { return SITE_TEMPLATE_PATH.'/'.$str; }
	public function IncludeComponent($name, $template = '.default', $arParams = array()) { return BXFreeInterface::IncludeComponent($name, $template, $arParams); }
	public function IncludeFile($name, $array, $params) { return BXFreeInterface::IncludeFile($name, $array, $params); }
	public function SetPageProperty() { return BXFreeInterface::SetPageProperty(); }
	public function ShowHead() { return BXFreeInterface::ShowHead(); }
	public function ShowPanel() { return BXFreeInterface::ShowPanel(); }
	public function ShowTitle() { return BXFreeInterface::ShowTitle(); }
}
class CDatabase extends BXFreeDB { }
class CIBlock
{
	public static function GetList($arSort, $arFilter) { return BXFreeInterface::GetIBlockList($arSort, $arFilter); }
}
class CIBlockPropertyMapYandex
{
	public function _GetMapKey($map, $server) { return BXFreeInterface::GetMapKey($map, $server); }
}
class CModule
{
	public static function IncludeModule($name) { return BXFreeInterface::IncludeModule($name); }
}
class CSite
{
	public function GetDateFormat() { return BXFreeInterface::GetDateFormat(); }
}
class CUser
{
	public function IsAdmin() { return BXFreeInterface::IsAdmin(); }
	public function GetID() { return BXFreeInterface::GetID(); }
}

function IncludeModuleLangFile($file) { return BXFreeInterface::IncludeModuleLangFile($file); }
function IncludeTemplateLangFile($file) { return BXFreeInterface::IncludeTemplateLangFile($file); }
function GetMessage($str) { return BXFreeInterface::GetMessage($str); }
function htmlspecialcharsEx($str) { return htmlspecialchars($str); }
function ToUpper($str) { return strtoupper($str); }

global $APPLICATION;
$APPLICATION = new CApplication();
global $USER;
$USER = new CUser();
global $DB;
$DB = new CDatabase();

?>