<?php

namespace Opifer\EavBundle\Tests\Model;

use Mockery as m;
use Opifer\EavBundle\Model\Template;
use Opifer\EavBundle\Model\ValueSet;

class ValueSetTest extends \PHPUnit_Framework_TestCase
{
    public function testTemplate()
    {
        $valueSet = new ValueSet();
        $template = new Template();

        $expected = $template;
        $valueSet->setTemplate($template);
        $actual = $valueSet->getTemplate();

        $this->assertSame($expected, $actual);
    }
}