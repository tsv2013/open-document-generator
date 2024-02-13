<?php

namespace OpenOfficeGenerator;

class ODTElement {
  protected $namespase = "";
  protected $name = "";
  protected $attributes = "";
  public $style_name;
  public $styles = [];
  protected $content = [];
  function __construct($namespase, $name, $style_name = null) {
    $this->namespase = $namespase;
    $this->name = $name;
    $this->style_name = $style_name;
  }
  protected function get_content() {
    foreach ($this->content as $content_item) {
      yield from $content_item->create();
    }
  }
  protected function update_attributes() {
  }
  public function create() {
    $this->update_attributes();
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
  public $text = "";
  function __construct($style_name, $text) {
    parent::__construct("text", "p", $style_name);
    $this->text = $text;
    $this->attributes = "text:style-name=\"$style_name\"";
  }
  protected function get_content() {
    yield $this->text;
    // yield "<text:span text:style-name=\"$this->style_name\">$this->text</text:span>";
  }
}
