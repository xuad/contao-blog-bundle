<?php

namespace Xuad\BlogBundle\Service;

use Xuad\BlogBundle\Repository\NewsArchiveRepository;

/**
 * ParseArticleListService
 *
 * @author Patrick Mosch <https://xuad.net>
 */
class ParseArticleListService
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
     * Get archive name by id
     *
     * @param $id
     *
     * @return string
     */
    public function getArchiveNameById($id)
    {
        $name = '';

        /** @var object $contaoNewsArchiveModel */
        $contaoNewsArchiveModel = $this->newsArchiveRepository->getOneById($id);
        if($contaoNewsArchiveModel !== null)
        {
            $name = $contaoNewsArchiveModel->title;
        }

        return $name;
    }
}