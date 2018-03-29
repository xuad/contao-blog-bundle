<?php

namespace Xuad\BlogBundle\Test\ContaoManager;

use PHPUnit\Framework\TestCase;
use Xuad\BlogBundle\ContaoManager\Plugin;

class PluginTest extends TestCase
{
    public function testObjectInstantiation() : void
    {
        $extension = new Plugin();

        $this->assertInstanceOf(Plugin::class, $extension);
    }
}
