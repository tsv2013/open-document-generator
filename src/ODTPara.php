<?php

namespace OpenOfficeGenerator;

class ODTPara extends ODTElement {
  public $text = "";
  function __construct($text, $style_name = "Standard") {
    parent::__construct("text", "p", $style_name);
    $this->text = $text;
    $this->attributes = "text:style-name=\"$style_name\"";
  }
  public function get_content() {
    yield $this->text;
    // yield "<text:span text:style-name=\"$this->style_name\">$this->text</text:span>";
  }
}

// class ODTSoftPageBreak extends ODTElement {
//   function __construct() {
//     parent::__construct("text", "soft-page-break");
//     $this->self_closing = true;
//   }
// }

