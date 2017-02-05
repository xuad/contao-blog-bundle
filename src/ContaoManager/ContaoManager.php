<?php


namespace Xuad\BlogBundle\ContaoManager;


use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

class Plugin implements BundlePluginInterface
{
    /**
     * @param ParserInterface $parser
     *
     * @return array
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create('Xuad\BlogBundle\XuadBlogBundle')
                        ->setLoadAfter(['Contao\CoreBundle\ContaoCoreBundle'])
                        ->setReplace(['xuad_blog']),
        ];
    }
}