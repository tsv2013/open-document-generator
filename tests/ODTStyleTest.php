<?php

namespace  OpenOfficeGenerator;

use PHPUnit\Framework\TestCase;

class ODTStyleTest extends TestCase {
    public function testConstructor() {
        $element = new ODTStyle("Custom");
        $property = new \ReflectionProperty("OpenOfficeGenerator\ODTStyle", "content");
        $property->setAccessible(true);
        $style_properties = $property->getValue($element);
        $this->assertIsList($style_properties);
        $this->assertCount(1, $style_properties);
        $style_property = $style_properties[0];
        $this->assertIsObject($style_property);
        $this->assertEquals("<style:text-properties  fo:font-size=\"11.00pt\" fo:background-color=\"transparent\" fo:font-family=\"Arial\" style:use-window-font-color=\"true\" ></style:text-properties>", implode("", iterator_to_array($style_property->create(), false)));
    }
}

?>