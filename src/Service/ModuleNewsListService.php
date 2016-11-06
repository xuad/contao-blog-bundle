<?php

namespace Xuad\BlogBundle\Service;

use Xuad\BlogBundle\Repository\NewsArchiveRepository;

/**
 * ModuleNewsListService
 *
 * @author Patrick Mosch <https://xuad.net>
 */
class ModuleNewsListService
{
    /**
     * @var NewsArchiveRepository
     */
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
     * Get archive id by alias
     *
     * @param string $alias
     *
     * @return int
     */
    public function getNewsArchiveIdByAlias(string $alias):int
    {
        $id = null;
        $newsArchive = $this->newsArchiveRepository->getByAlias($alias);

        if($newsArchive !== null)
        {
            $id = $newsArchive->id;
        }

        return $id;
    }
}