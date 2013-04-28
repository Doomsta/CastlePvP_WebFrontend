<?php
date_default_timezone_set('UTC');

$rootpath = './';
require_once($rootpath.'lib/tpl.class.php');
require_once($rootpath.'config.php'); 
$tpl = new tpl;
$tpl->assign_vars("BOOTSRAPPATH", $rootpath.'bootstrap/');
$tpl->assign_vars("PROJEKTNAME", PROJEKTNAME);
$tpl->add_css_file($rootpath."css/common.css");
$nav_links = array(
	1 => array(
		'name'	=> 'Home',
		'url'	=> './index.php'
		),
	2 => array(
		'name'	=> 'test',
		'url'	=> './test.php'
		),
	3 => array(
		'name'	=> 'test3',
		'url'	=> './test.php'
		),
	4 => array(
		'name'	=> 'test4',
		'url'	=> './test.php'
		)
	);
$tpl->add_nav_links($nav_links);
$tpl->add_sub_nav_links($nav_links);
require_once($rootpath.'lib/defines.php');

# MySQL Connection
mysql_connect($mysql_host, $mysql_user, $mysql_pass);
mysql_select_db($mysql_db);
unset($mysql_pass); # lose the password right here, we don't need if anymore afterwards

?>
