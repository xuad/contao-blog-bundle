<?php

/**
 * xuad.net blog system
 * 
 * @package   xuad_blog 
 * @author    Patrick Mosch 
 * @license   LGPL 
 * @copyright Patrick Mosch 
 */
// Add callback methods
//$GLOBALS['TL_DCA']['tl_news']['config']['onload_callback'][] = array('newsExtended', 'onLoad');
//$GLOBALS['TL_DCA']['tl_news']['config']['onsubmit_callback'][] = array('newsExtended', 'onSubmit');
$GLOBALS['TL_DCA']['tl_news']['config']['ondelete_callback'][] = array('newsExtended', 'onDelete');
$GLOBALS['TL_DCA']['tl_news']['config']['oncopy_callback'][] = array('newsExtended', 'onCopy');

// Modify table tl_news for tags
$GLOBALS['TL_DCA']['tl_news']['palettes']['default'] = str_replace('teaser;', 'teaser;{tags_legend},tags;', $GLOBALS['TL_DCA']['tl_news']['palettes']['default']);

// Add tags input only for text input
$GLOBALS['TL_DCA']['tl_news']['fields']['tags'] = array
	(
	'load_callback' => array
		(
		array('newsExtended', 'loadTags')
	),
	'save_callback' => array
		(
		array('newsExtended', 'saveTags')
	),
	'label' => &$GLOBALS['TL_LANG']['tl_news']['tags'],
	'inputType' => 'text',
	'eval' => array('tl_class' => 'long'),
	'sql' => "char(1) NOT NULL default '1'"
);

use xuad_blog\Tags;

/**
 * Class ModuleModNewsArchive 
 *
 * Manage extended news functionality, e.g. tags
 * 
 * @copyright  Patrick Mosch 
 * @author     Patrick Mosch 
 * @package    xuad_blog
 */
class newsExtended extends tl_news
{

	/**
	 * Initialisize object
	 */
	public function __construct()
	{
		// Call parent constructor
		parent::__construct();
	}

	/**
	 * Call on load object
	 * @param DataContainer $dc
	 */
	public function loadTags($varValue, DataContainer $dc)
	{
		$session = \Session::getInstance();
		$newsId = $session->get("tl_news_copy_original_id");

		// Load original tags when copy news record
		if(isset($newsId))
		{
			$newsId = $session->get("tl_news_copy_original_id");
			// Delete session var
			$session->remove("tl_news_copy_original_id");
		}
		else
		{
			$newsId = $dc->id;
		}

		$tags = Tags::getInstance();

		// Load tags from news id
		$storedTags = $tags->getTagsFromArticleId($newsId);

		if(!$storedTags)
		{
			// Field can not be null
			$storedTags = array();
		}

		return json_encode($storedTags);
	}

	/**
	 * Call when saveobject
	 * 
	 * @param int $varValue
	 * @param DataContainer $dc
	 * @return int Has tags
	 */
	public function saveTags($varValue, DataContainer $dc)
	{
		$tagObjects = json_decode($varValue);

		// Save tags as array
		$arrTags = array();
		foreach($tagObjects as $tag)
		{
			$arrTags[] = $tag->value;
		}

		// Save tags to db
		$tags = Tags::getInstance();
		$tags->saveTags($dc->id, $arrTags);

		// Set true or false
		// Save no data in tags field, data save in tl_tags and tl_tags_relations
		if(strlen($varValue) > 0)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}

	/**
	 * Call on delete object
	 * @param DataContainer $dc
	 */
	public function onDelete(&$instance, $undoInsertId)
	{
		$tags = Tags::getInstance();
		$tags->deleteTagRelation(\Input::get('id'), array());
	}

	/**
	 * Call on copy object
	 * 
	 * @param int $newID
	 * @param object $instance
	 */
	public function onCopy($newID, &$instance)
	{
		// Save original news id for copy tags
		$session = \Session::getInstance();
		$session->set("tl_news_copy_original_id", \Input::get('id'));
	}
}