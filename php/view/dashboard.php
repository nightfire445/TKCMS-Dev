<?php
$doc = new DOMDocument();
$doc->loadHTMLFile(__DIR__."/../../html/troy-kitchen-cms.html");
echo $doc->saveHTML();
?>