<?php

namespace Xuad\BlogBundle\Module;

use Contao\Input;
use Contao\ModuleModel;
use Contao\ModuleNews;
use Contao\PageModel;
use Contao\System;
use Xuad\BlogBundle\Service\Entity\NewsArchiveEntityService;
use Xuad\BlogBundle\Service\ModuleNewsArchiveService;

/**
 * Description of class
 *
 * @author Patrick Mosch <https://xuad.net>
 */
class ModuleNewsArchiveList extends ModuleNews
{
    /**
     * Template
     *
     * @var string
     */
    protected $strTemplate = 'mod_newsarchivelist';

    /**
     * @var ModuleNewsArchiveService
     */
    private $moduleNewsArchiveService;

    /**
     * @var NewsArchiveEntityService
     */
    private $newsArchiveEntityService;

    /**
     * ModuleNewsArchiveList constructor.
     *
     * @param ModuleModel $objModule
     * @param string $strColumn
     */
    public function __construct(ModuleModel $objModule, $strColumn)
    {
        parent::__construct($objModule, $strColumn);

        $this->moduleNewsArchiveService =
            System::getContainer()->get('xuad_blog_extension.service.module_news_archive_service');
        $this->newsArchiveEntityService =
            System::getContainer()->get('xuad_blog_extension.service.entity.news_archive_entity_service');
    }

    /**
     * Generate module
     */
    protected function compile()
    {
        /** @var object $this */

        $newsArchiveModelList = $this->moduleNewsArchiveService->findNewsArchiveModelList();
        $archiveIdList = $this->moduleNewsArchiveService->getNewsArchiveIdListByNewsArchiveModelList($newsArchiveModelList);
        $publicIdList = $this->sortOutProtected(deserialize($archiveIdList));
        $newsArchiveModelList = $this->moduleNewsArchiveService
            ->getFilteredNewsArchiveModelListByIdList($newsArchiveModelList, $publicIdList);

        // TODO PM: save and load from db
        $parameterName = 'kategorie';

        $pageModelDetails = PageModel::findWithDetails($this->jumpTo);
        $newsArchiveModelList = $this->moduleNewsArchiveService
            ->injectUrl($newsArchiveModelList, $pageModelDetails->alias, $parameterName);

        $newsArchiveId = $this->newsArchiveEntityService->getNewsArchiveIdByAlias(Input::get($parameterName));
        $newsArchiveModelList = $this->moduleNewsArchiveService
            ->injectActive($newsArchiveModelList, $newsArchiveId);

        $this->Template->newsArchiveModelList = $newsArchiveModelList;
    }
}