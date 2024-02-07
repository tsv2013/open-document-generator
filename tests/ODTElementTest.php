<?php

namespace OpenOfficeGenerator;

use PHPUnit\Framework\TestCase;

class ODTElementTest extends TestCase {
    public function testConstructor() {
        $element = new ODTElement("test-namespace", "test-name");
        $this->assertEquals("<test-namespace:test-name ></test-namespace:test-name>", implode("", iterator_to_array($element->create(), false)));
        $this->assertEquals(["<test-namespace:test-name >", "</test-namespace:test-name>"], iterator_to_array($element->create(), false));
    }
}

?>