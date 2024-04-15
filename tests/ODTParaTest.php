<?php

namespace  OpenDocumentGenerator;

use PHPUnit\Framework\TestCase;

class ODTParaTest extends TestCase {
    public function testConstructor() {
        $element = new ODTPara("Some text");
        $this->assertEquals("<text:p text:style-name=\"Standard\" >\nSome text\n</text:p>", $element->get_xml());
    }
    public function testEscapeSpecialSymbols() {
        $element = new ODTPara("Some text & < > \" ' should be escaped");
        $this->assertEquals("<text:p text:style-name=\"Standard\" >\nSome text &amp; &lt; &gt; &quot; &#039; should be escaped\n</text:p>", $element->get_xml());
    }
}

?>