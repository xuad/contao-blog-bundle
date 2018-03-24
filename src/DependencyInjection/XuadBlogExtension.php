<?php

namespace Xuad\BlogBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class XuadBlogExtension
 *
 * @package Xuad\BlogBundle\DependencyInjection
 */
class XuadBlogExtension extends Extension
{
    /** @var array */
    private const FILES = [
        'services.yml',
        'listener.yml',
        'parameters.yml'
    ];

    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container) : void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );

        foreach (XuadBlogExtension::FILES as $file)
        {
            $loader->load($file);
        }

        if (isset($config['enabled']) && $config['enabled'] === true)
        {
            $container->setParameter(
                'xuad_blog.news_archive_category_parameter_name',
                $config['news_archive_category_parameter_name']
            );
        }
    }
}