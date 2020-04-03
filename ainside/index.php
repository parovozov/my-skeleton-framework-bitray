<?php 
echo "2222";
$uri=$_SERVER['REQUEST_URI'];
$segments = explode('/', trim($uri, '/'));
var_dump($segments);
?>