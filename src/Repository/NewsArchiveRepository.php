<?php

namespace Xuad\BlogBundle\Repository;

use Contao\Database;

/**
 * Load data for news archive entity
 *
 * @author Patrick Mosch <https://xuad.net>
 */
class NewsArchiveRepository
{
    /**
     * Find all data
     *
     * @return Database\Result
     */
    public function getArchiveObjectList()
    {
        // TODO PM: Use ORM like doctrine? -> create contao news doctrine entities
        $query = '
            SELECT
                na.id AS newsArchiveId,
                na.title,
                na.alias,
                count(n.id) AS newsCount
            FROM
                tl_news_archive na
            INNER JOIN 
                tl_news n ON n.pid = na.id
            WHERE 
                n.published = ?
            GROUP BY na.id
            ORDER BY na.title ASC';

        $resultList = Database::getInstance()->prepare($query)->execute(true);

        return $resultList;
    }
}