<?php
require("global.php");
$insert->insertDepartment("sv");
$insert->insertGuest();
$smarty->assign("base_url",$base_url);
$smarty->display('index.tpl');
