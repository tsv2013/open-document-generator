<?php

namespace OpenOfficeGenerator;

class ODTTableOfContents extends ODTElement {
    public $toc_title;
    protected $toc_style;
    function __construct($toc_title = "Content", $toc_name = "TableOfContent") {
      parent::__construct("text", "table-of-content");
      $this->toc_title = $toc_title;
      $this->toc_style = "Sect1";
      $this->attributes = "text:style-name=\"$this->toc_style\" text:protected=\"true\" text:name=\"$toc_name\"";
      $this->create_style("Contents1", "paragraph", "Standard", "<style:paragraph-properties>
            <style:tab-stops>
                <style:tab-stop style:position=\"14cm\" style:type=\"right\" style:leader-style=\"dotted\" style:leader-text=\".\" />
            </style:tab-stops>
        </style:paragraph-properties>");
      $this->create_style($this->toc_style, "section", "Standard", "<style:section-properties style:editable=\"false\">
            <style:columns fo:column-count=\"1\" fo:column-gap=\"0cm\" />
        </style:section-properties>");
    }
    protected function get_content() {
      yield "<text:table-of-content-source text:outline-level=\"3\">
              <text:index-title-template text:style-name=\"ContentsHeading\">$this->toc_title</text:index-title-template>
              <text:table-of-content-entry-template text:outline-level=\"1\"
                  text:style-name=\"Contents1\">
                  <text:index-entry-chapter />
                  <text:index-entry-text />
                  <text:index-entry-tab-stop style:type=\"right\" style:leader-char=\".\" />
                  <text:index-entry-page-number />
              </text:table-of-content-entry-template>
              <text:table-of-content-entry-template text:outline-level=\"2\"
                  text:style-name=\"Contents2\">
                  <text:index-entry-chapter />
                  <text:index-entry-text />
                  <text:index-entry-tab-stop style:type=\"right\" style:leader-char=\".\" />
                  <text:index-entry-page-number />
              </text:table-of-content-entry-template>
              <text:table-of-content-entry-template text:outline-level=\"3\"
                  text:style-name=\"Contents3\">
                  <text:index-entry-chapter />
                  <text:index-entry-text />
                  <text:index-entry-tab-stop style:type=\"right\" style:leader-char=\".\" />
                  <text:index-entry-page-number />
              </text:table-of-content-entry-template>
          </text:table-of-content-source>
          <text:index-body>
              <text:index-title text:style-name=\"$this->toc_style\" text:name=\"TOCHead\">
                  <text:p text:style-name=\"ContentsHeading\">$this->toc_title</text:p>
              </text:index-title>
          </text:index-body>";
    }
  }
