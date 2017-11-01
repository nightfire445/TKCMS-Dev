<?php
$doc = new DOMDocument();
echo $DOCUMENT_ROOT;
$doc->loadHTMLFile( $DOCUMENT_ROOT."html/troy-kitchen-cms.html");
echo $doc->saveHTML();
?>