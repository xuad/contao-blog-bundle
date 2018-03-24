<?php

namespace Xuad\BlogBundle\Module;

use Contao\CoreBundle\Exception\PageNotFoundException;
use Contao\Input;
use Contao\ModuleModel;
use Contao\ModuleNews;
use Contao\PageModel;
use Contao\System;
use Xuad\BlogBundle\Service\Entity\NewsArchiveEntityService;
use Xuad\BlogBundle\Service\ModuleNewsArchiveService;

class ModuleNewsArchiveList extends ModuleNews
{
    /** @var string */
    protected $strTemplate = 'mod_newsarchivelist';

    /** @var ModuleNewsArchiveService */
    private $moduleNewsArchiveService;

    /** @var NewsArchiveEntityService */
    private $newsArchiveEntityService;

    /** @var string */
    private $categoryParameterName;

    /**
     * ModuleNewsArchiveList constructor.
     *
     * @param ModuleModel $objModule
     * @param string $strColumn
     *
     * @throws \Symfony\Component\DependencyInjection\Exception\InvalidArgumentException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     */
    public function __construct(ModuleModel $objModule, $strColumn)
    {
        parent::__construct($objModule, $strColumn);

        $this->moduleNewsArchiveService =
            System::getContainer()->get('xuad_blog.service.module_news_archive_service');
        $this->newsArchiveEntityService =
            System::getContainer()->get('xuad_blog.service.entity.news_archive_entity_service');
        $this->categoryParameterName =
            System::getContainer()->getParameter('xuad_blog.news_archive_category_parameter_name');
    }

    /**
     *
     * @throws \Contao\CoreBundle\Exception\PageNotFoundException
     */
    protected function compile() : void
    {
        $newsArchiveModelList = $this->moduleNewsArchiveService->findNewsArchiveModelList();
        $archiveIdList = $this->moduleNewsArchiveService->getNewsArchiveIdListByNewsArchiveModelList($newsArchiveModelList);
        $publicIdList = $this->sortOutProtected(deserialize($archiveIdList));
        $newsArchiveModelList = $this->moduleNewsArchiveService
            ->getFilteredNewsArchiveModelListByIdList($newsArchiveModelList, $publicIdList);

        $pageModelDetails = PageModel::findWithDetails($this->jumpTo);
        if (!$pageModelDetails)
        {
            throw new PageNotFoundException('');
        }
        $newsArchiveModelList = $this->moduleNewsArchiveService
            ->injectUrl($newsArchiveModelList, $pageModelDetails->alias, $this->categoryParameterName);

        $newsArchiveId = null;
        if (Input::get($this->categoryParameterName) !== null)
        {
            $newsArchiveId = $this->newsArchiveEntityService->getNewsArchiveIdByAlias(Input::get($this->categoryParameterName));
        }
        $newsArchiveModelList = $this->moduleNewsArchiveService
            ->injectActive($newsArchiveModelList, $newsArchiveId);

        $this->Template->newsArchiveModelList = $newsArchiveModelList;
    }
}