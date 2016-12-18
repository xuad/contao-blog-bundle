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
 * Register the templates
 */
TemplateLoader::addFiles(array
	(
	'mod_newsarchivelist' => 'vendor/xuad/contao-blog-bundle/src/Resources/contao/templates',
	'mod_categorynewslist' => 'vendor/xuad/contao-blog-bundle/src//Resources/contao/templates',
	'mod_authorbox' => 'vendor/xuad/contao-blog-bundle/src//Resources/contao/templates',
	'mod_tags' => 'vendor/xuad/contao-blog-bundle/src//Resources/contao/templates',
	'mod_newsrelated' => 'vendor/xuad/contao-blog-bundle/src//Resources/contao/templates'
));
