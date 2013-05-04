<?php
include ('common.php');
include ('lib/cache.class.php');
include ('lib/castleImport.class.php');
$c = new cache();
$castle = new castleImport();

if (!isset($ts))
        die("This file cannot be called directly");
	
if( $c->getCachedTime('arena_ladder_'.$ts) < 600 AND $c->getCachedTime('arena_ladder_'.$ts) != false)
	$tmp = $c->load('arena_ladder_'.$ts);
else
{
	if($castle->getArenaTeams(2,1) !=false) //test castle
	{ 
		//castle is up and cache is old ... gen new data 
		$tmp = $castle->getArenaTeams($ts, 20);
		foreach($tmp as $i => $row_i)
		{
			$tmp[$i]['player'] = $castle->getArenaTeam($row_i['name']);
			foreach($tmp[$i]['player'] as $j => $row_j)
				$tmp[$i]['player'][$j]['classColor'] = $_class_color[$row_j['classId']]; 
		}
		$c->store('arena_ladder_'.$ts,$tmp);
	}
	else 
	{
		//oh castle is offline load old cache
		echo "castle down";
		if($c->load('arena_ladder_'.$ts) !== false)
			$c->store('arena_ladder_'.$ts,$tmp);
		else
			die('castle offline and no cache gg');
	}
}


$last_load = date('H:i d.m.y', time() - $c->getCachedTime('arena_ladder_'.$ts));

$tpl->assign_vars('ARENA_TEAMS', $tmp);
$tpl->assign_vars('TS', $ts);
$tpl->assign_vars('LAST_LOAD', $last_load);

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