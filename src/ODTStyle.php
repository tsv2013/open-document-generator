<?php

class ODTStyle extends ODTElement {
  private $style_name;
  private $style_family;
  public $properties;
  function __construct($style_name, $parent_style = "Standard", $style_family = "text") {
    parent::__construct("style", "style");
    $this->style_name = $style_name;
    $this->style_family = $style_family;
    $this->attributes = "style:name=\"$style_name\" style:family=\"$style_family\" style:parent-style-name=\"$parent_style\"";
    $this->properties = "<style:text-properties fo:font-size=\"11.00pt\" fo:font-weight=\"bold\" fo:font-family=\"Arial\" style:font-family-asian=\"Arial\" style:font-family-complex=\"Arial\" fo:background-color=\"transparent\" style:use-window-font-color=\"true\" />";
  }
  protected function get_content() {
    yield $this->properties;
  }
}
