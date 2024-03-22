<?php

namespace OpenDocumentGenerator;

class ODSDocument extends ODDocument {
  function __construct() {
    parent::__construct();
    $this->mimetype = "application/vnd.oasis.opendocument.spreadsheet";
    $this->manifest->add_file_entry($this->mimetype, "/");
  }
  public function get_head() {
    yield from parent::get_head(false);
    yield "<office:spreadsheet>";
  }
  public function get_tail() {
    yield "</office:spreadsheet>";
    yield from parent::get_tail();
  }
  public function add_sheet() {
    $sheet = new ODTable();
    $this->add($sheet);
    return $sheet;
  }
}
