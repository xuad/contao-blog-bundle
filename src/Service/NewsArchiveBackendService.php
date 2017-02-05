<?php

namespace Xuad\BlogBundle\Service;

use Contao\DataContainer;
use Contao\StringUtil;
use Xuad\BlogBundle\Repository\NewsArchiveRepository;

/**
 * Class NewsArchiveBackendService
 *
 * @package Xuad\BlogBundle\Service
 */
class NewsArchiveBackendService
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
     * @param $alias
     * @param DataContainer $dataContainer
     *
     * @return string
     */
    public function getNewAliasByValueAndDataContainer(string $alias, DataContainer $dataContainer): string
    {
        $autoAlias = false;
        if(empty($alias))
        {
            $autoAlias = true;
            $alias = standardize(StringUtil::restoreBasicEntities(
                $dataContainer->activeRecord->title));
        }

        $newsArchiveList = $this->getNewsArchiveIdListByAlias($alias);
        if(count($newsArchiveList) > 1 && !$autoAlias)
        {
            throw new \LogicException();
        }

        if(!empty($newsArchiveList) && $autoAlias)
        {
            $alias .= '-' . $dataContainer->id;
        }

        return $alias;
    }

    /**
     * @param string $alias
     *
     * @return array
     */
    private function getNewsArchiveIdListByAlias(string $alias): array
    {
        $idList = [];

        $resultList = $this->newsArchiveRepository->getListByAlias($alias);
        while($resultList->next())
        {
            $idList[$resultList->id] = $resultList->id;
        }

        return $idList;
    }
}