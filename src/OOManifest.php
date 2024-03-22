<?php

namespace OpenOfficeGenerator;

class OOManifest extends OOElement {
  function __construct() {
    parent::__construct("manifest", "manifest");
    $this->attributes = "xmlns:manifest=\"urn:oasis:names:tc:opendocument:xmlns:manifest:1.0\" manifest:version=\"1.2\"";
  }
  public function get_head() {
    yield "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
    yield from parent::get_head(false);
  }
  public function get_content() {
    yield "<manifest:file-entry manifest:media-type=\"\" manifest:full-path=\"Configurations2/accelerator/current.xml\"/>
    <manifest:file-entry manifest:media-type=\"application/vnd.sun.xml.ui.configuration\" manifest:full-path=\"Configurations2/\"/>
    <manifest:file-entry manifest:media-type=\"image/png\" manifest:full-path=\"Thumbnails/thumbnail.png\"/>
    <manifest:file-entry manifest:media-type=\"text/xml\" manifest:full-path=\"content.xml\"/>
    <manifest:file-entry manifest:media-type=\"text/xml\" manifest:full-path=\"settings.xml\"/>
    <manifest:file-entry manifest:media-type=\"text/xml\" manifest:full-path=\"styles.xml\"/>
    <manifest:file-entry manifest:media-type=\"application/rdf+xml\" manifest:full-path=\"manifest.rdf\"/>
    <manifest:file-entry manifest:media-type=\"text/xml\" manifest:full-path=\"meta.xml\"/>";
    // yield <manifest:file-entry manifest:media-type=\"text/xml\" manifest:full-path=\"content.xml\"/>
    //       <manifest:file-entry manifest:media-type=\"application/binary\" manifest:full-path=\"layout-cache\"/>
    //       <manifest:file-entry manifest:media-type=\"text/xml\" manifest:full-path=\"styles.xml\"/>";
    yield from parent::get_content();
  }
  public function add_file_entry($type, $full_path) {
    $file_entry = new OOManifestFileEntry($type, $full_path);
    $this->add($file_entry);
    return $file_entry;
  }
}

class OOManifestFileEntry extends OOElement {
  function __construct($type, $full_path) {
    parent::__construct("manifest", "file-entry");
    $this->attributes = "manifest:media-type=\"$type\" manifest:full-path=\"$full_path\"";
    $this->self_closing = true;
  }
}
