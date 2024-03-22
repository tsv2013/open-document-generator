<?php

namespace OpenDocumentGenerator;

use PHPUnit\Framework\TestCase;

class ODElementTest extends TestCase {
    public function testConstructor() {
        $element = new ODElement("test-namespace", "test-name");
        $this->assertEquals("<test-namespace:test-name  >\n</test-namespace:test-name>", $element->get_xml());
    }
    public function testParseXml() {
        $element = new ODElement("", "");
        $element->parse_xml("<test-namespace:test-name  ></test-namespace:test-name>");
        $this->assertEquals("<test-namespace:test-name  />", $element->get_xml());
    }
}

?>