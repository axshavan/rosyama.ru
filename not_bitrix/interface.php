<?php

/*
	Bitrix API replacement - platform-dependent realisation
	
	@license http://sam.zoy.org/wtfpl WTFPL
	This program is free software. It comes without any warranty, to
	the extent permitted by applicable law. You can redistribute it
	and/or modify it under the terms of the Do What The Fuck You Want
	To Public License, Version 2, as published by Sam Hocevar. See
	http://sam.zoy.org/wtfpl/COPYING for more details.
*/

//
class BXFreeComponent
{
	protected $template;
	protected $component_path;
	protected $arResult;
	
	//
	public function IncludeComponent($name, $template, $arParams)
	{
		global $APPLICATION;
		global $USER;
		$this->component_path = '/bitrix/components/'.str_replace(':', '/', $name);
		$name = $_SERVER['DOCUMENT_ROOT'].$this->component_path.'/component.php';
		if(file_exists($name))
		{
			$langfile = $_SERVER['DOCUMENT_ROOT'].$this->component_path.'/lang/ru/component.php';
			if(file_exists($langfile))
			{
				global $MESS;
				require($langfile);
			}
			$this->template = $template;
			$this->arResult = &$arResult;
			require($name);
			return true;
		}
		return false;
	}
	
	//
	protected function IncludeComponentTemplate($name)
	{
		global $APPLICATION;
		global $USER;
		if(!$name)
		{
			$name = 'template.php';
		}
		$name = $_SERVER['DOCUMENT_ROOT'].$this->component_path.'/templates/'.$this->template.'/'.$name;
		if(file_exists($name))
		{
			$css_file = $this->component_path.'/templates/'.$this->template.'/style.css';
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$css_file))
			{
				echo '<link rel="stylesheet" type="text/css" href="'.$css_file.'" />';
			}
			$js_file = $this->component_path.'/templates/'.$this->template.'/script.js';
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$js_file))
			{
				echo '<script type="text/javascript" src="'.$js_file.'"></script>';
			}
			$arResult = $this->arResult;
			require($name);
			return true;
		}
		return false;
	}
}

//
class BXFreeDB
{
	protected $cid;
	
	//
	public function __construct()
	{
		$this->cid = mysql_connect(DBHost, DBLogin, DBPassword);
		if(!$this->cid)
		{
			die(mysql_error());
		}
		if(!mysql_select_db(DBName, $this->cid))
		{
			die(mysql_error($this->cid));
		}
		mysql_query('set names utf8', $this->cid);
		return true;
	}
	
	//
	public function DateFormatToPHP($date)
	{
		return 'Y-m-d H:i:s';
	}
	
	//
	public function Query($str)
	{
		$result = mysql_query($str);
		if($result !== false && $result !== true)
		{
			$result = new BXFreeDBResult($result);
		}
		return $result;
	}
}

//
class BXFreeDBResult
{
	protected $res;
	
	//
	public function __construct($res)
	{
		$this->res = $res;
	}
	
	//
	public function Fetch()
	{
		return mysql_fetch_array($this->res);
	}
}

//
class BXFreeInterface
{
	//
	public static function GetCurDir() { }
	
	//
	public static function GetCurPage()
	{
		$result = explode('?', $_SERVER['REQUEST_URI']);
		return $result[0];
	}
	
	//
	public static function GetDateFormat() { }
	
	//
	public static function GetIBlockList($arSort, $arFilter)
	{
		$result = new BXFreeDBResult(false);
		return $result;
	}
	
	//
	public static function GetID()
	{
		return 0;
	}
	
	//
	public static function GetMapKey($map, $server)
	{
		return '';
	}
	
	//
	public static function GetMessage($str)
	{
		global $MESS;
		return $MESS[$str];
	}
	
	//
	public static function IncludeComponent($name, $template, $arParams)
	{
		$c = new BXFreeComponent();
		$c->IncludeComponent($name, $template, $arParams);
	}
	
	//
	public static function IncludeFile($name, $array, $params)
	{
		$name = $_SERVER['DOCUMENT_ROOT'].'/'.$name;
		if(file_exists($name))
		{
			include($name);
		}
	}
	
	//
	public static function IncludeModule($name)
	{
		if($name == 'iblock')
		{
			return true;
		}
		$name = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.$name.'/include.php';
		if(file_exists($name))
		{
			require($name);
			return true;
		}
		return false;
	}
	
	//
	public static function IncludeModuleLangFile($file)
	{
		$file = explode('modules', $file);
		$file[1] = explode('/', trim($file[1], '/'));
		$file[1][0] .= '/lang/ru';
		$file = $file[0].'modules/'.implode('/', $file[1]);
		if(file_exists($file))
		{
			global $MESS;
			require_once($file);
			return true;
		}
		return false;
	}
	
	//
	public static function IncludeTemplateLangFile($file) { }
	
	//
	public static function IsAdmin()
	{
		return false;
	}
	
	//
	public static function SetPageProperty() { }
	
	//
	public static function ShowHead()
	{
		$_css = array('reset', 'styles', 'template_styles', 'ie');
		foreach($_css as $css)
		{
			echo '<link rel="stylesheet" type="text/css" href="/'.SITE_TEMPLATE_PATH.'/'.$css.'.css" />';
		}
	}
	
	//
	public static function ShowPanel() { }
	
	//
	public static function ShowTitle() { echo 'РосЯма bitrix-free'; }
}

?>