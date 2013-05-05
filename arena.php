<?php
include ('common.php');


$tpl->set_vars(array(
			'page_title'		=> 'PvP@Castle - Arena/Übersicht',
			'author'			=> 'Doomsta',
			'nav_active'		=> 'Arena',
			'sub_nav_active'	=> 'Übersicht',
			'subHeadBig'		=> 'PvP@Castle',
			'subHeadSmall'		=> 'Übersicht',
			'description'		=> 'PvP@Castle',
			'template_file'		=> 'arena.tpl',
			));
$tpl->display();
?>