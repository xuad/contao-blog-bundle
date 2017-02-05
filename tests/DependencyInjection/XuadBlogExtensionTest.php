<?php

namespace Xuad\BlogBundle\Test\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Xuad\BlogBundle\DependencyInjection\XuadBlogExtension;

/**
 * Class XuadBlogExtensionTest
 *
 * @package Xuad\BlogBundle\Test\DependencyInjection
 */
class XuadBlogExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testObjectInstantiation()
    {
        $extension = new XuadBlogExtension();

        $this->assertInstanceOf('Xuad\BlogBundle\DependencyInjection\XuadBlogExtension', $extension);
    }

    public function testLoad()
    {
        $container = new ContainerBuilder(new ParameterBag(['kernel.debug' => false]));

        $extension = new XuadBlogExtension();
        $extension->load([], $container);

        $this->assertTrue($container->has('xuad_blog.listener.parse_article_list'));
    }
}