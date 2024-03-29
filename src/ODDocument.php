<?php

namespace OpenDocumentGenerator;

class ODDocument extends ODElement {
  public ODManifest $manifest;
  public $mimetype = "application/vnd.oasis.opendocument";
  function __construct() {
    parent::__construct("office", "document-content");
    $this->attributes = "xmlns:office=\"urn:oasis:names:tc:opendocument:xmlns:office:1.0\"
                          xmlns:style=\"urn:oasis:names:tc:opendocument:xmlns:style:1.0\"
                          xmlns:text=\"urn:oasis:names:tc:opendocument:xmlns:text:1.0\"
                          xmlns:table=\"urn:oasis:names:tc:opendocument:xmlns:table:1.0\"
                          xmlns:draw=\"urn:oasis:names:tc:opendocument:xmlns:drawing:1.0\"
                          xmlns:fo=\"urn:oasis:names:tc:opendocument:xmlns:xsl-fo-compatible:1.0\"
                          xmlns:xlink=\"http://www.w3.org/1999/xlink\"
                          xmlns:dc=\"http://purl.org/dc/elements/1.1/\"
                          xmlns:meta=\"urn:oasis:names:tc:opendocument:xmlns:meta:1.0\"
                          xmlns:number=\"urn:oasis:names:tc:opendocument:xmlns:datastyle:1.0\"
                          xmlns:svg=\"urn:oasis:names:tc:opendocument:xmlns:svg-compatible:1.0\"
                          xmlns:chart=\"urn:oasis:names:tc:opendocument:xmlns:chart:1.0\"
                          xmlns:dr3d=\"urn:oasis:names:tc:opendocument:xmlns:dr3d:1.0\"
                          xmlns:math=\"http://www.w3.org/1998/Math/MathML\"
                          xmlns:form=\"urn:oasis:names:tc:opendocument:xmlns:form:1.0\"
                          xmlns:script=\"urn:oasis:names:tc:opendocument:xmlns:script:1.0\"
                          xmlns:ooo=\"http://openoffice.org/2004/office\"
                          xmlns:ooow=\"http://openoffice.org/2004/writer\"
                          xmlns:oooc=\"http://openoffice.org/2004/calc\"
                          xmlns:dom=\"http://www.w3.org/2001/xml-events\"
                          xmlns:xforms=\"http://www.w3.org/2002/xforms\"
                          xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"
                          xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
                          xmlns:rpt=\"http://openoffice.org/2005/report\"
                          xmlns:of=\"urn:oasis:names:tc:opendocument:xmlns:of:1.2\"
                          xmlns:xhtml=\"http://www.w3.org/1999/xhtml\"
                          xmlns:grddl=\"http://www.w3.org/2003/g/data-view#\"
                          xmlns:tableooo=\"http://openoffice.org/2009/table\"
                          xmlns:textooo=\"http://openoffice.org/2013/office\"
                          xmlns:field=\"urn:openoffice:names:experimental:ooo-ms-interop:xmlns:field:1.0\" office:version=\"1.2\"";
    $this->manifest = new ODManifest();
    $this->create_style("TableCell", "table-cell");
  }
  public function get_head() {
    yield "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
    yield from parent::get_head(false);
    yield "<office:font-face-decls>
              <style:font-face style:name=\"Arial2\" svg:font-family=\"Arial\" style:font-family-generic=\"swiss\"/>
              <style:font-face style:name=\"Times New Roman\" svg:font-family=\"&apos;Times New Roman&apos;\" style:font-family-generic=\"roman\" style:font-pitch=\"variable\"/>
              <style:font-face style:name=\"Arial\" svg:font-family=\"Arial\" style:font-family-generic=\"swiss\" style:font-pitch=\"variable\"/>
              <style:font-face style:name=\"Arial1\" svg:font-family=\"Arial\" style:font-family-generic=\"system\" style:font-pitch=\"variable\"/>
              <style:font-face style:name=\"Microsoft YaHei\" svg:font-family=\"&apos;Microsoft YaHei&apos;\" style:font-family-generic=\"system\" style:font-pitch=\"variable\"/>
              <style:font-face style:name=\"SimSun\" svg:font-family=\"SimSun\" style:font-family-generic=\"system\" style:font-pitch=\"variable\"/>
            </office:font-face-decls>";
    yield "<office:automatic-styles>";
    foreach ($this->styles as $style_item) {
      yield from $style_item->create();
    }
    yield "</office:automatic-styles><office:body>";
  }
  public function get_tail() {
    yield "</office:body>";
    yield from parent::get_tail();
  }
}
