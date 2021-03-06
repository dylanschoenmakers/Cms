<?php

namespace Opifer\EavBundle\Tests\ValueProvider;

use Opifer\EavBundle\ValueProvider\TextValueProvider;

class TextValueProviderTest extends \PHPUnit_Framework_TestCase
{
    private $provider;

    public function __construct()
    {
        $this->provider = new TextValueProvider();
    }

    public function testEntityExists()
    {
        $this->assertTrue(class_exists($this->provider->getEntity()));
    }
}
