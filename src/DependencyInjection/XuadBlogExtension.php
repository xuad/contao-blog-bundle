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
    private $files = [
        'services.yml',
        'listener.yml',
        'parameters.yml'
    ];

    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );

        foreach($this->files as $file)
        {
            $loader->load($file);
        }

        if(isset($config['enabled']) && $config['enabled'] === true)
        {
            $container->setParameter(
                'xuad_blog.news_archive_category_parameter_name',
                $config['news_archive_category_parameter_name']);
        }
    }
}