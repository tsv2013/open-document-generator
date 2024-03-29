[![PHP Composer](https://github.com/tsv2013/open-office-generator/actions/workflows/php.yml/badge.svg)](https://github.com/tsv2013/open-office-generator/actions/workflows/php.yml)

## Open Document Generator library
  Allows to create and store an ODT file. Supports:
  - headers
  - paragraphs
  - tables
  - tables of content
  - styles: text, paragraph, table cell, table column

  Requirements:
  - zip library enabled in php.ini file
```
extension=zip
```  

## Sample usage
  
  ODT file minimal creation code:

  ```PHP
  $fileName = dirname(__FILE__) . "/document1.odt";
  $docFile = new ODFile($fileName);
  $document = $docFile->document;
  $document->add_heading("Test heading");
  $document->add_para("Lorem ipsum");

  $docFile->create();
  ```

  ODS file minimal creation code:

  ```PHP
  $fileName = dirname(__FILE__) . "/document1.ods";
  $docFile = new ODFile($fileName);
  $document = $docFile->document;

  $table = new ODTable([10, 7]);
  $document->add($table);

  $row = $table->create_row();
  $row->add_cell_with_text("Column 1");
  $row->add_cell_with_text("Column 2");
  $row = $table->create_row();
  $row->add_cell_with_text("val 1");
  $row->add_cell_with_text("val 2");

  $docFile->create();
  ```


## See also
  https://docs.oasis-open.org/office/v1.2/os/OpenDocument-v1.2-os-part1.html

  https://getcomposer.org/doc/articles/scripts.md

  https://www.php.net/manual/en/function.xml-parse.php

  https://www.php.net/manual/en/function.xml-parse-into-struct.php
