<?php

namespace OpenOfficeGenerator;

use PHPUnit\Framework\TestCase;

class OOElementTest extends TestCase {
    public function testConstructor() {
        $element = new OOElement("test-namespace", "test-name");
        $this->assertEquals("<test-namespace:test-name  >\n</test-namespace:test-name>", $element->get_xml());
    }
    public function testParseXml() {
        $element = new OOElement("", "");
        $element->parse_xml("<test-namespace:test-name  ></test-namespace:test-name>");
        $this->assertEquals("<test-namespace:test-name  />", $element->get_xml());
    }
}

?>