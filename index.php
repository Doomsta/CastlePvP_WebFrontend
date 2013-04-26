<?php
include ('common.php');



$tpl->add_js_file("./lib/Chart.js");
$tpl->set_vars(array(
			'page_title'		=> 'PvP@Castle Home',
			'subHeadBig'		=> 'PvP@Castle Home',
			'subHeadSmall'		=> 'PvP@Castle Home',
			'description'		=> 'PvP@Castle',
			'image'				=> "",
			'template_file'		=> 'index.tpl',
			));
$tpl->display();
?>