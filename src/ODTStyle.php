<?php

namespace OpenOfficeGenerator;

class ODTProperties extends ODTElement {
  public $properties = [];
  function __construct($namespase, $name) {
    parent::__construct($namespase, $name);
  }
  protected function update_attributes() {
    $this->attributes = "";
    foreach ($this->properties as $name => $value) {
      if(isset($value)) {
        $this->attributes = $this->attributes . " $name=\"$value\"";
      }
    }
  }
}
class ODTStyleTextProperties extends ODTProperties {
  function __construct() {
    parent::__construct("style", "text-properties");
    $this->properties["fo:font-size"] = "11.00pt";
    $this->properties["fo:color"] = null;
    $this->properties["fo:background-color"] = "transparent";
    $this->properties["fo:font-family"] = "Arial";
    $this->properties["fo:font-weight"] = null; // normal, bold, 100, 200, 300, 400, 500, 600, 700, 800 or 900
    $this->properties["fo:font-style"] = null; // normal, italic or oblique
    // $this->properties["style:font-family-asian"] = "Arial";
    // $this->properties["fo:font-weight-asian"] = "bold";
    // $this->properties["style:font-family-complex"] = "Arial";
    // $this->properties["fo:font-weight-complex"] = "bold";
    $this->properties["style:use-window-font-color"] = "true";
    $this->properties["style:text-position"] = null; // sub or super
  }
}
class ODTStyleParagraphProperties extends ODTProperties {
  function __construct() {
    parent::__construct("style", "paragraph-properties");
    $this->properties["fo:text-align"] = "left"; // start, end, left, right, center or justify
    $this->properties["fo:text-indent"] = "0cm";
    $this->properties["style:justify-single-word"] = "false";
  }
}
class ODTStyleCellProperties extends ODTProperties {
  function __construct() {
    parent::__construct("style", "table-cell-properties");
    $this->properties["fo:padding"] = "0.1cm";
    $this->properties["fo:border-left"] = "none";
    $this->properties["fo:border-right"] = "none";
    $this->properties["fo:border-top"] = "none";
    $this->properties["fo:border-bottom"] = "0.002cm solid #000000";
  }
}
class ODTStyle extends ODTElement {
  private $style_family;
  public $properties;
  function __construct($style_name, $parent_style = "Standard", $style_family = "text") {
    parent::__construct("style", "style", $style_name);
    $this->style_family = $style_family;
    $this->attributes = "style:name=\"$style_name\" style:family=\"$style_family\" style:parent-style-name=\"$parent_style\"";
    // $this->properties = "<style:text-properties fo:font-size=\"11.00pt\" fo:font-weight=\"bold\" fo:font-family=\"Arial\" style:font-family-asian=\"Arial\" style:font-family-complex=\"Arial\" fo:background-color=\"transparent\" style:use-window-font-color=\"true\" />";
  }
  protected function get_content() {
    if(isset($this->properties) && strlen($this->properties) > 0) {
      yield $this->properties;
    } else {
      yield from parent::get_content();
    }
  }
}
