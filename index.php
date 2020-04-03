<?php
define("JURL", $_SERVER['DOCUMENT_ROOT']);

require_once('connectdb.php');
require_once('module_position.php');
require_once('baseclass.php');

$segments[0]="";
if($segments[0]=="ainside")
{
	header("location: http://itvideos.loc/ainside");	
	//$fitch = $db->prepare($createtable);
	//$fitch->execute();
}
?>