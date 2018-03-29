<?php

namespace Xuad\BlogBundle\Test\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Xuad\BlogBundle\DependencyInjection\XuadBlogExtension;

class XuadBlogExtensionTest extends TestCase
{
    public function testObjectInstantiation() : void
    {
        $extension = new XuadBlogExtension();

        $this->assertInstanceOf(XuadBlogExtension::class, $extension);
    }

    /**
     * @throws \Exception
     */
    public function testLoad() : void
    {
        $container = new ContainerBuilder(new ParameterBag(['kernel.debug' => false]));

        $extension = new XuadBlogExtension();
        $extension->load([], $container);

        $this->assertTrue($container->has('xuad_blog.listener.parse_article_list'));
    }
}