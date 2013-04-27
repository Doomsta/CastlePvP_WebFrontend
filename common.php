<?php
$rootpath = './';
require_once($rootpath.'lib/tpl.class.php');
require_once($rootpath.'config.php'); 
$tpl = new tpl;
$tpl->assign_vars("BOOTSRAPPATH", $rootpath.'bootstrap/');
$tpl->assign_vars("PROJEKTNAME", PROJEKTNAME);
$tpl->add_css_file($rootpath."css/common.css");

require_once($rootpath.'lib/defines.php');
?>
