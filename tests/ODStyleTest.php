<?php

namespace  OpenDocumentGenerator;

use PHPUnit\Framework\TestCase;

class ODStyleTest extends TestCase {
    public function testConstructor() {
        $style = new ODStyle("Custom");
        $this->assertStringEqualsStringIgnoringLineEndings("<style:style style:name=\"Custom\" style:family=\"text\" style:parent-style-name=\"Standard\" >
<style:text-properties  fo:font-size=\"11.00pt\" fo:background-color=\"transparent\" fo:font-family=\"Arial\" style:use-window-font-color=\"true\" />
</style:style>", $style->get_xml());
        $property = new \ReflectionProperty("OpenDocumentGenerator\ODStyle", "content");
        $property->setAccessible(true);
        $style_properties = $property->getValue($style);
        $this->assertIsList($style_properties);
        $this->assertCount(1, $style_properties);
        $style_property = $style_properties[0];
        $this->assertIsObject($style_property);
        $this->assertStringEqualsStringIgnoringLineEndings("<style:text-properties  fo:font-size=\"11.00pt\" fo:background-color=\"transparent\" fo:font-family=\"Arial\" style:use-window-font-color=\"true\" />", $style_property->get_xml());
    }
    public function testParseXml() {
        $this->markTestSkipped('must be revisited');
        $style = new ODStyle("Custom");
        $style->parse_xml("<style:style style:name=\"Custom\" style:family=\"text\" style:parent-style-name=\"Standard\" >
        <style:text-properties  fo:font-size=\"11.00pt\" fo:background-color=\"transparent\" fo:font-family=\"Arial\" style:use-window-font-color=\"true\" />
        </style:style>");
        $this->assertStringEqualsStringIgnoringLineEndings("<style:style style:name=\"Custom\" style:family=\"text\" style:parent-style-name=\"Standard\" >
<style:text-properties  fo:font-size=\"11.00pt\" fo:background-color=\"transparent\" fo:font-family=\"Arial\" style:use-window-font-color=\"true\" />
</style:style>", $style->get_xml());
    }
}

?>