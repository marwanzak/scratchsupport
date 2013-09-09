<?php
require("./include/site_config.php");
require('./include/class/smarty/Smarty.class.php');

header('Content-Type: text/html; charset=utf-8' );


$smarty = new Smarty();

$smarty->setTemplateDir(__dir__.'/style/templates/');
$smarty->setCompileDir(__dir__.'/style/templates_c/');
$smarty->setConfigDir(__dir__.'/style/configs/');
$smarty->setCacheDir(__dir__.'/style/cache/');

