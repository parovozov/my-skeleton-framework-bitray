<?php

new DataRetain();
$dsave = DataRetain::getDataRetain();
$ctrl =$dsave->getControlObj();
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
	<div><img src=""><span>Тут будем логиниться</span></div>
</body>