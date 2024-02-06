<?php

namespace OpenOfficeGenerator;

use PHPUnit\Framework\TestCase;

class ODTElementTest extends TestCase
{
    public function testConstructor()
    {
        $element = new ODTElement("test-namespace", "test-name");
        $this->assertEquals("test-name", $element->name);
    }
}

?>