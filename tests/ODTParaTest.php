<?php

namespace  OpenDocumentGenerator;

use PHPUnit\Framework\TestCase;

class ODTParaTest extends TestCase {
    public function testConstructor() {
        $element = new ODTPara("Some text");
        $this->assertEquals("<text:p text:style-name=\"Standard\" >\nSome text\n</text:p>", $element->get_xml());
    }
}

?>