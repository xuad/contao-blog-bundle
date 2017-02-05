<?php

namespace Xuad\BlogBundle\Repository;

use Contao\Database;
use Contao\NewsArchiveModel;

/**
 * Class NewsArchiveRepository
 *
 * @package Xuad\BlogBundle\Repository
 */
class NewsArchiveRepository
{
    /**
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
     * @param $id
     *
     * @return NewsArchiveModel|null
     */
    public function getById(int $id): NewsArchiveModel
    {
        return NewsArchiveModel::findById($id);
    }

    /**
     * @param $alias
     *
     * @return NewsArchiveModel|null
     */
    public function getByAlias(string $alias): NewsArchiveModel
    {
        return NewsArchiveModel::findByIdOrAlias($alias);
    }

    /**
     * @param string $alias
     *
     * @return Database\Result|object
     */
    public function getListByAlias(string $alias)
    {
        $query = 'SELECT
                    id
                  FROM
                    tl_news_archive
                  WHERE alias=?';

        $resultList = Database::getInstance()->prepare($query)->execute($alias);

        return $resultList;
    }
}