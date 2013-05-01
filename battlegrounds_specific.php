<?php
require_once('common.php');
require_once('lib/dataset.php');
require_once('lib/datetime.php');
require_once('timemanager.php');

if (!isset($_battleground_mapid))
	die("This file cannot be called directly");

// config


// acquire db data

// [Class Distribution (Alliance/Horde/Total)] for Radar Chart
$query = "
SELECT timestamp, name, faction, race, class
FROM by_character
WHERE timestamp > ".$bounds[0]."
AND timestamp < ".$bounds[1]."
AND bg = ".$_battleground_mapid."";

$result = mysql_query($query);

$dataset = array();
while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$time = $row['timestamp'];
	$name = $row['name'];
	$faction = $row['faction'];
	$class = $row['class'];

	$pkey = sha1($name.$faction.$class); # unique id
	$pkey = $name;

	// Need: Unique Characters per Class per Faction/Total
	$dataset[$faction][$class][$pkey][] = $time;
	$dataset[2][$class][$pkey][] = $time;
}


$alliance = array();
$horde = array();
$total = array();

// init arrays
foreach ($_class_name as $class_id => $class)
{
	$alliance[$class_id] = 0;
	$horde[$class_id] = 0;
	$total[$class_id] = 0;
}

// fill with proper data
foreach ($dataset as $faction_id =>  $faction)
{
	foreach ($faction as $class_id => $class)
	{
		foreach ($class as $key => $player)
		{
			$credit = count($player) * 5;
			//echo "<span style=\"font-weight:bold;color:".$_class_color[$class_id]."\">".$key."</span> => ".$credit."<br />";
			switch ($faction_id) {
				case 0:
					// $alliance[$class_id] = count($class);
					$alliance[$class_id] += $credit;
					break;
				case 1:
					// $horde[$class_id] = count($class);
					$horde[$class_id] += $credit;
					break;
				case 2:
					//$total[$class_id] = count($class);
					$total[$class_id] += $credit;
					break;
			}
		}
	}
}

ksort($alliance);
ksort($horde);
ksort($total);

/*
echo "<pre>";
print_r($alliance);
print_r($horde);
print_r($total);
echo "</pre>";
*/

$labels = array();
foreach ($_class_name as $label)
	$labels[] = "'".$label."'";

$tpl->assign_vars("labels", implode(",", $labels));
$tpl->assign_vars("alliance", implode(",", $alliance));
$tpl->assign_vars("horde", implode(",", $horde));
$tpl->assign_vars("total", implode(",", $total));

// generictemplate stuff
$tpl->assign_vars("title", $_map_name[$_battleground_mapid]);

$tpl->add_js_file("./lib/Chart.js");
$tpl->set_vars(array(
			'page_title'		=> 'PvP@Castle - '.$_map_name[$_battleground_mapid],
			'author'			=> 'hexa-',
			'nav_active'		=> 'Schlachtfelder',
			'sub_nav_active'	=> $_map_name[$_battleground_mapid],
			'subHeadBig'		=> 'PvP@Castle',
			'subHeadSmall'		=> 'Schlachtfelder',
			'description'		=> 'PvP@Castle',
			'image'				=> "",
			'template_file'		=> 'battlegrounds_specific.tpl',
			));
$tpl->display();
?>
