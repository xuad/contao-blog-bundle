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
 * Class NewsCategory 
 *
 * @copyright  Patrick Mosch 
 * @author     Patrick Mosch 
 * @package    xuad_blog
 */
class NewsCategory
{
	/**
	 * Category id
	 * @var int
	 */
	public $categoryID;

	/**
	 * Parent id (not used)
	 * @var int 
	 */
	public $parentID = 0;

	/**
	 * Category name
	 * @var string
	 */
	public $categoryName = "";

	/**
	 * Url html
	 * @var string
	 */
	public $htmlUrl = "";

	/**
	 * Url rss
	 * @var string 
	 */
	public $rssUrl = "";

	/**
	 * Initialisize object
	 */
	public function __construct()
	{
		
	}
}