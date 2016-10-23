<?php

namespace Xuad\BlogBundle\Module;

use Contao\ModuleNewsList;

/**
 * Description of class
 *
 * @author Patrick Mosch <https://xuad.net>
 */
class ModuleModNewsList extends ModuleNewsList
{
    /**
     * Generate module
     */
    protected function compile()
    {
        parent::compile();

        $stop = "";
    }
}