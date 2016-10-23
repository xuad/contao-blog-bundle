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
 * Class ModuleModNewsList 
 *
 * @copyright  Patrick Mosch 
 * @author     Patrick Mosch 
 * @package    xuad_blog
 */
class ModuleModNewsList extends \Contao\ModuleNewsList
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_categorynewslist';

	/**
	 * Category
	 * @var string
	 */
	protected $categoryName;

	/**
	 * Initialisize object
	 * 
	 * @param type $objModule
	 * @param type $strColumn+
	 */
	public function __construct($objModule, $strColumn = 'main')
	{
		parent::__construct($objModule, $strColumn);

		// Category alias from get-var
		$alias = \Input::get("kategorie");

		$category = Helper::getCategoryByAlias($alias);
		$this->categoryName = $category->title;

		// Check existing archive id and replace archiv array
		if(!empty($category->id) && $this->checkExistsArchiveID($category->id) && $objModule->sortNewsList)
		{
			$this->news_archives = array(0 => $category->id);
		}
	}

	/**
	 * Generate module
	 */
	protected function compile()
	{
		parent::compile();

		// Override compile with tag param
		// Set automatic pagetitle
		if($this->automaticPageTitle)
		{
			// Get pagination page id
			$paginationId = sprintf("page_n%s", $this->id);

			if($this->addPageNumber)
			{
				Helper::combineNewsTitle($this->categoryName, $paginationId, true);
			}
			else
			{
				Helper::combineNewsTitle($this->categoryName);
			}

			if($this->appendPageNumberMetaDescription)
			{
				Helper::appendPageNumberToMetaDescription($paginationId, $this->categoryName);
			}
		}
		
		// Sort by tag
		if(\Input::get("tags"))
		{
			$this->compileTags();
		}
	}

	/**
	 * Compile articles sort by a tag
	 * @global type $objPage
	 * @return type
	 */
	protected function compileTags()
	{
		$alias = $this->Input->get("tags", true);

		$tag = Tags::getInstance();

		$offset = intval($this->skipFirst);
		$limit = null;
		$this->Template->articles = array();

		// Maximum number of items
		if($this->numberOfItems > 0)
		{
			$limit = $this->numberOfItems;
		}

		// Get the total number of items
		$intTotal = $tag->countPublishedByPids($alias);

		if($intTotal < 1)
		{
			$this->Template = new \FrontendTemplate('mod_newsarchive_empty');
			$this->Template->empty = $GLOBALS['TL_LANG']['MSC']['emptyList'];
			return;
		}

		$total = $intTotal - $offset;

		// Split the results
		if($this->perPage > 0 && (!isset($limit) || $this->numberOfItems > $this->perPage))
		{
			// Adjust the overall limit
			if(isset($limit))
			{
				$total = min($limit, $total);
			}

			// Get the current page
			$id = 'page_n' . $this->id;
			$page = \Input::get($id) ? : 1;

			// Do not index or cache the page if the page number is outside the range
			if($page < 1 || $page > max(ceil($total / $this->perPage), 1))
			{
				global $objPage;
				$objPage->noSearch = 1;
				$objPage->cache = 0;

				// Send a 404 header
				header('HTTP/1.1 404 Not Found');
				return;
			}

			// Set limit and offset
			$limit = $this->perPage;
			$offset += (max($page, 1) - 1) * $this->perPage;
			$skip = intval($this->skipFirst);

			// Overall limit
			if($offset + $limit > $total + $skip)
			{
				$limit = $total + $skip - $offset;
			}

			// Add the pagination menu
			$objPagination = new \Pagination($total, $this->perPage, $GLOBALS['TL_CONFIG']['maxPaginationLinks'], $id);
			$this->Template->pagination = $objPagination->generate("\n  ");
		}

		// Get the items
		if(isset($limit))
		{
			$objArticles = \NewsModel::findPublishedByPids(array(0 => 1), false, $limit, $offset);
		}
		else
		{
			$objArticles = \NewsModel::findPublishedByPids(array(0 => 1), false, 0, $offset);
		}

		// No items found
		if($objArticles === null)
		{
			$this->Template = new \FrontendTemplate('mod_newsarchive_empty');
			$this->Template->empty = $GLOBALS['TL_LANG']['MSC']['emptyList'];
		}
		else
		{
			$this->Template->articles = $this->parseArticles($objArticles);
		}

		$this->Template->archives = $this->news_archives;
	}

	/**
	 * Check exists archiv category id
	 * 
	 * @param int $id 
	 * @return boolean
	 */
	protected function checkExistsArchiveID($id)
	{
		$dbObject = $this->Database->prepare("SELECT * FROM tl_news_archive WHERE id=?")
				->limit(1)
				->execute($id, 1);

		// Check query has rows
		if($dbObject->numRows)
		{
			if($dbObject->id === $id)
			{
				return true;
			}
		}

		return false;
	}
}