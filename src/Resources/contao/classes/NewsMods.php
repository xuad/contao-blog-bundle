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
 * Class NewsMods 
 *
 * @copyright  Patrick Mosch 
 * @author     Patrick Mosch 
 * @package    xuad_blog
 */
class NewsMods extends \Frontend
{
	/**
	 * Template author box
	 * @var string
	 */
	protected $strTemplateAuthorBox = 'mod_authorbox';

	/**
	 * Template author box
	 * @var string
	 */
	protected $strTemplateTags = 'mod_tags';

	/**
	 * Template related news
	 * @var string
	 */
	protected $strTemplateRelated = 'mod_newsrelated';

	/**
	 * Extend news with more template vars
	 * @param type $objTemplate
	 * @param type $objArticle
	 * @param type $instance
	 */
	public function newsListHook(&$objTemplate, $objArticle, &$instance)
	{
		// Get category name
		$objTemplate->categoryName = $this->getCategoryNameByID($objArticle["pid"]);

//		$dateTimeStamp = 0;
//		$dateTimeObject = null;
//
//		if(isset($objTemplate->datetime) && !empty($objTemplate->datetime))
//		{
//			$dateTimeStamp = date_timestamp_get(new \DateTime($objTemplate->datetime));
//			$dateTimeObject = new \DateTime($objTemplate->datetime);
//		}
//
//		// Complete dateTime object
//		$objTemplate->dateTimeObject = $dateTimeObject;
//
//		// Time in seperate vars
//		$objTemplate->dateMonth = $GLOBALS['TL_LANG']['MONTHS'][date('n',
//						$dateTimeStamp) - 1];
//		$objTemplate->dateDay = date('d', $dateTimeStamp);
//		$objTemplate->dateYear = date('Y', $dateTimeStamp);
//
//		// Automatic lightbox
//		$objTemplate->text = $this->addAutomaticLightbox($objTemplate->id,
//				$objTemplate->text);
//
//		$formattedDateTimeArray = array(
//			'dayShort' => $GLOBALS['TL_LANG']['DAYS_SHORT'][date('w', $intStart) - 1],
//			'day' =>  date('d', $dateTimeStamp),
//			'month' =>  date('m', $dateTimeStamp),
//			'year' => date('Y', $dateTimeStamp),
//		);

		// Set formatted dates
		$objTemplate->formattedDateTimeArray = $formattedDateTimeArray;

		// Load author informations
		$objTemplate->authorbox = $this->generateAuthorBox($objArticle);

		// Load tags
		// TODO: write some cool logic code
		// Doesnt works!!!
		//$objTemplate->tags = $this->generateTags($objArticle["id"], $instance->jumpToTagsPage);
		// Load related news
		$objTemplate->relatedNews = $this->generateRelatedNews($objArticle["id"]);
	}

	/**
	 * Generate author information
	 * @param type $objArticle
	 * @return type
	 */
	protected function generateAuthorBox($objArticle)
	{
		// Get author
		$author = \Contao\UserModel::findByPk($objArticle["author"]);

		// Create extra template for author informations
		$template = new \FrontendTemplate($this->strTemplateAuthorBox);

		// Save author informations
		// Save in outsourced template and load them
		$template->authorAboutHeadline = $GLOBALS['TL_LANG']['MSC']['about_headline'];
		$template->authorAboutText = $author->about;
		$template->authorName = $author->name;
		$template->authorGoogle = $author->google;

		// Save author image
		// Add the article image as enclosure
		$image = deserialize($author->avatarImage);
		$imageSize = $author->avatarImageSize;
		$template->enableAvatar = $author->addAvatar;
		$template->authorImageUrl = $this->getUserImage($image, $imageSize);
		$template->authorImageAlt = $author->avatarImageAlt ? $author->avatarImageAlt : "avatar-image";
		$template->authorImageWidth = $author->avatarImageSize[0];
		$template->authorImageHeight = $author->avatarImageSize[1];

		return $template->parse();
	}

	/**
	 * Generate tags list
	 * @param object $objArticle
	 * @return string HTML
	 */
	protected function generateTags($articleId, $tagsPage)
	{
		$tags = Tags::getInstance();
		$savedTags = $tags->getTagsFromArticleId($articleId);
		$templateTags = array();

		foreach($savedTags as $tag)
		{
			$linkToTagsPage = "";

			// Get page details for sortable tags page
			$pageObj = \Module::getPageDetails($tagsPage);

			if(isset($tagsPage) && isset($pageObj))
			{
				$linkToTagsPage = $this->generateFrontendUrl($pageObj->row(),
						"/tags/" . strtolower($tag));
			}

			$templateTags[] = array(
				"isActive" => false,
				"link" => $linkToTagsPage,
				"name" => $tag
			);
		}

		// Create extra template for author informations
		$template = new \FrontendTemplate($this->strTemplateTags);
		$template->tagsLabel = $GLOBALS['TL_LANG']['MSC']['tags_label'];
		$template->tags = $templateTags;

		if(count($templateTags) > 0)
		{
			return $template->parse();
		}

		return "";
	}

	/**
	 * Generate related news
	 * @param type $tag
	 * @return string
	 */
	protected function generateRelatedNews($articleId)
	{
		// get page
		global $objPage;

		$tagIds = array();
		$relatedNews = array();

		// Get all tags from news
		$dbObjectTags = \Database::getInstance()->prepare("
				SELECT
					tl_tags.id AS tagId
				FROM
					tl_tags, tl_tags_relations
				WHERE
					tl_tags.id = tl_tags_relations.tagId
				AND
					tl_tags_relations.pid=?")
				->execute($articleId);

		while($dbObjectTags->next())
		{
			$tagIds[] = $dbObjectTags->tagId;
		}

		if(count($tagIds) > 0)
		{
			// Get related news
			$dbObjectNewsArticles = \Database::getInstance()->prepare("
				SELECT
					tl_news.*
				FROM 
					tl_news
				LEFT JOIN
					tl_tags_relations ON(tl_tags_relations.tagId IN('" . implode("','",
									$tagIds) . "'))
				WHERE
					tl_news.id = tl_tags_relations.pid
				AND
					tl_news.id != ?
					" . (!BE_USER_LOGGED_IN ? "
				AND 
					(tl_news.start = '' OR tl_news.start < ?) 
				AND 
					(tl_news.stop = '' OR tl_news.stop > ?) 
				AND 
					tl_news.published = 1" : "") . "
				GROUP BY
					tl_news.id
				ORDER BY
					tl_news.date DESC")
					->limit(5)
					->execute($articleId, time(), time());


			while($dbObjectNewsArticles->next())
			{
				$relatedNews[] = array
					(
					'headline' => $dbObjectNewsArticles->headline,
					'subheadline' => $dbObjectNewsArticles->subheadline,
					'url' => ampersand($this->generateFrontendUrl($objPage->row(),
									((isset($GLOBALS['TL_CONFIG']['useAutoItem']) && $GLOBALS['TL_CONFIG']['useAutoItem']) ? '/' : '/items/') . ((!$GLOBALS['TL_CONFIG']['disableAlias'] && $dbObjectNewsArticles->alias != '') ? $dbObjectNewsArticles->alias : $dbObjectNewsArticles->id))),
				);
			}
		}

		$template = new \FrontendTemplate($this->strTemplateRelated);
		$template->relatedLabel = $GLOBALS['TL_LANG']['MSC']['related_news_label'];
		$template->relatedNews = $relatedNews;

		if(count($relatedNews) > 0)
		{
			return $template->parse();
		}

		return "";
	}

	/**
	 * Get category name by category id
	 * 
	 * @param int $id
	 * @return string
	 */
	protected function getCategoryNameByID($id)
	{
		$db = \Database::getInstance();
		$dbObject = $db->prepare("SELECT id, title FROM tl_news_archive WHERE id=?")
				->limit(1)
				->execute($id, 1);

		if($dbObject->numRows)
		{
			// Check is the correct id
			if($dbObject->id === $id)
			{
				return $dbObject->title;
			}
		}

		return "";
	}

	/**
	 * Parse news text and add automatic images lightbox 
	 * 
	 * @param type $id
	 * @param type $text
	 * @return type
	 */
	protected function addAutomaticLightbox($id, $text)
	{
		$pattern = "/(<a(?![^>]*?data-lightbox=['\"]multi.*)[^>]*?href=['\"][^'\"]+?\.(?:bmp|gif|jpg|jpeg|png)\?{0,1}\S{0,}['\"][^\>]*)>/i";
		$replacement = '$1 data-lightbox="multi[' . $id . ']">';

		$text = preg_replace($pattern, $replacement, $text);

		return $text;
	}

	/**
	 * Replace non ssl links with https
	 * 
	 * @param type $text
	 */
	protected function replaceLinksOnSSL($text)
	{
		if($_SERVER["HTTPS"])
		{
			$siteurl = $_SERVER['HTTP_HIST'] . TL_PATH;
			$regex = '/(?<!href=["\'])https:\/\//';

			// Delete https://
			$url = preg_replace($regex, '', $siteurl);

			// Replace http to https for links and pictures
			$text = str_replace('src="http://', 'src="https://', $text);
			$text = str_replace('href="http://' . $url, 'href="https://' . $url, $text);
		}

		return $text;
	}

	/**
	 * Get thumbnail image path
	 * @param string $imageObj
	 * @return string
	 */
	public function getUserImage($imageObj, $size)
	{
		$imagePath = \FilesModel::findByUuid($imageObj)->path;

		// Check size if is available
		if(!isset($size) || !is_array($size) || (!$size[0] || !$size[1]))
		{
			$size = array($GLOBALS['TL_XUAD_BLOG']['image']['thumbs']['width'], 
				$GLOBALS['TL_XUAD_BLOG']['image']['thumbs']['height'],
				$GLOBALS['TL_XUAD_BLOG']['image']['thumbs']['crop_mode']);
		}
		
		if(!isset($imagePath) || empty($imagePath))
		{
			// Generate default image
			return \Image::get($GLOBALS['TL_XUAD_BLOG']['image']['thumbs']['no_user'],
							$size[0],
							$size[1],
							$size[2]);
		}

		// Create a new thumbnail or get available thumb for teaser image
		return \Image::get($imagePath,
							$size[0],
							$size[1],
							$size[2]);
	}
}