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
$GLOBALS['TL_DCA']['tl_tags'] = array
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
		'tag' => array
			(
			'sql' => "varchar(255) NOT NULL default ''"
		),
	)
);

