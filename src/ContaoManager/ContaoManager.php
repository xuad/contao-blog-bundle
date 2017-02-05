<?php


namespace Xuad\BlogBundle\ContaoManager;


use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;

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
            BundleConfig::create('Contao\NewsBundle\ContaoNewsBundle')
                        ->setLoadAfter(['Contao\CoreBundle\ContaoCoreBundle'])
                        ->setReplace(['news']),
        ];
    }
}