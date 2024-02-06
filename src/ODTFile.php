<?php

class ODTFile extends ZipArchive {
  private $files;
  protected $content;
  public $path;

  public function __construct($filename, $template_path = '/templates/default/' ){
    $this->path = dirname(__FILE__) . $template_path;
    if ($this->open($filename, ZIPARCHIVE::CREATE) !== TRUE) {
      die("Unable to open <$filename>\n");
    }
    $this->files = array(
      "META-INF/manifest.xml",
      "styles.xml",
      "content.xml",
      "mimetype" );

    foreach($this->files as $f) {
      $this->addFile($this->path . $f , $f);
    }
  }

  public function create_from_content($content) {
    // $this->addFromString("word/document.xml", str_replace( '{CONTENT}', $this->content, file_get_contents($this->path . "word/document.xml")));
    $this->addFromString("content.xml", $content);
    $this->close();
  }
  public function create_from_file($filename) {
    $this->create_from_content(file_get_contents($filename));
  }
  public function create_from_document($document) {
    $tmpfname = tempnam(dirname(__FILE__) . "/../temp/", "doc_");
    $handle = fopen($tmpfname, "w");
    foreach($document->create() as $doc_str) {
      fwrite($handle, $doc_str);
    }
    fclose($handle);

    $this->create_from_file($tmpfname);
    unlink($tmpfname);
  }
}