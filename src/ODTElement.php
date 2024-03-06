<?php

namespace OpenOfficeGenerator;

class ODTElement {
  protected $namespace = "";
  protected $name = "";
  protected $attributes = "";
  protected $value;
  protected $self_closing = false;
  public $style_name;
  public $styles = [];
  protected $content = [];
  function __construct($namespace, $name, $style_name = null) {
    $this->namespace = $namespace;
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
  protected function build_attributes() {
    $this->update_attributes();
    if(is_string($this->attributes)) {
      return $this->attributes;
    }
    if(is_array($this->attributes)) {
      $attrs = "";
      foreach ($this->attributes as $name => $value) {
        if(isset($value)) {
          $attrs = $attrs . " $name=\"$value\"";
        }
      }
      return $attrs;
    }
    return "";
  }
  public function get_head() {
    $closing_content = $this->self_closing ? "/" : "";
    yield "<{$this->namespace}:{$this->name} {$this->build_attributes()} {$closing_content}>";
  }
  public function get_tail() {
    yield "</{$this->namespace}:{$this->name}>";
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
  public function get_xml() {
    return implode("\n", iterator_to_array($this->create(), false));
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
  public function parse_xml($xml_string) {
    $tags = [];
    $parser = xml_parser_create();
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, $xml_string, $tags);
    xml_parser_free($parser);
  
    $elements = array();
    $stack = array();
    foreach ($tags as $tag) {
      $index = count($elements);
      if ($tag['type'] == "complete" || $tag['type'] == "open") {
        $elements[$index] = $index == 0 ? $this : new ODTElement;
        $tag_pieces = explode(":", $tag['tag']);
        $elements[$index]->namespace = $tag_pieces[0];
        $elements[$index]->name = $tag_pieces[1];
        $elements[$index]->attributes = $tag['attributes'];
        $elements[$index]->value = $tag['value'];
        $elements[$index]->self_closing = $tag['type'] == "complete";
        if ($tag['type'] == "open") {
          $elements[$index]->content = array();
          $stack[count($stack)] = &$elements;
          $elements = &$elements[$index]->content;
        }
      }
      if ($tag['type'] == "close") {
        $elements = &$stack[count($stack) - 1];
        unset($stack[count($stack) - 1]);
      }
    }
  }
}


