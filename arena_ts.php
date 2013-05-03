<?php
include ('common.php');
include ('lib/cache.class.php');
include ('lib/castleImport.class.php');
$c = new cache();
$castle = new castleImport();

if (!isset($ts))
        die("This file cannot be called directly");
		
if($castle->getArenaTeams($ts,1) !=false) //ok castle is on everythink fine ^^
{
	if($c->getCachedTime('arena_ladder_'.$ts) == false OR $c->getCachedTime('arena_ladder_'.$ts) > 600)  //we got no cache or old data ...gen new one
	{
		$tmp = $castle->getArenaTeams($ts, 20);
		foreach($tmp as $i => $row_i)
		{
			$tmp[$i]['player'] = $castle->getArenaTeam($row_i['name']);
			foreach($tmp[$i]['player'] as $j => $row_j)
				$tmp[$i]['player'][$j]['classColor'] = $_class_color[$row_j['classId']]; 
		}
		$c->store('arena_ladder_'.$ts,$tmp);
	}
	else //load the cache
	{
		
		$tmp = $c->load('arena_ladder_'.$ts);
	}
	
}
else //oh snap! castle is down .. load last cache data
{
	if($c->getCachedTime('arena_ladder_'.$ts) == false) // no cache ? ... thats rly bad
	{
		die('Castle down and no Cached data Sry');
	}
	else	//load old cache data
	{
		$tmp = $c->load('arena_ladder_'.$ts);
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