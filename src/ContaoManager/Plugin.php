<?php

namespace Xuad\BlogBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Xuad\BlogBundle\XuadBlogBundle;

class Plugin implements BundlePluginInterface
{
    /**
     * @param \Contao\ManagerPlugin\Bundle\Parser\ParserInterface $parser
     *
     * @return array|\Contao\ManagerPlugin\Bundle\Config\ConfigInterface[]
     */
    public function getBundles(ParserInterface $parser) : array
    {
        return [
            BundleConfig::create(XuadBlogBundle::class)
                        ->setLoadAfter([ContaoCoreBundle::class])
                        ->setReplace(['xuad_blog']),
        ];
    }
}