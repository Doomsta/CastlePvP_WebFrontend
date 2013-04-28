<?php
require_once("./common.php");
require_once($rootpath."lib/datetime.php");
require_once($rootpath."lib/formatting.php");

// configuration
$interval = Boundaries::Day;

$credit = 300; # award 300s (=5m) per record by default
$min_players = array(   
        489     => 10,  
        529     => 12,  
        566     => 12,  
        30      => 20,  
        607     => 12,  
        628     => 10); 


// here be dragons
$boundary = get_boundaries(time()-6*86400, $interval);
$tpl->assign_vars('begin', date("r", $boundary[0]));
$tpl->assign_vars('end', date("r", $boundary[1]));

// fetch data from db
$query = sprintf("SELECT timestamp, name, guild, faction, race, class, bg 
		 FROM by_character
		 WHERE timestamp >= %d
		 AND timestamp <= %d
		 ORDER BY timestamp ASC", $boundary[0], $boundary[1]);
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
$players = array();
foreach ($tmp as $bg => $dataset)
{
        foreach ($dataset as $timestamp => $datapoint)
        {
                // determine if battleground has enough players to stay open,
                // otherwise only award 0.5*credit
                if (count($datapoint) < $min_players[$bg])
                        $award_credit = 0.5 * $credit;
                else
                        $award_credit = $credit;

                // echo "<pre>".$timestamp."\t".$bg."\t".count($datapoint)."\t".$award_credit."\n</pre>";

                foreach ($datapoint as $player)
                {
                        //$pkey = sha1($player['name'].$player['faction'].$player['class']);
                        $pkey = $player['name'];
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
$tpl->add_css_file($rootpath."lib/table-fixed-header.css");
$tpl->add_js_file($rootpath."lib/table-fixed-header.js");
$tpl->add_script("
      $(document).ready(function(){
      $('.table-fixed-header').fixedHeader();
      });");
$tpl->set_vars(array(
			'page_title'		=> 'PvP@Castle',
			'author'		=> 'author',
			'nav_active'		=> 'Spielzeit',
			'sub_nav_active'	=> 'Spielzeit',
			'subHeadBig'		=> 'PvP@Castle',
			'subHeadSmall'		=> 'Spielzeit',
			'description'		=> 'PvP@Castle',
			'image'			=> "",
			'template_file'		=> 'playtime.tpl',
			));
$tpl->display();
?>
