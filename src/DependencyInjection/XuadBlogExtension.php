<?php

namespace Xuad\BlogBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Inject some services
 *
 * @author Patrick Mosch <https://xuad.net>
 */
class XuadBlogExtension extends Extension
{
    /**
     * Load services
     *
     * @param array $mergedConfig
     * @param ContainerBuilder $container
     */
    public function load(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );

        $loader->load('services.yml');
        $loader->load('listener.yml');
    }
}