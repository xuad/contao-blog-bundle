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
 * Table tl_tags
 */
$GLOBALS['TL_DCA']['tl_tags_relations'] = array
	(
	// Config
	'config' => array
		(
		'doNotCopyRecords' => true,
		'sql' => array
			(
			'keys' => array
				(
				'id' => 'primary',
				'pid' => 'index',
				'tagId' => 'index'
			)
		)
	),
	// Fields
	'fields' => array
		(
		'id' => array
			(
			'sql' => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
			(
			'sql' => "int(10) unsigned NOT NULL default '0'"
		),
		'tagId' => array
			(
			'sql' => "int(10) unsigned NOT NULL default '0'"
		),
	)
);

