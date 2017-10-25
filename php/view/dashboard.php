<?php
$doc = new DOMDocument();
$doc->loadHTMLFile("http://tk-cms-dev.herokuapp.com/html/troy-kitchen-cms.html");
echo $doc->saveHTML();
?>