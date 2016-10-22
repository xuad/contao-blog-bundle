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
 * Class NewsArticle 
 *
 * @copyright  Patrick Mosch 
 * @author     Patrick Mosch 
 * @package    xuad_blog
 */
class NewsArticle extends \News
{
	/**
	 * News id
	 * @var int
	 */
	protected $newsID;

	/**
	 * CategoryID
	 * @var int
	 */
	protected $categoryID;

	/**
	 * Category name
	 * @var string 
	 */
	protected $categoryName;

	/**
	 * Headline
	 * @var string
	 */
	protected $headline;

	/**
	 * Alias for generated url
	 * @var string 
	 */
	protected $alias;

	/**
	 * Author id
	 * @var int 
	 */
	protected $authorID;

	/**
	 * Author name
	 * @var string 
	 */
	protected $authorName;

	/**
	 * Create date
	 * @var int 
	 */
	protected $date;

	/**
	 * Create time
	 * @var int 
	 */
	protected $time;

	/**
	 * Sub headline
	 * @var string 
	 */
	protected $subheadline = "";

	/**
	 * Articletext as HTML
	 * @var string 
	 */
	protected $text;

	/**
	 * Release the blogarticle
	 * @var boolean
	 */
	protected $published;

	/**
	 * Direct link to article
	 * @var string 
	 */
	protected $link;

	/**
	 * Comments or not
	 * @var boolean
	 */
	protected $noComments;

	/**
	 * Sticky the article
	 * @var boolean 
	 */
	protected $sticky;

	/**
	 * Initialisize object
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Getter methods
	 * 
	 * @param type $strKey
	 * @return type
	 */
	public function __get($strKey)
	{

		switch($strKey)
		{
			case "newsID":
				return $this->newsID;
			case "categoryID":
				return $this->categoryID;
			case "categoryName":
				return $this->categoryName;
			case "headline":
				return $this->headline;
			case "alias":
				return $this->alias;
			case "authorID":
				return $this->authorID;
			case "authorName":
				return $this->authorName;
			case "date":
				return $this->date;
			case "time":
				return $this->time;
			case "subheadline":
				return $this->subheadline;
			case "text":
				return $this->text;
			case "published":
				return $this->published;
			case "link":
				return $this->link;
			case "noComments":
				return $this->noComments;
			case "sticky":
				return $this->sticky;
		}

		return parent::__get($strKey);
	}

	/**
	 * Setter methods
	 * 
	 * @param type $strKey
	 * @param type $varValue
	 */
	public function __set($strKey, $varValue)
	{

		switch($strKey)
		{
			case "newsID":
				$this->newsID = $varValue;
				break;
			case "categoryID":
				$this->categoryID = $varValue;
				break;
			case "categoryName":
				$this->categoryName = $varValue;
				break;
			case "headline":
				$this->headline = $varValue;
				break;
			case "alias":
				$this->alias = $varValue;
				break;
			case "authorID":
				$this->authorID = $varValue;
				break;
			case "authorName":
				$this->authorName = $varValue;
				break;
			case "date":
				$this->date = $varValue;
				break;
			case "time":
				$this->time = $varValue;
				break;
			case "subheadline":
				$this->subheadline = $varValue;
				break;
			case "text":
				$this->text = $this->getValidHTML($varValue);
				break;
			case "published":
				$this->published = $varValue;
				break;
			case "link":
				$this->link = $varValue;
				break;
			case "noComments":
				$this->noComments = $varValue;
				break;
			case "sticky":
				$this->sticky = $varValue;
				break;
			default:
				parent::__set($strKey, $varValue);
				break;
		}
	}

	/**
	 * Clean dirty Windows-Live-Writer code to valid code
	 * 
	 * @param type $text
	 * @return type
	 */
	protected function getValidHTML($htmlString)
	{

		// Delete direct url
		$this->import("Environment");
		$domain = (\Environment::get('ssl') ? 'https://' : 'http://') . \Environment::get('host') . TL_PATH . '/';

		$src = 'src="' . $domain;
		$htmlString = str_replace($src, 'src="', $htmlString);

		$href = 'href="' . $domain;
		$htmlString = str_replace($href, 'href="', $htmlString);

		// Delete style-param
		$htmlString = preg_replace('/style=\".*?\"/', '', $htmlString);

		// Remove font-tag
		$htmlString = preg_replace("/<\\/?font(\\s+.*?>|>)/", "", $htmlString);

		$htmlString = str_replace('align="left"', 'class="align-left"', $htmlString);
		$htmlString = str_replace('align="right"', 'class="align-right"', $htmlString);
		$htmlString = str_replace('align="center"', 'class="align-center"', $htmlString);
		$htmlString = str_replace('align="justify"', 'class="align-justify"', $htmlString);


		return $htmlString;
	}
}