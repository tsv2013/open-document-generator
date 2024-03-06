<?php

namespace OpenOfficeGenerator;

use PHPUnit\Framework\TestCase;

class ODTElementTest extends TestCase {
    public function testConstructor() {
        $element = new ODTElement("test-namespace", "test-name");
        $this->assertEquals("<test-namespace:test-name  >\n</test-namespace:test-name>", $element->get_xml());
    }
    public function testParseXml() {
        $element = new ODTElement("", "");
        $element->parse_xml("<test-namespace:test-name  ></test-namespace:test-name>");
        $this->assertEquals("<test-namespace:test-name  />", $element->get_xml());
    }
}

?>