<?php
include ('common.php');
include ('lib/cache.class.php');
$c = new cache();
$tmp = $c->load("arenaListe", 200);
if($tmp == false){
	include ('lib/castleImport.class.php');
	$castle = new castleImport();
	$tmp[2] = $castle->getArenaTeams(2,20);
	$tmp[3] = $castle->getArenaTeams(3,20);
	//$tmp[5] = $castle->getArenaTeams(3,20); #5v5 at Castle xD

	foreach($tmp as $i => $row_i)
	{
		foreach($tmp[$i] as $j => $row_j)
		{
			$tmp[2][$j]['player'] = $castle->getArenaTeam($row_j['name']);
			foreach($tmp[2][$j]['player'] as $k => $row_j)
				$tmp[2][$j]['player'][$k]['classColor'] = $_class_color[$row_j['classId']]; 
		}
	}
	$c->store("arenaListe",$tmp);
}

$tpl->assign_vars('ARENA_TEAMS', $tmp);

$tpl->set_vars(array(
			'page_title'		=> 'PvP@Castle',
			'author'			=> 'Doomsta',
			'nav_active'		=> 'Arena',
			'sub_nav_active'	=> '',
			'subHeadBig'		=> 'PvP@Castle',
			'subHeadSmall'		=> 'Arena',
			'description'		=> 'PvP@Castle',
			'image'				=> './img/icon.png',
			'template_file'		=> 'arena.tpl',
			));
$tpl->display();
?>