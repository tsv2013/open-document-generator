<?php

namespace OpenOfficeGenerator;

class ODTElement {
  protected $namespase = "";
  protected $name = "";
  public $attributes = "";
  public $styles = [];
  protected $content = [];
  function __construct($namespase, $name) {
    $this->namespase = $namespase;
    $this->name = $name;
  }
  protected function get_content() {
    foreach ($this->content as $content_item) {
      yield from $content_item->create();
    }
  }
  public function create() {
    yield "<{$this->namespase}:{$this->name} {$this->attributes}>";
    yield from $this->get_content();
    yield "</{$this->namespase}:{$this->name}>";
  }
  public function create_style($style_name, $parent_style = "Standard", $style_family = "text", $properties = "") {
    $style = new ODTStyle($style_name, $parent_style, $style_family);
    if(strlen($properties) > 0) {
      $style->properties = $properties;
    }
    array_push($this->styles, $style);
    return $style;
  }
  public function add($element) {
    array_push($this->styles, ...$element->styles);
    array_push($this->content, $element);
  }
}

class ODTPara extends ODTElement {
  public $style_name;
  public $text = "";
  function __construct($style_name, $text) {
    parent::__construct("text", "p");
    $this->style_name = $style_name;
    $this->text = $text;
    $this->attributes = "text:style-name=\"$style_name\"";
  }
  protected function get_content() {
    yield "<text:span text:style-name=\"$this->style_name\">$this->text</text:span>";
  }
}
