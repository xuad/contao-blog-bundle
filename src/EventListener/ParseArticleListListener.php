<?php

namespace Xuad\BlogBundle\EventListener;

use Contao\FrontendTemplate;
use Contao\ModuleNews;

/**
 * Description of class
 *
 * @author Patrick Mosch <https://xuad.net>
 */
class ParseArticleListListener extends \Frontend
{
    /**
     * On parse articles
     *
     * @param FrontendTemplate $objTemplate
     * @param array $objArticle
     * @param ModuleNews $moduleNews
     *
     * @property-read \stdClass $frontendTemplate
     */
    public function onParseArticles(FrontendTemplate $objTemplate, array $objArticle, ModuleNews $moduleNews)
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
    }
}