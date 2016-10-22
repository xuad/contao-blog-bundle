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
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
	(
	'xuad_blog',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
	(
	// Models
	'xuad_blog\NewsArticle' => 'src/Xuad/BlogBundle/Resources/contao/models/NewsArticle.php',
	'xuad_blog\NewsCategory' => 'src/Xuad/BlogBundle/Resources/contao/models/NewsCategory.php',
	// Modules
	'xuad_blog\ModuleModNewsList' => 'src/Xuad/BlogBundle/Resources/contao/modules/ModuleModNewsList.php',
	'xuad_blog\ModuleNewsArchiveList' => 'src/Xuad/BlogBundle/Resources/contao/modules/ModuleNewsArchiveList.php',
	'xuad_blog\ModuleModNewsArchive' => 'src/Xuad/BlogBundle/Resources/contao/modules/ModuleModNewsArchive.php',
	'xuad_blog\ModuleJsonNews' => 'src/Xuad/BlogBundle/Resources/contao/modules/ModuleJsonNews.php',
	// Classes
	'xuad_blog\Helper' => 'src/Xuad/BlogBundle/Resources/contao/classes/Helper.php',
	'xuad_blog\NewsMods' => 'src/Xuad/BlogBundle/Resources/contao/classes/NewsMods.php',
	'xuad_blog\ExtEnvironment' => 'src/Xuad/BlogBundle/Resources/contao/classes/ExtEnvironment.php',
	// Tags
	'xuad_blog\Tags' => 'src/Xuad/BlogBundle/Resources/contao/classes/Tags.php',
));

/**
 * Register the templates
 */
TemplateLoader::addFiles(array
	(
	'mod_newsarchivelist' => 'src/Xuad/BlogBundle/Resources/contao/templates',
	'mod_categorynewslist' => 'src/Xuad/BlogBundle/Resources/contao/templates',
	'mod_authorbox' => 'src/Xuad/BlogBundle/Resources/contao/templates',
	'mod_tags' => 'src/Xuad/BlogBundle/Resources/contao/templates',
	'mod_newsrelated' => 'src/Xuad/BlogBundle/Resources/contao/templates'
));
