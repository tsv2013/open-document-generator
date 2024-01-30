<?php

class ODTElement {
  protected $namespase = "";
  protected $name = "";
  public $attributes = "";
  public $content = [];
  function __construct($namespase, $name) {
    $this->namespase = $namespase;
    $this->name = $name;
  }
  protected function get_content() {
    $content_text = "";
    foreach ($this->content as $content_item) {
      $item_text = $content_item->create();
      $content_text = $content_text . $item_text;
    }
    return $content_text;
  }
  public function create() {
    return "<{$this->namespase}:{$this->name} {$this->attributes}>{$this->get_content()}</{$this->namespase}:{$this->name}>";
  }
  function add($element) {
    array_push($cell->content, $element);
  }
}
class ODTStyle extends ODTElement {
  private $style_name;
  public $properties;
  function __construct($style_name) {
    parent::__construct("style", "style");
    $this->style_name = $style_name;
    $this->attributes = "style:name=\"$style_name\" style:family=\"text\"";
    $this->properties = "<style:text-properties fo:font-size=\"11.00pt\" fo:font-weight=\"bold\" fo:font-family=\"Calibri\" style:font-family-asian=\"Calibri\" style:font-family-complex=\"Calibri\" fo:background-color=\"transparent\" style:use-window-font-color=\"true\" />";
  }
  protected function get_content() {
    return $this->properties;
  }
}
class ODTPara extends ODTElement {
  public $style_name;
  public $text = "";
  function __construct($style_name, $text) {
    parent::__construct("text", "p");
    $this->style_name = $style_name;
    $this->text = $text;
    $this->attributes = `text:style-name="$style_name"`;
  }
  protected function get_content() {
    return "<text:span text:style-name=\"$this->style_name\">$this->text</text:span>";
  }
}
class ODTTable extends ODTElement {
  public $style_name;
  function __construct($style_name) {
    parent::__construct("table", "table");
    $this->style_name = $style_name;
    $this->attributes = `table:style-name="$style_name"`;
  }
  function create_row($row_style) {
    $row = new ODTTableRow($row_style);
    array_push($this->content, $row);
    return $row;
  }
}
class ODTTableRow extends ODTElement {
  public $style_name;
  function __construct($style_name) {
    parent::__construct("table", "table-row");
    $this->style_name = $style_name;
    $this->attributes = `table:style-name="$style_name"`;
  }
  function create_cell($cell_style) {
    $cell = new ODTTableCell($cell_style);
    array_push($this->content, $cell);
    return $cell;
  }
  function add_cell_with_text($text, $style = "default") {
    $cell = $this->create_cell("default");
    $para = new ODTPara($style, $text);
    array_push($cell->content, $para);
  }
}
class ODTTableCell extends ODTElement {
  public $style_name;
  function __construct($style_name) {
    parent::__construct("table", "table-cell");
    $this->style_name = $style_name;
    $this->attributes = `table:style-name="$style_name"`;
  }
}
class ODTDocument extends ODTElement {
  public $styles = [];
  function __construct() {
    parent::__construct("office", "document-content");
    $this->attributes = "xmlns:office=\"urn:oasis:names:tc:opendocument:
                          xmlns:office:1.0\"
                          xmlns:meta=\"urn:oasis:names:tc:opendocument:
                          xmlns:meta:1.0\"
                          xmlns:config=\"urn:oasis:names:tc:opendocument:
                          xmlns:config:1.0\"
                          xmlns:text=\"urn:oasis:names:tc:opendocument:
                          xmlns:text:1.0\"
                          xmlns:table=\"urn:oasis:names:tc:opendocument:
                          xmlns:table:1.0\"
                          xmlns:draw=\"urn:oasis:names:tc:opendocument:
                          xmlns:drawing:1.0\"
                          xmlns:presentation=\"urn:oasis:names:tc:opendocument:
                          xmlns:presentation:1.0\"
                          xmlns:dr3d=\"urn:oasis:names:tc:opendocument:
                          xmlns:dr3d:1.0\"
                          xmlns:chart=\"urn:oasis:names:tc:opendocument:
                          xmlns:chart:1.0\"
                          xmlns:form=\"urn:oasis:names:tc:opendocument:
                          xmlns:form:1.0\"
                          xmlns:script=\"urn:oasis:names:tc:opendocument:
                          xmlns:script:1.0\"
                          xmlns:style=\"urn:oasis:names:tc:opendocument:
                          xmlns:style:1.0\"
                          xmlns:number=\"urn:oasis:names:tc:opendocument:
                          xmlns:datastyle:1.0\"
                          xmlns:anim=\"urn:oasis:names:tc:opendocument:
                          xmlns:animation:1.0\"
                          xmlns:dc=\"http://purl.org/dc/elements/1.1/\"
                          xmlns:xlink=\"http://www.w3.org/1999/xlink\"
                          xmlns:math=\"http://www.w3.org/1998/Math/MathML\"
                          xmlns:xforms=\"http://www.w3.org/2002/xforms\"
                          xmlns:fo=\"urn:oasis:names:tc:opendocument:
                          xmlns:xsl-fo-compatible:1.0\"
                          xmlns:svg=\"urn:oasis:names:tc:opendocument:
                          xmlns:svg-compatible:1.0\"
                          xmlns:smil=\"urn:oasis:names:tc:opendocument:
                          xmlns:smil-compatible:1.0\"";
  }
  protected function get_content() {
    $styles_text = "";
    foreach ($this->styles as $style_item) {
      $style_text = $style_item->create();
      $styles_text = $styles_text . $style_text;
    }
    $content_text = parent::get_content();
    return "<office:automatic-styles>$styles_text</office:automatic-styles><office:body><office:text>$content_text</office:text></office:body>";
  }
}

class ODTFile extends ZipArchive {
    private $files;
    protected $content;
    public $path;

    public function __construct($filename, $template_path = '/../cl_templates/document/' ){
      $this->path = dirname(__FILE__) . $template_path;
      if ($this->open($filename, ZIPARCHIVE::CREATE) !== TRUE) {
        die("Unable to open <$filename>\n");
      }
      $this->files = array(
        "META-INF/manifest.xml",
        "meta.xml",
        "styles.xml",
        "content.xml",
        "mimetype" );

      foreach( $this->files as $f ) {
        $this->addFile($this->path . $f , $f );
      }
    }

    public function create_from_document($document) {
      $this->addFromString("content.xml", $document->create());
      $this->close();
    }
    public function create_from_content($content) {
      // $this->addFromString("word/document.xml", str_replace( '{CONTENT}', $this->content, file_get_contents( $this->path . "word/document.xml" ) ) );
      $this->addFromString("content.xml", $content);
      $this->close();
    }
    public function create_from_file($filename) {
      $this->addFromString("content.xml", file_get_contents($filename));
      $this->close();
    }
}
