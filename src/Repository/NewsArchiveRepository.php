<?php

namespace Xuad\BlogBundle\Repository;

use Contao\Database;
use Contao\NewsArchiveModel;

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

    /**
     * Get one by id
     *
     * @param $id
     *
     * @return NewsArchiveModel|null
     */
    public function getById(int $id)
    {
        return NewsArchiveModel::findById($id);
    }

    /**
     * Get by alias
     *
     * @param $alias
     *
     * @return NewsArchiveModel|null
     */
    public function getByAlias(string $alias)
    {
        return NewsArchiveModel::findByIdOrAlias($alias);
    }
}