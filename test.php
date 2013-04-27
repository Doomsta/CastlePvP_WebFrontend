<?php
include ('common.php');

$label = "0,6,7,8,9,16,17";
$data0 = "0,6,5,7,9,55,70";
$data1 = "0,4,3,5,3,33,40";
$data2 = "0,2,2,5,6,23,31";

$tpl->assign_vars('LABEL', $label);
$tpl->assign_vars('DATA0', $data0);
$tpl->assign_vars('DATA1', $data1);
$tpl->assign_vars('DATA2', $data2);

$tpl->add_js_file("./lib/Chart.js");
$tpl->set_vars(array(
			'page_title'		=> 'PvP@Castle test',
			'author'			=> 'author',
			'subHeadBig'		=> 'PvP@Castle test',
			'subHeadSmall'		=> 'PvP@Castle test',
			'description'		=> 'PvP@Castle',
			'image'				=> "",
			'template_file'		=> 'test.tpl',
			));
$tpl->display();
?>
