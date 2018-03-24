<?php

namespace Xuad\BlogBundle\Repository;

use Contao\Database;
use Contao\NewsArchiveModel;

class NewsArchiveRepository
{
    /**
     * @return Database\Result|mixed
     */
    public function getArchiveObjectList()
    {
        $query = /** @lang */
            'SELECT
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

        return Database::getInstance()->prepare($query)->execute(true);
    }

    /**
     * @param $id
     *
     * @return NewsArchiveModel|null
     */
    public function getById(int $id) : NewsArchiveModel
    {
        return NewsArchiveModel::findById($id);
    }

    /**
     * @param $alias
     *
     * @return NewsArchiveModel|null
     */
    public function getByAlias(string $alias) : NewsArchiveModel
    {
        return NewsArchiveModel::findByIdOrAlias($alias);
    }

    /**
     * @param string $alias
     *
     * @return Database\Result|mixed
     */
    public function getListByAlias(string $alias)
    {
        $query = /** @lang */
            'SELECT
                    id
                  FROM
                    tl_news_archive
                  WHERE alias=?';

        return Database::getInstance()->prepare($query)->execute($alias);
    }
}