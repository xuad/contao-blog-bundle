<?php

/**
 * xuad.net blog system
 * 
 * @package   xuad_blog 
 * @author    Patrick Mosch 
 * @license   LGPL 
 * @copyright Patrick Mosch 
 */

namespace xuad_blog;

/**
 * Class ModuleModNewsArchive
 *
 * @copyright  Patrick Mosch
 * @author     Patrick Mosch
 * @package    xuad_blog
 */
class Helper
{

	/**
	 * Get category from category alias name
	 * @param string $alias
	 * @return int
	 */
	public static function getCategoryByAlias($alias)
	{
		$database = \Contao\Database::getInstance();

		$dbObject = $database->prepare("SELECT * FROM tl_news_archive WHERE alias=?")
			->limit(1)
			->execute($alias, 1);

		// Check query has rows
		if ($dbObject->numRows)
		{
			if (strtolower($dbObject->alias) === $alias)
			{
				return $dbObject;
			}
		}

		return 0;
	}

	/**
	 * Get category alias from category id
	 * @param int $id
	 * @return int
	 */
	public static function getArchiveAliasByID($id)
	{
		$database = \Contao\Database::getInstance();

		$dbObject = $database->prepare("SELECT alias FROM tl_news_archive WHERE id=?")
			->limit(1)
			->execute($id, 1);

		// Check query has rows
		if ($dbObject->numRows)
		{
			if (strtolower($dbObject->id) === $id)
			{
				return $dbObject->alias;
			}
		}

		return 0;
	}

	/**
	 * Add string to pagetitle
	 * @param string $title
	 */
	public static function combineNewsTitle($title, $paginationId = 0, $showPagnition = false)
	{
		global $objPage;

		$pageNumber = \Input::get($paginationId) ? : 1;

		$pageNumberString = sprintf($GLOBALS['TL_LANG']['MSC']['automatic_page_title']['page_and_number'],
			$pageNumber);

		if ($pageNumber !== 1 && $showPagnition)
		{
			if (!empty($title))
			{
				$objPage->pageTitle = sprintf("%s - %s - %s", $objPage->pageTitle, $title,
					$pageNumberString);
			}
			else
			{
				$objPage->pageTitle = sprintf("%s - %s", $objPage->pageTitle,
					$pageNumberString);
			}
		}
		else
		{
			if(!empty($title))
			{
				$objPage->pageTitle = sprintf("%s - %s", $objPage->pageTitle, $title);	
			}			
		}
	}

	/**
	 * Append text to meta description
	 * @global object $objPage
	 * @param int $paginationId
	 * @param string $title
	 */
	public static function appendPageNumberToMetaDescription($paginationId, $title)
	{
		global $objPage;

		$pageNumber = \Input::get($paginationId) ? : 1;

		if(!empty($title))
		{
			$objPage->description = sprintf("%s - %s - %s", $objPage->description, $title ,sprintf($GLOBALS['TL_LANG']['MSC']['automatic_page_title']['page_and_number'],$pageNumber));
		}
		else
		{
			$objPage->description = sprintf("%s - %s", $objPage->description ,sprintf($GLOBALS['TL_LANG']['MSC']['automatic_page_title']['page_and_number'], $pageNumber));
		}
	}
}
