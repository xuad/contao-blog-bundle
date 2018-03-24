<?php

namespace Xuad\BlogBundle\Service;

use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\CoreBundle\Routing\UrlGenerator;
use Xuad\BlogBundle\Model\NewsArchiveModel;
use Xuad\BlogBundle\Repository\NewsArchiveRepository;

class ModuleNewsArchiveService
{
    /** @var ContaoFrameworkInterface */
    private $framework;

    /** @var NewsArchiveRepository */
    private $newsArchiveRepository;

    /** @var UrlGenerator */
    private $urlGenerator;

    /**
     * NewsArchiveService constructor.
     *
     * @param ContaoFrameworkInterface $framework
     * @param NewsArchiveRepository $newsArchiveRepository
     * @param UrlGenerator $urlGenerator
     */
    public function __construct(
        ContaoFrameworkInterface $framework,
        NewsArchiveRepository $newsArchiveRepository,
        UrlGenerator $urlGenerator
    ) {
        $this->newsArchiveRepository = $newsArchiveRepository;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @return NewsArchiveModel[]
     */
    public function findNewsArchiveModelList() : array
    {
        /** @var object $newsArchiveDataList */
        $newsArchiveDataList = $this->newsArchiveRepository->getArchiveObjectList();

        $newsCategoryModelList = [];
        while ($newsArchiveDataList->next())
        {
            $newsArchiveModel = new NewsArchiveModel();
            $newsArchiveModel
                ->setId($newsArchiveDataList->newsArchiveId)
                ->setTitle($newsArchiveDataList->title)
                ->setNumberOfNews($newsArchiveDataList->newsCount)
                ->setAlias($newsArchiveDataList->alias);

            $newsCategoryModelList[] = $newsArchiveModel;
        }

        return $newsCategoryModelList;
    }

    /**
     * @param NewsArchiveModel[] $newsArchiveModelList
     *
     * @return array
     */
    public function getNewsArchiveIdListByNewsArchiveModelList(array $newsArchiveModelList) : array
    {
        $idList = [];
        foreach ($newsArchiveModelList as $newsArchiveModel)
        {
            $idList[] = $newsArchiveModel->getId();
        }

        return $idList;
    }

    /**
     * @param NewsArchiveModel[] $newsArchiveModelList
     * @param array $idList
     *
     * @return NewsArchiveModel[]
     */
    public function getFilteredNewsArchiveModelListByIdList(array $newsArchiveModelList, array $idList) : array
    {
        foreach ($newsArchiveModelList as $key => $newsArchiveModel)
        {
            if (!$this->checkIsIIdInList($newsArchiveModel->getId(), $idList))
            {
                unset($newsArchiveModelList[$key]);
            }
        }

        return $newsArchiveModelList;
    }

    /**
     * @param NewsArchiveModel[] $newsArchiveModelList
     * @param string $parameterName
     * @param string $pageAlias
     *
     * @return NewsArchiveModel[]
     */
    public function injectUrl(array $newsArchiveModelList, string $pageAlias, string $parameterName) : array
    {
        foreach ($newsArchiveModelList as $newsArchiveModel)
        {
            $url = $this->urlGenerator->generate(
                sprintf('%s/%s/%s', $pageAlias, $parameterName, $newsArchiveModel->getAlias())
            );

            $newsArchiveModel
                ->setUrl($url);
        }

        return $newsArchiveModelList;
    }

    /**
     * @param NewsArchiveModel[] $newsArchiveModelList
     * @param $currentArchiveId
     *
     * @return NewsArchiveModel[]
     */
    public function injectActive(array $newsArchiveModelList, $currentArchiveId) : array
    {
        foreach ($newsArchiveModelList as $newsArchiveModel)
        {
            if ($newsArchiveModel->getId() === $currentArchiveId)
            {
                $newsArchiveModel
                    ->setActive(true);
            }
        }

        return $newsArchiveModelList;
    }

    /**
     * @param int $id
     * @param array $idList
     *
     * @return bool
     */
    private function checkIsIIdInList(int $id, array $idList) : bool
    {
        $isInList = false;
        foreach ($idList as $checkId)
        {
            if ($id === (int)$checkId)
            {
                $isInList = true;
                break;
            }
        }

        return $isInList;
    }
}