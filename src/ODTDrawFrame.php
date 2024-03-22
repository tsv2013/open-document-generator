<?php

namespace OpenOfficeGenerator;

class ODTDrawFrame extends OOElement {
  private static $next_unique_id = 1;
  private $unique_id;
  private $image;
  function __construct($image) {
    parent::__construct("draw", "frame");
    $this->unique_id = ODTDrawFrame::$next_unique_id++;

    $this->image = $image;
    $this->style_name = "DrawFrame$this->unique_id";
    $this->create_style($this->style_name, "graphic", "Graphics");

    $this->attributes = "draw:style-name=\"$this->style_name\" draw:name=\"graphics$this->unique_id\" text:anchor-type=\"paragraph\" draw:z-index=\"0\""; // svg:width=\"9.999cm\" svg:height=\"3.755cm\"
  }
  public function get_content() {
    yield "<draw:image xlink:href=\"$this->image\" xlink:type=\"simple\" xlink:show=\"embed\" xlink:actuate=\"onLoad\" />";
  }
}
