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
 * Class Tags 
 *
 * @copyright  Patrick Mosch 
 * @author     Patrick Mosch 
 * @package    xuad_blog
 */
class Tags extends \Backend
{
	/**
	 * Object instance
	 * @var object 
	 */
	protected static $objInstance = NULL;

	/**
	 * Singleton-Pattern
	 * 
	 * @return object Instance
	 */
	public static function getInstance()
	{
		if(!is_object(self::$objInstance))
		{
			self::$objInstance = new Tags();
		}

		return self::$objInstance;
	}

	/**
	 * Unknown ajax request without dca
	 * 
	 * @param type $strAction
	 */
	public function ajaxExecutePreActions($strAction)
	{
		if($strAction == 'getTagsFromNewsId' && TL_MODE == 'BE')
		{
			$arrReturn = $this->getTagsFromArticleId(\Input::get("id"));

			echo json_encode($arrReturn, JSON_HEX_APOS);
			exit;
		}
		else if($strAction == 'getAllTags' && TL_MODE == 'BE')
		{
			$arrReturn = $this->getAllTags();

			echo json_encode($arrReturn, JSON_HEX_APOS);
			exit;
		}
	}

	/**
	 * Get all tags from news id
	 * 
	 * @param type $id
	 */
	public function getTagsFromArticleId($id)
	{
		$assignTags = array();

		// Get assign news tags
		$dbObj = $this->Database->prepare("
				SELECT 
					tl_tags.tag 
				FROM tl_tags, tl_tags_relations 
				WHERE tl_tags_relations.tagId = tl_tags.id
				AND tl_tags_relations.pid=?")
				->execute($id);

		while($dbObj->next())
		{
			$assignTags[] = $dbObj->tag;
		}

		return $assignTags;
	}

	/**
	 * Get all saved tags
	 * @return type
	 */
	public function getAllTags()
	{
		$tags = array();

		// Get assign news tags
		$dbObj = $this->Database->prepare("
				SELECT 
					tl_tags.tag AS tag, 
					COUNT(tl_tags_relations.tagId) AS count 
				FROM 
					tl_tags, 
					tl_tags_relations 
				WHERE 
					tl_tags.id=tl_tags_relations.tagId 
				GROUP BY 
					tl_tags.tag")
				->execute();

		while($dbObj->next())
		{
			$tags[] = array(
				"tag" => $dbObj->tag,
				"count" => $dbObj->count
			);
		}

		return $tags;
	}

	/**
	 * Save tags to db
	 * 
	 * @param int $newsId
	 * @param Array $tags
	 */
	public function saveTags($newsId, $tags)
	{
		foreach($tags as $tag)
		{
			$tagId = $this->getTagId($tag);

			if(!isset($tagId))
			{
				// Insert new tag
				$dbObj = $this->Database->prepare("INSERT INTO tl_tags (tag) VALUES (?)")
						->execute($tag);

				$tagId = $dbObj->insertId;
			}

			if(!$this->existsRelation($newsId, $tagId) && isset($tagId))
			{
				$this->Database->prepare("INSERT INTO tl_tags_relations (pid, tagId) VALUES (?, ?)")
						->execute($newsId, $tagId);
			}
		}

		// Delete not used relation
		$this->deleteTagRelation($newsId, $tags);
	}

	/**
	 * Delete a tag relation
	 */
	public function deleteTagRelation($newsId, $obtainedTags)
	{
		$dbObj = $this->Database->prepare("SELECT tl_tags.id as tagId, tl_tags.tag as tag, tl_tags_relations.id as relationId, tl_tags_relations.pid as newsId FROM tl_tags, tl_tags_relations WHERE tl_tags_relations.tagId = tl_tags.id AND tl_tags_relations.pid=?")
				->execute($newsId);

		while($dbObj->next())
		{
			// Check tag is exists in obtained Tags
			// All comparisons with lower strings
			if(!in_array(strtolower($dbObj->tag), array_map('strtolower', $obtainedTags)))
			{
				$this->Database->prepare("DELETE FROM tl_tags_relations WHERE id=?")
						->execute($dbObj->relationId);
			}

			// Delete not used relation
			if($dbObj->tagId == null && $dbObj->tag == null)
			{
				$this->Database->prepare("DELETE FROM tl_tags_relations WHERE id=?")
						->execute($dbObj->relationId);
			}
		}

		// Delete not used tags
		$this->deleteNotUsedTags();
	}

	/**
	 * Delete not used tag
	 * @param type $tagId
	 */
	protected function deleteNotUsedTags()
	{
		$dbObj = $this->Database->prepare("SELECT tl_tags.id as tagId, tl_tags.tag as tag, tl_tags_relations.id as relationId FROM tl_tags LEFT JOIN tl_tags_relations ON tl_tags.id = tl_tags_relations.tagId")
				->execute();

		// Delete all tags with no relation
		while($dbObj->next())
		{
			if($dbObj->relationId == null)
			{
				$this->Database->prepare("DELETE FROM tl_tags WHERE id=?")
						->execute($dbObj->tagId);
			}
		}
	}

	/**
	 * Get tag id from database
	 * 
	 * @param string $tag
	 * @return int id
	 */
	protected function getTagId($tag)
	{
		$dbObj = $this->Database->prepare("SELECT id FROM tl_tags WHERE tag=LOWER(?)")
				->limit(1)
				->execute(mb_strtolower($tag, 'UTF-8'));

		if($dbObj->numRows === 1)
		{
			return $dbObj->id;
		}

		return null;
	}

	/**
	 * Check exists relation between tl_tags and tl_tags_relations
	 * 
	 * @param type $newsId
	 * @param type $tag
	 */
	protected function existsRelation($newsId, $tagId)
	{
		$dbObj = $this->Database->prepare("SELECT id FROM tl_tags_relations WHERE pid=? AND tagId=?")
				->execute($newsId, $tagId);

		if($dbObj->numRows)
		{
			return true;
		}

		return false;
	}

	/**
	 * Get tag name from alias name
	 * @param string $alias
	 * @return object
	 */
	public function getTagByAlias($alias)
	{
		$database = \Contao\Database::getInstance();

		$dbObject = $database->prepare("SELECT * FROM tl_tags WHERE tag=?")
				->limit(1)
				->execute(mb_strtolower($alias, 'UTF-8'));

		// Check query has rows
		if($dbObject->numRows)
		{
			return $dbObject;
		}

		return null;
	}

	/**
	 * Get tag count
	 * @param type $tag
	 * @return type
	 */
	public function countPublishedByPids($tag)
	{
		$dbOject = \Database::getInstance()->prepare("SELECT tl_tags_relations.pid FROM tl_tags, tl_tags_relations WHERE tl_tags.id=tl_tags_relations.tagId AND tl_tags.tag=?")
				->execute(mb_strtolower($tag, 'UTF-8'));

		return $dbOject->numRows;
	}
}