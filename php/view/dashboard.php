<?php
$doc = new DOMDocument();
echo $_SERVER[$DOCUMENT_ROOT];
$doc->loadHTMLFile( $_SERVER[$DOCUMENT_ROOT]."html/troy-kitchen-cms.html");
echo $doc->saveHTML();
?>