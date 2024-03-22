<?php

namespace OpenDocumentGenerator;

function get_uuid_file_name($extension = "") {
  mt_srand((double)microtime()*10000);
  $charid = strtoupper(md5(uniqid(rand(), true)));
  $uuid = ""
      .substr($charid, 0, 8)
      .substr($charid, 8, 4)
      .substr($charid,12, 4)
      .substr($charid,16, 4)
      .substr($charid,20,12);
  if(!empty($extension)) {
    $uuid = $uuid . "." . $extension;
  }
  return $uuid;
}

class ODTDocument extends ODDocument {
  public $pictures = [];
  function __construct() {
    parent::__construct();
    $this->mimetype = "application/vnd.oasis.opendocument.text";
    $this->manifest->add_file_entry($this->mimetype, "/");
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
  public function add_image($image_path) {
    if (!file_exists($image_path)) {
      return null;
    }
    $para = new ODTPara("");
    $path_info = pathinfo($image_path);
    $extension = $path_info['extension'];
    $unique_name = get_uuid_file_name($extension);
    $image_file_entry = "Pictures/" . $unique_name;
    $image = new ODTDrawFrame($image_file_entry);
    $para->add($image);
    $this->add($para);
    $this->pictures[$unique_name] = $image_path;
    $this->manifest->add_file_entry("image/$extension", $image_file_entry);
    return $image;
  }
  public function add_from_file($file_name, $style_name = "ParaText") {
    $lines = file($file_name, FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
      $this->add_para($line, $style_name);
    }
  }
}
