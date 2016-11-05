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
 * Class ModuleNewsArchiveList
 *
 * @copyright  Patrick Mosch
 * @author     Patrick Mosch
 * @package    xuad_blog
 */
class ModuleNewsArchiveList extends \ModuleNews
{
    /**
     * Template
     *
     * @var string
     */
    protected $strTemplate = 'mod_newsarchivelist';

    /**
     * Generate module
     *
     * @deprecated can be delete
     */
    protected function compile()
    {
        $catID = $this->Input->get("kategorie", true);

        // Count categories
        $objCategories = $this->Database->prepare("SELECT * FROM tl_news_archive")->execute();

        $existsCategories = false;
        $categories = [];

        // Check query has rows
        if($objCategories->numRows)
        {
            $existsCategories = true;

            // Save archive ids
            $archives = [];

            while($objCategories->next())
            {
                $archives[] = $objCategories->id;
            }

            // Hide secured archive
            $archiveIDs = $this->sortOutProtected(deserialize($archives));

            foreach($archiveIDs as $id)
            {
                $objCat = $this->Database->prepare("SELECT * FROM tl_news_archive WHERE id=?")->limit(1)->execute($id, 1);

                if($objCat->numRows)
                {
                    $objTotal = $this->Database->prepare("SELECT COUNT(*) as total FROM tl_news WHERE pid=?")->execute($objCat->id, 1);

                    $isActive = false;

                    // Check category exists
                    if(isset($catID))
                    {
                        if($catID === $objCat->alias)
                        {
                            $isActive = true;
                        }
                    }

                    if($objTotal->numRows)
                    {
                        $serializedNewsArchive = deserialize($this->news_archives);
                        $pageObj = \Module::getPageDetails($this->jumpTo);

                        if(isset($pageObj))
                        {
                            $url = $this->generateFrontendUrl($pageObj->row(), "/kategorie/" . strtolower($objCat->alias));
                        }

                        // Check is category not empty
                        if($objTotal->total > 0 && in_array($id, $serializedNewsArchive) && $this->isPublishedNewsInArchive($objCat->id))
                        {
                            $categories[] = [
                                "name" => $objCat->title,
                                "count" => $objTotal->total,
                                "link" => $url,
                                "isActive" => $isActive];
                        }
                    }
                    else
                    {
                        throw new \Exception("No News with ID $objTotal->id available");
                    }
                }
                else
                {
                    throw new \Exception("No news-archive with ID $id available");
                }
            }
        }

        $this->Template->existsCategories = $existsCategories;
        $this->Template->categories = $this->sortCategories($categories);
        $this->Template->class = $this->class[1];
    }

    /**
     * Sort alphabetically category names
     *
     * @param Array $categories
     *
     * @return Array
     */
    protected function sortCategories($categories)
    {
        $categoryNames = [];

        // Save category names as array
        foreach($categories as $value)
        {
            $categoryNames[] = $value["name"];
        }

        $array_lowercase = array_map('strtolower', $categoryNames);
        array_multisort($array_lowercase, SORT_ASC, SORT_STRING, $categories);

        return $categories;
    }

    /**
     * Check has news archive active news
     *
     * @param $archiveId
     */
    protected function isPublishedNewsInArchive($archiveId)
    {
        $dbObjects = $this->Database->prepare("SELECT * FROM tl_news WHERE pid=? AND published=?")->execute($archiveId, 1);

        if($dbObjects->numRows > 0)
        {
            return true;
        }
        else
        {
            return false;
        }

    }
}