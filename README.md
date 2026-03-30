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


## Development Roadmap

### Current Implementation Status
✅ **Implemented Features:**
- Basic ODT and ODS document creation
- Headers and paragraphs
- Tables with basic formatting
- Table of contents
- Images and graphics
- Basic text and paragraph styles
- Table cell and column styles
- Document manifest and file structure

### Priority 1: Essential Text Document Features (ODT)

#### 1.1 Advanced Text Formatting
- [ ] **Rich text formatting within paragraphs**
  - Bold, italic, underline text spans
  - Font size, color, and family changes
  - Superscript and subscript
  - Strikethrough and highlighting
- [ ] **Lists support**
  - Numbered lists (ordered)
  - Bulleted lists (unordered)
  - Nested list levels
  - Custom list styles
- [ ] **Text alignment and spacing**
  - Justified text alignment
  - Line spacing control
  - Paragraph spacing (before/after)
  - Indentation controls

#### 1.2 Document Structure
- [ ] **Page breaks and section breaks**
  - Manual page breaks
  - Section breaks with different formatting
  - Column layouts
- [ ] **Headers and footers**
  - Page headers and footers
  - Different headers for first/odd/even pages
  - Dynamic content (page numbers, dates)
- [ ] **Hyperlinks and bookmarks**
  - Internal document links
  - External web links
  - Named anchors/bookmarks
- [ ] **Fields and references**
  - Page number fields
  - Date/time fields
  - Cross-references
  - Table of figures/tables

#### 1.3 Advanced Table Features
- [ ] **Table formatting**
  - Borders and grid lines
  - Cell background colors
  - Cell merging (rowspan/colspan)
  - Table positioning and wrapping
- [ ] **Table styles**
  - Predefined table styles
  - Alternating row colors
  - Header row formatting

### Priority 2: Essential Spreadsheet Features (ODS)

#### 2.1 Cell Content and Formulas
- [ ] **Formula support**
  - Basic arithmetic operations (+, -, *, /)
  - Common functions (SUM, AVERAGE, COUNT, etc.)
  - Cell references (A1, $A$1, etc.)
  - Range references (A1:B10)
- [ ] **Data types**
  - Number formatting (currency, percentage, decimal places)
  - Date and time formatting
  - Text formatting
  - Boolean values
- [ ] **Cell content**
  - Rich text within cells
  - Multi-line text
  - Text wrapping

#### 2.2 Spreadsheet Structure
- [ ] **Multiple worksheets**
  - Sheet creation and naming
  - Sheet navigation
  - Sheet protection
- [ ] **Row and column operations**
  - Auto-sizing columns/rows
  - Row/column insertion/deletion
  - Row/column hiding/showing
- [ ] **Cell operations**
  - Cell merging
  - Cell protection
  - Data validation rules

#### 2.3 Charts and Visualization
- [ ] **Basic chart types**
  - Column/bar charts
  - Line charts
  - Pie charts
  - Scatter plots
- [ ] **Chart formatting**
  - Titles and labels
  - Legend positioning
  - Color schemes
  - Data series formatting

### Priority 3: Document Metadata and Properties

#### 3.1 Document Information
- [ ] **Standard metadata**
  - Title, subject, keywords
  - Author and creator information
  - Creation and modification dates
  - Document description
- [ ] **Custom properties**
  - User-defined metadata fields
  - Property categories

### Priority 4: Advanced Features

#### 4.1 Document Collaboration
- [ ] **Change tracking**
  - Track changes mode
  - Comments and annotations
  - Review and approval workflow
- [ ] **Document protection**
  - Password protection
  - Read-only mode
  - Editing restrictions

#### 4.2 Advanced Formatting
- [ ] **Styles and themes**
  - Style inheritance
  - Custom style creation
  - Style templates
  - Document themes
- [ ] **Advanced graphics**
  - Shapes and drawing objects
  - Text boxes
  - Grouping and layering
  - Rotation and scaling

#### 4.3 Data Integration
- [ ] **External data**
  - Database connections
  - CSV import/export
  - XML data binding
- [ ] **Pivot tables (ODS)**
  - Data summarization
  - Dynamic filtering
  - Calculated fields

### Priority 5: Performance and Quality

#### 5.1 Performance Optimization
- [ ] **Memory management**
  - Large document handling
  - Streaming for big files
  - Memory usage optimization
- [ ] **File size optimization**
  - Compression improvements
  - Duplicate resource handling

#### 5.2 Error Handling and Validation
- [ ] **Input validation**
  - Data type validation
  - Range checking
  - Format validation
- [ ] **Error reporting**
  - Detailed error messages
  - Validation warnings
  - Debug information

### Implementation Notes

- **Phase 1** (Priority 1-2): Focus on core functionality that most users need
- **Phase 2** (Priority 3): Add professional document features
- **Phase 3** (Priority 4-5): Advanced features and optimization

Each feature should include:
- Unit tests
- Documentation updates
- Example usage code
- Backward compatibility considerations

## See also
  https://docs.oasis-open.org/office/v1.2/os/OpenDocument-v1.2-os-part1.html

  https://getcomposer.org/doc/articles/scripts.md

  https://www.php.net/manual/en/function.xml-parse.php

  https://www.php.net/manual/en/function.xml-parse-into-struct.php
