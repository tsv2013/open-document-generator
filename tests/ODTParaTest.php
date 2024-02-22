<?php

namespace  OpenOfficeGenerator;

use PHPUnit\Framework\TestCase;

class ODTParaTest extends TestCase {
    public function testConstructor() {
        $element = new ODTPara("Some text");
        $this->assertEquals("<text:p text:style-name=\"Standard\" >Some text</text:p>", implode("", iterator_to_array($element->create(), false)));
    }
}

?>