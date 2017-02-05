<?php

namespace Xuad\BlogBundle\Test;

use PHPUnit\Framework\TestCase;
use Xuad\BlogBundle\XuadBlogBundle;

/**
 * Tests blog bundle
 *
 * @author Patrick Mosch <https://xuad.net>
 */
class XuadBlogBundleTest extends TestCase
{
    public function testObjectInstantiation()
    {
        $bundle = new XuadBlogBundle();

        $this->assertInstanceOf('Xuad\BlogBundle\XuadBlogBundle', $bundle);
    }
}