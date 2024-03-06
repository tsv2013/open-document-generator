<?php

namespace OpenOfficeGenerator;

class ODTTable extends ODTElement {
  private static $next_unique_id = 1;
  private $unique_id;
  public $columns = [];
  public $header_rows = [];
  public $col_count;
  function __construct($column_defs = 1) {
    parent::__construct("table", "table");
    $this->unique_id = ODTTable::$next_unique_id++;

    $this->style_name = "Table$this->unique_id";
    $table_width = 17;
    $this->create_style($this->style_name, "table", "Standard", "<style:table-properties style:width=\"".$table_width."cm\" table:align=\"margins\"/>");
    $column_style_name = $this->style_name . "Column";

    $this->col_count = is_array($column_defs) ? count($column_defs) : $column_defs;
    for ($i = 0; $i < $this->col_count; $i++) {
      $column_style = $this->create_style($column_style_name.$i, "table-column");
      $column = new ODTTableColumn($column_style);
      $column_width = is_array($column_defs) ? $column_defs[$i] : round($table_width / $column_defs, 3);
      $column_style->get_style_properties()->set_width($column_width);
      array_push($this->columns, $column);
    }

    $this->attributes = "table:name=\"Sheet$this->unique_id\" table:style-name=\"$this->style_name\"";
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
  public function get_content() {
    foreach ($this->columns as $column) {
      yield from $column->create();
    }
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

class ODTTableColumn extends ODTElement {
  public $column_style;
  function __construct($column_style, $column_repeated = 1) {
    $this->column_style = $column_style;
    parent::__construct("table", "table-column", $column_style->style_name);
    $this->attributes = "table:style-name=\"$column_style->style_name\" table:number-columns-repeated=\"$column_repeated\"";
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
  function add_cell_with_text($text, $cell_style = "TableCell", $text_style = "Standard", $col_span = null) {
    $cell = $this->create_cell($cell_style, $col_span);
    $para = new ODTPara($text, $text_style);
    array_push($cell->content, $para);
  }
}

class ODTTableCell extends ODTElement {
  function __construct($style_name = "TableCell", $col_span = null) {
    parent::__construct("table", "table-cell", $style_name);
    $this->attributes = "table:style-name=\"$style_name\"";
    if(isset($col_span)) {
      $this->attributes = "table:number-columns-spanned=\"$col_span\" " . $this->attributes;
    }
  }
}
