<?php

namespace Xuad\BlogBundle\Module;

use Contao\Input;
use Contao\ModuleModel;
use Contao\ModuleNewsList as ContaoModuleNewsList;
use Contao\System;
use Xuad\BlogBundle\Service\ModuleNewsListService;

/**
 * ModuleNewsList
 *
 * @author Patrick Mosch <https://xuad.net>
 */
class ModuleNewsList extends ContaoModuleNewsList
{
    /**
     * @var ModuleNewsListService
     */
    private $moduleNewsListService;

    /**
     * ModuleNewsList constructor.
     *
     * @param ModuleModel $objModule
     * @param string $strColumn
     */
    public function __construct(ModuleModel $objModule, $strColumn)
    {
        parent::__construct($objModule, $strColumn);

        $this->moduleNewsListService =
            System::getContainer()->get('xuad_blog_extension.service.module_news_list_service');

        $this->filterNewsArchives($objModule);
    }

    /**
     * Generate module
     */
    protected function compile()
    {
        parent::compile();
    }

    /**
     * Filter news archives
     *
     * @param ModuleModel $objModule
     */
    protected function filterNewsArchives(ModuleModel $objModule)
    {
        // TODO PM: move to db or config!
        $newsArchiveAlias = Input::get("kategorie");

        /** @var object $objModule */
        if(!$objModule->sortNewsList || $newsArchiveAlias === null)
        {
            return;
        }

        $archiveId = $this->moduleNewsListService->getNewsArchiveIdByAlias($newsArchiveAlias);
        if($archiveId !== null)
        {
            $this->news_archives = [0 => $archiveId];
        }
    }
}