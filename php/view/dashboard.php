<?php
$doc = new DOMDocument();
$doc->loadHTMLFile( "./../../html/troy-kitchen-cms.html");
echo $doc->saveHTML();
?>