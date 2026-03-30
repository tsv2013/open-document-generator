<?php

namespace OpenDocumentGenerator;

class ODProperties extends ODElement {
  function __construct($namespase, $name) {
    parent::__construct($namespase, $name);
    $this->self_closing = true;
    $this->attributes = [];
  }
}

class ODStyleTextProperties extends ODProperties {
  function __construct() {
    parent::__construct("style", "text-properties");
    $this->attributes["fo:font-size"] = "11.00pt";
    $this->attributes["fo:color"] = null;
    $this->attributes["fo:background-color"] = "transparent";
    $this->attributes["fo:font-family"] = "Arial";
    $this->attributes["fo:font-weight"] = null; // normal, bold, 100, 200, 300, 400, 500, 600, 700, 800 or 900
    $this->attributes["fo:font-style"] = null; // normal, italic or oblique
    // $this->attributes["style:font-family-asian"] = "Arial";
    // $this->attributes["fo:font-weight-asian"] = "bold";
    // $this->attributes["style:font-family-complex"] = "Arial";
    // $this->attributes["fo:font-weight-complex"] = "bold";
    $this->attributes["style:use-window-font-color"] = "true";
    $this->attributes["style:text-position"] = null; // sub or super
  }
}

class ODStyleParagraphProperties extends ODProperties {
  function __construct() {
    parent::__construct("style", "paragraph-properties");
    $this->attributes["fo:text-align"] = "left"; // start, end, left, right, center or justify
    $this->attributes["fo:text-indent"] = "0cm";
    $this->attributes["style:justify-single-word"] = "false";
    $this->attributes["fo:keep-with-next"] = null; // auto or always
    $this->attributes["fo:break-before"] = null; // auto, column or page
    $this->attributes["fo:break-after"] = null; // auto, column or page
  }
}

class ODStyleCellProperties extends ODProperties {
  function __construct() {
    parent::__construct("style", "table-cell-properties");
    $this->attributes["fo:padding"] = "0.1cm";
    $this->attributes["fo:border-left"] = "none";
    $this->attributes["fo:border-right"] = "none";
    $this->attributes["fo:border-top"] = "none";
    $this->attributes["fo:border-bottom"] = "none";
  }
}

class ODStyleColumnProperties extends ODProperties {
  function __construct() {
    parent::__construct("style", "table-column-properties");
    $this->attributes["style:column-width"] = "17cm";
    $this->attributes["style:rel-column-width"] = "16383*";
  }
  public function set_width($width) {
    $this->attributes["style:column-width"] = $width."cm";
    $percent =  round(566 * $width);
    $this->attributes["style:rel-column-width"] = $percent."*";
  }
}

class ODStyleGraphicProperties extends ODProperties {
  function __construct() {
    parent::__construct("style", "graphic-properties");
    $this->attributes["style:horizontal-pos"] = "center";
    $this->attributes["style:horizontal-rel"] = "paragraph";
    $this->attributes["style:mirror"] = "none";
    $this->attributes["fo:clip"] = "rect(0cm, 0cm, 0cm, 0cm)";
    $this->attributes["draw:luminance"] = "0%";
    $this->attributes["draw:contrast"] = "0%";
    $this->attributes["draw:red"] = "0%";
    $this->attributes["draw:green"] = "0%";
    $this->attributes["draw:blue"] = "0%";
    $this->attributes["draw:gamma"] = "100%";
    $this->attributes["draw:color-inversion"] = "false";
    $this->attributes["draw:image-opacity"] = "100%";
    $this->attributes["draw:color-mode"] = "standard";
  }
}

class ODStyle extends ODElement {
  private $style_family;
  public $properties;
  function __construct($style_name, $style_family = "text", $parent_style = "Standard") {
    parent::__construct("style", "style", $style_name);
    $this->style_family = $style_family;
    $this->attributes = "style:name=\"$style_name\" style:family=\"$style_family\" style:parent-style-name=\"$parent_style\"";
    switch ($style_family) {
      case "paragraph":
        $this->add(new ODStyleParagraphProperties());
      case "text":
        $this->add(new ODStyleTextProperties());
        break;
      case "table-cell":
        $this->add(new ODStyleCellProperties());
        break;
      case "table-column":
        $this->add(new ODStyleColumnProperties());
        break;
      case "graphic": // style:parent-style-name="Graphics"
        $this->add(new ODStyleGraphicProperties());
        break;
      }
  }
  public function get_content() {
    if(isset($this->properties) && strlen($this->properties) > 0) {
      yield $this->properties;
    } else {
      yield from parent::get_content();
    }
  }
  public function get_style_properties($style_family = null) {
    if(!isset($style_family)) {
      $style_family = $this->style_family;
    }
    $properties_name = $style_family . "-properties";
    foreach ($this->content as $content_item) {
      if($content_item->name == $properties_name) {
        return $content_item;
      }
    }
    return $this->content[0];
  }
}
