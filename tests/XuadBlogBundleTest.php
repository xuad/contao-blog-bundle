<?php

namespace Xuad\BlogBundle\Test;

use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_TestCase;
use Xuad\BlogBundle\XuadBlogBundle;

/**
 * Tests blog bundle
 *
 * @author Patrick Mosch <https://xuad.net>
 */
class XuadBlogBundleTest extends PHPUnit_Framework_TestCase
{
    public function testObjectInstantiation()
    {
        $bundle = new XuadBlogBundle();

        $this->assertInstanceOf('Xuad\BlogBundle\XuadBlogBundle', $bundle);
    }
}