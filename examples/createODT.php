<?php

namespace OpenOfficeGenerator;

require dirname(__DIR__) . '/vendor/autoload.php';

$fileName = dirname(__FILE__) . "/../temp/document1.odt";
if(file_exists($fileName)) {
    unlink($fileName);
}
$docFile = new ODTFile($fileName);
$document = $docFile->document;
$document->add_heading("Test heading");
$document->add_para("Lorem ipsum");

$table = new ODTTable([10, 7]);
$document->add($table);

$row = $table->create_header_row();
$row->add_cell_with_text("Column 1");
$row->add_cell_with_text("Column 2");
$row = $table->create_row();
$row->add_cell_with_text("val 1");
$row->add_cell_with_text("val 2");

$docFile->create();
?>