<?php
$ctrl=new defaultControl();
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
 <div><img src=""><span>Запрашиваемая страница не существует</span></div>	
</body>