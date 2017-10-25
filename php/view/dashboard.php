<?php
$doc = new DOMDocument();
$doc->loadHTMLFile( $DOCUMENT_ROOT."html/troy-kitchen-cms.html");
echo $doc->saveHTML();
?>