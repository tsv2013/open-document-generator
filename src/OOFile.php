<?php

namespace OpenOfficeGenerator;

class OOFile extends \ZipArchive {
  public static $content_file_name = "content.xml";
  public static $manifest_file_name = "META-INF/manifest.xml";
  private $files;
  public $document;
  public $path;

  public function __construct($filename, $template_path = "/templates/%extension%/" ) {
    $path_info = pathinfo($filename);
    if($path_info['extension'] == "odt") {
      $this->document = new ODTDocument();
    } else if($path_info['extension'] == "ods") {
      $this->document = new ODSDocument();
    }
    $template_path = str_replace("%extension%", $path_info['extension'], $template_path);
    $this->path = dirname(__FILE__) . $template_path;
    if(file_exists($filename)) {
      if ($this->open($filename, \ZIPARCHIVE::OVERWRITE) !== TRUE) {
        die("Unable to open <$filename>\n");
      }
      if ($zip->locateName(OOFile::$content_file_name) !== false) {
        $doc_xml_content = $this->getFromName(OOFile::$content_file_name);
        $this->document->parse_xml($doc_xml_content);
      }
    } else {
      if ($this->open($filename, \ZIPARCHIVE::CREATE) !== TRUE) {
        die("Unable to create <$filename>\n");
      }
      $this->addEmptyDir('META-INF');
      $this->files = array(
        "styles.xml",
        "mimetype"
      );
      foreach($this->files as $f) {
        $this->addFile($this->path.$f, $f);
      }
    }
  }

  public function create_from_xml($xml_string) {
    if ($this->locateName(OOFile::$content_file_name) !== false) {
      $this->deleteName(OOFile::$content_file_name);
    }
    $this->addFromString(OOFile::$content_file_name, $xml_string);
    $this->close();
  }
  public function create_from_file($filename) {
    if ($this->locateName(OOFile::$content_file_name) !== false) {
      $this->deleteName(OOFile::$content_file_name);
    }
    $this->addFile($filename, OOFile::$content_file_name);
    $this->close();
  }
  public function create($temp_path = "/../temp/") {
    $this->create_from_document($this->document, $temp_path);
  }
  public function create_from_document(OODocument $document, $temp_path = "/../temp/") {
    $tmp_dir = dirname(__FILE__) . $temp_path;
    if (!file_exists($tmp_dir)) {
      mkdir($tmp_dir, 0777, true);
    }
    $tmpfname = tempnam($tmp_dir, "doc_oog_");
    $handle = fopen($tmpfname, "w");
    foreach($document->create() as $doc_str) {
      fwrite($handle, $doc_str);
    }
    fclose($handle);

    if(isset($document->pictures)) {
      $this->addEmptyDir('Pictures');
      foreach($document->pictures as $image_name => $image_path) {
        $this->addFile($image_path, "/Pictures/$image_name");
      }
    }

    $this->addFromString(OOFile::$manifest_file_name, $document->manifest->get_xml());

    $this->create_from_file($tmpfname);
    unlink($tmpfname);
  }
}
