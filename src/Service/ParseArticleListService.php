<?php

namespace Xuad\BlogBundle\Service;

use Xuad\BlogBundle\Repository\NewsArchiveRepository;

class ParseArticleListService
{
    /** @var NewsArchiveRepository */
    private $newsArchiveRepository;

    /**
     * NewsArchiveService constructor.
     *
     * @param NewsArchiveRepository $newsArchiveRepository
     */
    public function __construct(NewsArchiveRepository $newsArchiveRepository)
    {
        $this->newsArchiveRepository = $newsArchiveRepository;
    }

    /**
     * @param $id
     *
     * @return string
     */
    public function getArchiveNameById($id) : string
    {
        $name = '';

        /** @var mixed $contaoNewsArchiveModel */
        $contaoNewsArchiveModel = $this->newsArchiveRepository->getById($id);
        if ($contaoNewsArchiveModel !== null)
        {
            $name = $contaoNewsArchiveModel->title;
        }

        return $name;
    }

    /**
     * @param int $id
     * @param string $text
     *
     * @return mixed|string
     */
    public function replaceWithAutomaticLightBox(int $id, string $text) : string
    {
        $pattern = "/(<a(?![^>]*?data-lightbox=['\"]multi.*)[^>]*?href=['\"][^'\"]+?\.(?:bmp|gif|jpg|jpeg|png)\?{0,1}\S{0,}['\"][^\>]*)>/i";
        $replacement = '$1 data-lightbox="multi[' . $id . ']">';

        $text = preg_replace($pattern, $replacement, $text);

        return $text;
    }
}