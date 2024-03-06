<?php

namespace OpenOfficeGenerator;

class ODTDocument extends OODocument {
  function __construct() {
    parent::__construct();
  }
  public function get_head() {
    yield from parent::get_head(false);
    yield "<office:text text:use-soft-page-breaks=\"true\">";
  }
  public function get_tail() {
    yield "</office:text>";
    yield from parent::get_tail();
  }
  public function add_para($text, $style_name = "Standard") {
    $para = new ODTPara($text, $style_name);
    $this->add($para);
    return $para;
  }
  public function add_heading($text, $level = 1) {
    return $this->add_para($text, "Heading $level");
  }
  public function add_from_file($file_name, $style_name = "ParaText") {
    $lines = file($file_name, FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
      $this->add_para($line, $style_name);
    }
  }
}
