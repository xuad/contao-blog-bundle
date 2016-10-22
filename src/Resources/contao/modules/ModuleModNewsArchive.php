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
class ModuleModNewsArchive extends \ModuleNewsArchive
{

	/**
	 * Generate module
	 */
	protected function compile()
	{
		parent::compile();

		// Set automatic pagetitle
		if($this->automaticPageTitle)
		{
			// Get pagination page id
			$paginationId = sprintf("page_a%s", $this->id);

			if($this->addPageNumber)
			{
				Helper::combineNewsTitle(trim($this->headline), $paginationId, true);
			}
			else
			{
				Helper::combineNewsTitle(trim($this->headline));
			}

			if($this->appendPageNumberMetaDescription)
			{
				Helper::appendPageNumberToMetaDescription($paginationId, trim($this->headline));
			}
		}
	}
}