<?php

namespace Xuad\BlogBundle\Module;

use Contao\Input;
use Contao\ModuleModel;
use Contao\ModuleNewsList as ContaoModuleNewsList;
use Contao\System;
use Xuad\BlogBundle\Service\ModuleNewsListService;

class ModuleNewsList extends ContaoModuleNewsList
{
    /** @var ModuleNewsListService */
    private $moduleNewsListService;

    /** @var string */
    private $categoryParameterName;

    /**
     * ModuleNewsList constructor.
     *
     * @param ModuleModel $objModule
     * @param string $strColumn
     *
     * @throws \Symfony\Component\DependencyInjection\Exception\InvalidArgumentException
     */
    public function __construct(ModuleModel $objModule, $strColumn)
    {
        parent::__construct($objModule, $strColumn);

        $this->moduleNewsListService =
            System::getContainer()->get('xuad_blog.service.module_news_list_service');
        $this->categoryParameterName =
            System::getContainer()->getParameter('xuad_blog.news_archive_category_parameter_name');

        $this->filterNewsArchives($objModule);
    }

    /**
     * @param ModuleModel $objModule
     */
    protected function filterNewsArchives(ModuleModel $objModule) : void
    {
        $newsArchiveAlias = Input::get($this->categoryParameterName);

        /** @var object $objModule */
        if (!$objModule->sortNewsList || $newsArchiveAlias === null)
        {
            return;
        }

        $archiveId = $this->moduleNewsListService->getNewsArchiveIdByAlias($newsArchiveAlias);
        if ($archiveId !== null)
        {
            $this->news_archives = [0 => $archiveId];
        }
    }
}