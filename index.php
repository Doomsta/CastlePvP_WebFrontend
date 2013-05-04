<?php
include ('common.php');
$tables = array('global', 'by_class', 'by_character', 'by_battleground');
foreach($tables as $tableName)
{ 
	$query = 'SELECT count(*) as value FROM '.$tableName;
	$result = mysql_query($query);
	$anzahl = mysql_fetch_object($result);
	$out[$tableName] = number_format($anzahl->value, 0, ',', '.'); 
}

$query = 'SELECT timestamp FROM global';
$result = mysql_query($query);
$row = mysql_fetch_object($result);
$first = date('H:i d.m.y', $row->timestamp);

$tpl->assign_vars('FIRST', $first);
$tpl->assign_vars('TABLEDATA', $out);
$tpl->add_js_file("./lib/Chart.js");
$tpl->set_vars(array(
			'page_title'		=> 'PvP@Castle Home',
			'author'			=> 'author',
			'nav_active'		=> 'Home',
			'sub_nav_active'	=> 'Home',
			'subHeadBig'		=> 'PvP@Castle Home',
			'subHeadSmall'		=> 'PvP@Castle Home',
			'description'		=> 'PvP@Castle',
			'image'				=> "",
			'template_file'		=> 'index.tpl',
			));
$tpl->display();
?>