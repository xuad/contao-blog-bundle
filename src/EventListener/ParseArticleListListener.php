<?php

namespace Xuad\BlogBundle\EventListener;

use Contao\Frontend;
use Contao\FrontendTemplate;
use Xuad\BlogBundle\Service\ParseArticleListService;

/**
 * Hook to manipulate news list
 *
 * @author Patrick Mosch <https://xuad.net>
 */
class ParseArticleListListener extends Frontend
{
    /**
     * @var ParseArticleListService
     */
    private $parseArticleListService;

    /**
     * ParseArticleListListener constructor.
     *
     * @param ParseArticleListService $parseArticleListService
     */
    public function __construct(
        ParseArticleListService $parseArticleListService)
    {
        $this->parseArticleListService = $parseArticleListService;
        parent::__construct();
    }

    /**
     * On parse articles
     *
     * @param FrontendTemplate $objTemplate
     */
    public function onParseArticles(FrontendTemplate $objTemplate)
    {
        /** @var FrontendTemplate|object $objTemplate */

        $dateTimeObject = null;
        if(!empty($objTemplate->datetime))
        {
            $dateTimeObject = new \DateTime($objTemplate->datetime);
        }

        $objTemplate->dateTimeObject = $dateTimeObject;
        $objTemplate->dateMonth = $GLOBALS['TL_LANG']['MONTHS'][$dateTimeObject->format('n') - 1];
        $objTemplate->dateDay = $dateTimeObject->format('d');
        $objTemplate->dateYear = $dateTimeObject->format('Y');
        $objTemplate->archiveName = $this->parseArticleListService->getArchiveNameById($objTemplate->pid);
    }
}