<?php

/*
	Bitrix header.php replacement
	
	@license http://sam.zoy.org/wtfpl WTFPL
	This program is free software. It comes without any warranty, to
	the extent permitted by applicable law. You can redistribute it
	and/or modify it under the terms of the Do What The Fuck You Want
	To Public License, Version 2, as published by Sam Hocevar. See
	http://sam.zoy.org/wtfpl/COPYING for more details.
*/

define('B_PROLOG_INCLUDED', true);
define('SITE_TEMPLATE_PATH', 'bitrix/templates/st1234');
define('SITE_TEMPLATE_ID', '');

// config
require_once($_SERVER['DOCUMENT_ROOT'].'/not_bitrix/config.php');
// interface realization (platform-dependent)
require_once($_SERVER['DOCUMENT_ROOT'].'/not_bitrix/interface.php');
// common interface, bitrix functions and classes replacements
require_once($_SERVER['DOCUMENT_ROOT'].'/not_bitrix/interface_bx.php');

include($_SERVER['DOCUMENT_ROOT'].'/urlrewrite.php');
if(sizeof($arUrlRewrite))
{
	foreach($arUrlRewrite as $v)
	{
		if(preg_match($v['CONDITION'], $_SERVER['REQUEST_URI'], $_match))
		{
			$v['RULE'] = explode('&', $v['RULE']);
			foreach($v['RULE'] as $rule)
			{
				$rule = explode('=', $rule);
				$_GET[$rule[0]] = $_match[str_replace('$', '', $rule[1])];
			}
			break;
		}
	}
}

header('Content-Type: text/html; charset=utf-8');
include($_SERVER['DOCUMENT_ROOT'].'/'.SITE_TEMPLATE_PATH.'/header.php');

?>