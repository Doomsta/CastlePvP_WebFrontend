<?php
include ('common.php');
include ('lib/cache.class.php');
$c = new cache();

if (!isset($ts))
        die("This file cannot be called directly");
		
$tmp = $c->load('arena_ladder_'.$ts, 600);
if($tmp == false){
	include ('lib/castleImport.class.php');
	$castle = new castleImport();
	$tmp = $castle->getArenaTeams($ts,20);

	foreach($tmp as $i => $row_i)
	{
		$tmp[$i]['player'] = $castle->getArenaTeam($row_i['name']);
		foreach($tmp[$i]['player'] as $j => $row_j)
			$tmp[$i]['player'][$j]['classColor'] = $_class_color[$row_j['classId']]; 
		
	}
	$c->store('arena_ladder_'.$ts,$tmp);
}
$tpl->assign_vars('ARENA_TEAMS', $tmp);
$tpl->assign_vars('TS', $ts);

$tpl->set_vars(array(
			'page_title'		=> 'PvP@Castle - Arena/'.$ts.'vs'.$ts,
			'author'			=> 'Doomsta',
			'nav_active'		=> 'Arena',
			'sub_nav_active'	=> $ts.'vs'.$ts,
			'subHeadBig'		=> 'PvP@Castle',
			'subHeadSmall'		=> $ts.'vs'.$ts,
			'description'		=> 'PvP@Castle',
			'image'				=> './img/icon.png',
			'template_file'		=> 'arena_ts.tpl',
			));
$tpl->display();
?>