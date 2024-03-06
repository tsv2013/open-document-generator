<?php

namespace  OpenOfficeGenerator;

use PHPUnit\Framework\TestCase;

class ODTStyleTest extends TestCase {
    public function testConstructor() {
        $style = new ODTStyle("Custom");
        $this->assertStringEqualsStringIgnoringLineEndings("<style:style style:name=\"Custom\" style:family=\"text\" style:parent-style-name=\"Standard\" >
<style:text-properties  fo:font-size=\"11.00pt\" fo:background-color=\"transparent\" fo:font-family=\"Arial\" style:use-window-font-color=\"true\" >
</style:text-properties>
</style:style>", $style->get_xml());
        $property = new \ReflectionProperty("OpenOfficeGenerator\ODTStyle", "content");
        $property->setAccessible(true);
        $style_properties = $property->getValue($style);
        $this->assertIsList($style_properties);
        $this->assertCount(1, $style_properties);
        $style_property = $style_properties[0];
        $this->assertIsObject($style_property);
        $this->assertStringEqualsStringIgnoringLineEndings("<style:text-properties  fo:font-size=\"11.00pt\" fo:background-color=\"transparent\" fo:font-family=\"Arial\" style:use-window-font-color=\"true\" >
</style:text-properties>", $style_property->get_xml());
    }
    public function testParseXml() {
        $this->markTestSkipped('must be revisited');
        $style = new ODTStyle("Custom");
        $style->parse_xml("<style:style style:name=\"Custom\" style:family=\"text\" style:parent-style-name=\"Standard\" >
        <style:text-properties  fo:font-size=\"11.00pt\" fo:background-color=\"transparent\" fo:font-family=\"Arial\" style:use-window-font-color=\"true\" >
        </style:text-properties>
        </style:style>");
        $this->assertStringEqualsStringIgnoringLineEndings("<style:style style:name=\"Custom\" style:family=\"text\" style:parent-style-name=\"Standard\" >
<style:text-properties  fo:font-size=\"11.00pt\" fo:background-color=\"transparent\" fo:font-family=\"Arial\" style:use-window-font-color=\"true\" >
</style:text-properties>
</style:style>", $style->get_xml());
    }
}

?>