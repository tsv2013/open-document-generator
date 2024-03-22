<?php

namespace OpenDocumentGenerator;

class ODTDrawFrame extends ODElement {
  private static $next_unique_id = 1;
  private $unique_id;
  private $image;
  function __construct($image) {
    parent::__construct("draw", "frame");
    $this->unique_id = ODTDrawFrame::$next_unique_id++;

    $this->image = $image;
    $this->style_name = "DrawFrame$this->unique_id";
    $this->create_style($this->style_name, "graphic", "Graphics");

    $this->attributes = "draw:style-name=\"$this->style_name\" draw:name=\"graphics$this->unique_id\" text:anchor-type=\"paragraph\" svg:width=\"9.0cm\" svg:height=\"6.0cm\" draw:z-index=\"0\"";
  }
  public function get_content() {
    yield "<draw:image xlink:href=\"$this->image\" xlink:type=\"simple\" xlink:show=\"embed\" xlink:actuate=\"onLoad\" />";
  }
}
