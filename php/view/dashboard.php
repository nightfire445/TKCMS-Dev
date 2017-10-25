<?php
$doc = new DOMDocument();
$doc->loadHTMLFile("https://tk-cms-dev.herokuapp.com/html/troy-kitchen-cms.html");
echo $doc->saveHTML();
?>