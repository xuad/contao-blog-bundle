<?php

namespace Xuad\BlogBundle\Module;

use Contao\ModuleModel;
use Contao\ModuleNews;
use Contao\PageModel;
use Xuad\BlogBundle\Service\NewsArchiveService;

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
     * @var NewsArchiveService
     */
    private $newsArchiveService;

    /**
     * ModuleNewsArchiveList constructor.
     *
     * @param ModuleModel $objModule
     * @param string $strColumn
     */
    public function __construct(ModuleModel $objModule, $strColumn)
    {
        parent::__construct($objModule, $strColumn);

        $this->newsArchiveService = \System::getContainer()->get('xuad_blog_extension.service.news_archive_service');
    }

    /**
     * Generate module
     */
    protected function compile()
    {
        /** @var object $this */

        $newsArchiveModelList = $this->newsArchiveService->findNewsArchiveModelList();
        $archiveIdList = $this->newsArchiveService->getNewsArchiveIdListByNewsArchiveModelList($newsArchiveModelList);
        $publicIdList = $this->sortOutProtected(deserialize($archiveIdList));
        $newsArchiveModelList = $this->newsArchiveService
            ->getFilteredNewsArchiveModelListByIdList($newsArchiveModelList, $publicIdList);

        // TODO PM: save and load from db
        $parameterName = 'kategorie';

        $pageModelDetails = PageModel::findWithDetails($this->jumpTo);
        $newsArchiveModelList = $this->newsArchiveService
            ->injectUrl($newsArchiveModelList, $pageModelDetails->alias, $parameterName);

        $newsArchiveModelList = $this->newsArchiveService
            ->injectActive($newsArchiveModelList, $this->Input->get($parameterName, true));
        //            ->injectActive($newsArchiveModelList, 10);

        $this->Template->newsArchiveModelList = $newsArchiveModelList;
    }
}