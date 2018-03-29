<?php

namespace Xuad\BlogBundle\Test\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Xuad\BlogBundle\DependencyInjection\Configuration;

class ConfigurationTest extends TestCase
{
    public function testObjectInstantiation() : void
    {
        $extension = new Configuration();

        $this->assertInstanceOf(Configuration::class, $extension);
    }
}
