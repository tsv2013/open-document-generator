<?php

namespace OpenOfficeGenerator;

class ODTElement {
  protected $namespase = "";
  protected $name = "";
  protected $attributes = "";
  protected $self_closing = false;
  public $style_name;
  public $styles = [];
  protected $content = [];
  function __construct($namespase, $name, $style_name = null) {
    $this->namespase = $namespase;
    $this->name = $name;
    $this->style_name = $style_name;
  }
  public function get_content() {
    foreach ($this->content as $content_item) {
      yield from $content_item->create();
    }
  }
  protected function update_attributes() {
  }
  public function get_head() {
    $closing_content = $this->self_closing ? "/" : "";
    yield "<{$this->namespase}:{$this->name} {$this->attributes} {$closing_content}>";
  }
  public function get_tail() {
    yield "</{$this->namespase}:{$this->name}>";
  }
  public function create() {
    $this->update_attributes();
    if(!$this->self_closing) {
      yield from $this->get_head();
      yield from $this->get_content();
      yield from $this->get_tail();
    } else {
      yield from $this->get_head(true);
    }
  }
  public function create_style($style_name, $style_family = "text", $parent_style = "Standard", $properties = "") {
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
  public function write($file_handle) {
    foreach ($this->create() as $doc_str)  {
      fwrite($file_handle, $doc_str);
    }
  }
}


