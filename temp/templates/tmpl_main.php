<?php

new DataRetain();
$dsave = DataRetain::getDataRetain();
$ctrl =$dsave->getControlObj();

$ctrl->getAcssesToGroup(array(0, 3, 7));
?>
<!DOCTYPE html>
<html lang="ru-ru">
<head>
<?php
echo $ctrl->getMetaDescription();
echo $ctrl->getMetaKeyWords();
echo $ctrl->getMetatitle();
echo $ctrl->addScript();
echo $ctrl->addCss();
?>
</head>
<body>
	<b><?php defaultControl::loadModule("registration") ?></b>
	<div><img src=""><span>Это главная страница</span></div>
</body>