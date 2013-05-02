<?php
date_default_timezone_set('UTC');
session_start();

$rootpath = './';
require_once($rootpath.'lib/tpl.class.php');
require_once($rootpath.'lib/defines.php');
require_once($rootpath.'config.php'); 
$tpl = new tpl;
$tpl->assign_vars("BOOTSRAPPATH", $rootpath.'bootstrap/');
$tpl->assign_vars("PROJEKTNAME", PROJEKTNAME);
$tpl->add_css_file($rootpath."css/common.css");
$nav_links = array(
	0 => array(
		'name'	=> 'Home',
		'url'	=> './index.php'
		),
	1 => array(
		'name'	=> 'Schlachtfelder',
		'url'	=> './battlegrounds.php',
		'sub'   => array(
			0 => array('name'	=> 'Übersicht',
				   'url'	=> './battlegrounds.php'),

			4 => array('name'	=> 'Kriegshymnenschlucht',
				   'url'	=> './battlegrounds_wsg.php',
				   'icon'	=> './img/battlegrounds/489.jpg'),

			2 => array('name'	=> 'Arathibecken',
				   'url'	=> './battlegrounds_ab.php',
				   'icon'	=> './img/battlegrounds/529.jpg'),

			3 => array('name'	=> 'Auge des Sturms',
				   'url'	=> './battlegrounds_eos.php',
				   'icon'	=> './img/battlegrounds/566.jpg'),

			1 => array('name'	=> 'Alteractal',
				   'url'	=> './battlegrounds_av.php',
				   'icon'	=> './img/battlegrounds/30.jpg'),

			5 => array('name'	=> 'Strand der Uralten',
				   'url'	=> './battlegrounds_sota.php',
				   'icon'	=> './img/battlegrounds/607.jpg'))
		),
	2 => array(
		'name'	=> 'Arena',
		'url'	=> './arena.php'
		),
	3 => array(
		'name'	=> 'Aktivit&auml;t',
		'url'	=> './activity.php'
		),
	4 => array(
		'name'	=> 'Charakterprofil',
		'url'	=> './profile.php'
		),
	5 => array(
		'name'	=> 'FAQ',
		'url'	=> './faq.php'
		),
	);
$tpl->add_nav_links($nav_links);

# MySQL Connection
mysql_connect($mysql_host, $mysql_user, $mysql_pass);
mysql_select_db($mysql_db);
unset($mysql_pass); # lose the password right here, we don't need it anymore afterwards
include('./lib/shoutbox.php');
# Piwik Tracking Support
$tpl->assign_vars('piwik_tracking', $piwik_tracking);

?>
