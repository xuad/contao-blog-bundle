<?php

/**
 * xuad.net blog system
 * 
 * @package   xuad_blog 
 * @author    Patrick Mosch 
 * @license   LGPL 
 * @copyright Patrick Mosch 
 */
/**
 * FRONT END MODULES
 */
// Show Category navigation
$GLOBALS['FE_MOD']['news']['ModuleNewsArchiveList'] = 'ModuleNewsArchiveList';

// Show all articles and filter that
$GLOBALS['FE_MOD']['news']['newslist'] = 'ModuleModNewsList';

// Modified pagetitle and meta description
$GLOBALS['FE_MOD']['news']['newsarchive'] = 'ModuleModNewsArchive';

/**
 * HOOKS
 */
// Extended news with new vars, automatic lightbox and https links
$GLOBALS['TL_HOOKS']['parseArticles'][] = array('NewsMods', 'newsListHook');

// Backend ajax hooks
$GLOBALS['TL_HOOKS']['executePreActions'][] = array('Tags', 'ajaxExecutePreActions');

/**
 * Extend backend
 */
if(TL_MODE == 'BE')
{
	if(!is_array($GLOBALS['TL_JAVASCRIPT']))
	{
		$GLOBALS['TL_JAVASCRIPT'] = array();
	}

	if(!is_array($GLOBALS['TL_CSS']))
	{
		$GLOBALS['TL_CSS'] = array();
	}

	// Add js files
//	$jquery_src = 'assets/jquery/core/' . reset((scandir(TL_ROOT . '/assets/jquery/core', 1))) . '/jquery.min.js';
//	$jquery_src = 'assets/jquery/core/' . reset((scandir(TL_ROOT . '/assets/jquery/core', 1))) . '/jquery.min.js';
	array_unshift($GLOBALS['TL_JAVASCRIPT'], $jquery_src);
	$GLOBALS['TL_JAVASCRIPT'][] = 'components/jquery/dist/jquery.min.js';
	$GLOBALS['TL_JAVASCRIPT'][] = 'components/jquery-ui/jquery-ui.min.js';
	$GLOBALS['TL_JAVASCRIPT'][] = 'bundles/xuadblog/tagit/js/tagit.js';
	$GLOBALS['TL_JAVASCRIPT'][] = 'bundles/xuadblog/tags-manager.js';

	
	
	// Add css files
	$GLOBALS['TL_CSS'][] = 'components/jquery-ui/themes/base/all.css';
	$GLOBALS['TL_CSS'][] = 'bundles/xuadblog/tagit/css/tagit-awesome-orange.css';
	$GLOBALS['TL_CSS'][] = 'bundles/xuadblog/tags.css';
}

/**
 * DEFAULTS
 */
$GLOBALS['TL_XUAD_BLOG'] = array
	(
	'image' => array
		(
		'thumbs' => array
			(
			'no_user' => 'bundles/xuadblog/img/no_user.png',
			'width' => 75,
			'height' => 75,
		),
		'crop_mode' => 'center_center',
	)
);

/**
 * Frontend
 */
$GLOBALS['TL_HOOKS']['simpleAjax'][] = array('ModuleJsonNews', 'getNews');