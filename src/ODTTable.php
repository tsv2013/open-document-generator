<?php

class ODTTable extends ODTElement {
  protected $header_rows = [];
  public $style_name;
  public $column_style_name;
  public $col_count;
  function __construct($style_name = "Table", $column_style_name = "TableColumn", $col_count = 1) {
    parent::__construct("table", "table");
    $this->style_name = $style_name;
    $this->column_style_name = $column_style_name;
    $this->col_count = $col_count;
    $this->attributes = "table:style-name=\"$style_name\"";
  }
  function create_header_row() {
    $row = new ODTTableRow();
    array_push($this->header_rows, $row);
    return $row;
  }
  function create_row() {
    $row = new ODTTableRow();
    array_push($this->content, $row);
    return $row;
  }
  protected function get_content() {
    yield "<table:table-column table:style-name=\"$this->column_style_name\" table:number-columns-repeated=\"$this->col_count\"/>";
    if(count($this->header_rows) > 0) {
      yield "<table:table-header-rows>";
      foreach ($this->header_rows as $header_row) {
        yield from $header_row->create();
      }
      yield "</table:table-header-rows>";
    }
    yield from parent::get_content();
  }
}

class ODTTableRow extends ODTElement {
  function __construct() {
    parent::__construct("table", "table-row");
    $this->attributes = "";
  }
  function create_cell($cell_style, $col_span = null) {
    $cell = new ODTTableCell($cell_style, $col_span);
    array_push($this->content, $cell);
    return $cell;
  }
  function add_cell_with_text($text, $cell_style = "TableCell", $style = "Standard", $col_span = null) {
    $cell = $this->create_cell($cell_style, $col_span);
    $para = new ODTPara($style, $text);
    array_push($cell->content, $para);
  }
}

class ODTTableCell extends ODTElement {
  public $style_name;
  function __construct($style_name = "TableCell", $col_span = null) {
    parent::__construct("table", "table-cell");
    $this->style_name = $style_name;
    $this->attributes = "table:style-name=\"$style_name\"";
    if(isset($col_span)) {
      $this->attributes = "table:number-columns-spanned=\"$col_span\" " . $this->attributes;
    }
  }
}
