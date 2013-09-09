<?php
session_start();
$_SESSION["user_id"]=2;
require("../include/site_config.php");
require_once("../include/database_config.php");
require_once('../include/class/class.MySQL.php');
require('../include/class/smarty/Smarty.class.php');
require("../include/insert.php");
require("../include/update.php");
require("../include/get.php");

header('Content-Type: text/html; charset=utf-8' );


$smarty = new Smarty();
$insert = new insert();
$update = new update();
$get = new get();


$smarty->setTemplateDir(__dir__.'/style/templates/');
$smarty->setCompileDir(__dir__.'/style/templates_c/');
$smarty->setConfigDir(__dir__.'/style/configs/');
$smarty->setCacheDir(__dir__.'/style/cache/');

