<?php
require_once("./common.php");
require_once($rootpath."lib/datetime.php");
require_once($rootpath."lib/formatting.php");

// configuration
$interval = Boundaries::Week;

$credit = 300; # award 300s (=5m) per record by default

// here be dragons
require_once($rootpath."timemanager.php");

// fetch data from db
$query = sprintf("SELECT timestamp, name, guild, faction, race, class, bg 
		 FROM by_character
		 WHERE timestamp >= %d
		 AND timestamp <= %d
		 ORDER BY timestamp ASC", $bounds[0], $bounds[1]);
$result = mysql_query($query);

// $tmp[battleground][time][players]
$tmp = array();
while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
        $bg = $row['bg'];
        if (!isset($tmp[$bg]))
                $tmp[$bg] = array();

        $t = $row['timestamp'];
        if (!isset($tmp[$bg][$t]))
                $tmp[$bg][$t] = array();

        $tmp[$bg][$t][] = array("name" => $row['name'], "guild" => $row['guild'], "guild_short" => shorten_string($row['guild'], 15), "faction" => $row['faction'], "race" => $row['race'], "class" => $row['class']);
}

// group data by faction and player and prepare for assignment
// player[faction][pkey][$mapid|sum|identity]
$players = array(0 => array(), 1 => array(), 2 => array()); // initialize with proper faction order, or they'll switch by whoever players faction comes first
$battlegrounds = array();
$n = 0;
foreach ($tmp as $bg => $dataset)
{
	$last = 0;
        foreach ($dataset as $timestamp => $datapoint)
        {
		if (($timestamp - $last) < 300)
			continue; # skip, if timestamp is not newer than 5 minutes, possible duplicate log event
		$last = $timestamp;

                // determine if battleground has enough players to stay open,
                // otherwise only award 0.5*credit
                if (count($datapoint) < $_map_min_players[$bg])
                        $award_credit = 0;
//                        $award_credit = 0.5 * $credit;
                else
                        $award_credit = $credit;

		if (!isset($battlegrounds[$bg]))
			$battlegrounds[$bg] = 0;
		if (!isset($battlegrounds['sum']))
			$battlegrounds['sum'] = 0;

		$battlegrounds[$bg] += $award_credit;
		$battlegrounds['sum'] += $award_credit;
                // echo "<pre>".$timestamp."\t".$bg."\t".count($datapoint)."\t".$award_credit."\n</pre>";

                foreach ($datapoint as $player)
                {
                        $pkey = sha1($player['name'].$player['faction'].$player['class']);
                        //$pkey = $player['name'];
			$faction = $player['faction'];

                        if (!isset($players[$faction][$pkey]))
                        {
                                $players[$faction][$pkey] = array();
                                $players[$faction][$pkey]['identity'] = $player;
                                $players[$faction][$pkey]['sum'] = 0;
                        }

                        if (!isset($players[$faction][$pkey][$bg]))
                                $players[$faction][$pkey][$bg] = 0;

                        $players[$faction][$pkey][$bg] += $award_credit;
                        $players[$faction][$pkey]['sum'] += $award_credit;

                }
        }
}

// sorting
function timesum($a, $b)
{
        if ($a['sum'] == $b['sum'])
                return 0;
        return ($a['sum'] > $b['sum']) ? -1 : 1;
}

foreach ($players as $key => $value)
	usort($players[$key], "timesum");

// site-specific assignments

// actual player data
//print_r($players);
$tpl->assign_vars('dataset_summary', $battlegrounds);
$tpl->assign_vars('dataset', $players);

// map list, remove 4.x maps for this listing, remove ioc also
unset($_map_name[626]);
unset($_map_name[736]);
unset($_map_name[628]);
$tpl->assign_vars('maps', $_map_name);

// class colors
$tpl->assign_vars('class_color', $_class_color);

// faction name/colors
$tpl->assign_vars('faction_name', $_faction_name);
$tpl->assign_vars('faction_color', $_faction_color);

// template stuff
$tpl->set_vars(array(
			'page_title'		=> 'PvP@Castle - Aktivit&auml;tsrangliste',
			'author'		=> 'hexa-',
			'nav_active'		=> 'Aktivit&auml;t',
			'sub_nav_active'	=> '',
			'subHeadBig'		=> 'PvP@Castle',
			'subHeadSmall'		=> 'Aktivit&auml;t',
			'description'		=> 'PvP@Castle',
			'image'			=> "",
			'template_file'		=> 'activity.tpl',
			));
$tpl->display();
?>

