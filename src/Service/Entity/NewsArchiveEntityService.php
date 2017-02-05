<?php

namespace Xuad\BlogBundle\Service\Entity;

use Xuad\BlogBundle\Repository\NewsArchiveRepository;

/**
 * NewsArchiveEntityService
 *
 * @author Patrick Mosch <https://xuad.net>
 */
class NewsArchiveEntityService
{
    /** @var NewsArchiveRepository */
    private $newsArchiveRepository;

    /**
     * NewsArchiveService constructor.
     *
     * @param NewsArchiveRepository $newsArchiveRepository
     */
    public function __construct(
        NewsArchiveRepository $newsArchiveRepository)
    {
        $this->newsArchiveRepository = $newsArchiveRepository;
    }

    /**
     * @param string $alias
     *
     * @return int
     */
    public function getNewsArchiveIdByAlias(string $alias): int
    {
        if(!$alias)
        {
            return null;
        }

        $id = null;
        $newsArchive = $this->newsArchiveRepository->getByAlias($alias);

        if($newsArchive !== null)
        {
            $id = $newsArchive->id;
        }

        return $id;
    }
}