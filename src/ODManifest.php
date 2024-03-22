<?php

namespace OpenDocumentGenerator;

class ODManifest extends ODElement {
  function __construct() {
    parent::__construct("manifest", "manifest");
    $this->attributes = "xmlns:manifest=\"urn:oasis:names:tc:opendocument:xmlns:manifest:1.0\" manifest:version=\"1.2\"";
    $this->add(new ODManifestFileEntry("application/binary", "layout-cache"));
    $this->add(new ODManifestFileEntry("text/xml", "content.xml"));
    $this->add(new ODManifestFileEntry("text/xml", "styles.xml"));
  }
  public function get_head() {
    yield "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
    yield from parent::get_head(false);
  }
  public function add_file_entry($type, $full_path) {
    $file_entry = new ODManifestFileEntry($type, $full_path);
    $this->add($file_entry);
    return $file_entry;
  }
}

class ODManifestFileEntry extends ODElement {
  function __construct($type, $full_path) {
    parent::__construct("manifest", "file-entry");
    $this->attributes = "manifest:media-type=\"$type\" manifest:full-path=\"$full_path\"";
    $this->self_closing = true;
  }
}
