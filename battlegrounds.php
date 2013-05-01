<?php
require_once('common.php');
require_once('lib/dataset.php');
require_once('lib/datetime.php');
require_once('timemanager.php');

// config


// acquire db data

if ($param_i == Boundaries::Day)
{
	$parts = 12;
	$label_format = "%H"; // Stunde
	$offset = 5*60;
}
elseif ($param_i == Boundaries::Week)
{
	$parts = 7;
	$label_format = "%a"; // Wochentag
	$offset = 5*60;
}
elseif ($param_i == Boundaries::Month)
{
	$parts = 4;
	$label_format = "KW %V";
	$offset = 2*3600;
}
else {
	$parts = 12;
	$label_format = "%b";
	$offset = 48*3600;
}

$query = "
SELECT timestamp, bg, players_a, players_h
FROM by_battleground
WHERE timestamp > ".$bounds[0]."
AND timestamp < ".$bounds[1]."
ORDER BY timestamp ASC";

$result = mysql_query($query);
$dataset = array();
while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	if (!isset($dataset[$row['bg']]))
		$dataset[$row['bg']] = array();

	$players = $row['players_a'] + $row['players_h'];
	$dataset[$row['bg']][] = array(0 => $row['timestamp'], 1 => ($players >= $_map_min_players[$row['bg']]) ? 300 : 0);
}

foreach ($_map_abbrev as $map_id => $map_abbrev)
{
	if (!isset($dataset[$map_id]))
		$dataset[$map_id] = array();
	$data = group_dataset_by_steps($dataset[$map_id], array(1), $bounds[0], $bounds[1], ($bounds[1] - $bounds[0]) / $parts, Operation::Sum);

	$values = array();
	foreach ($data as $duration)
		$values[] = ($duration[1] / 60);
	$tpl->assign_vars("DATA_".$map_abbrev, implode(",", $values));
}

$labels = array();
for ($i = $bounds[0] + $offset; $i < $bounds[1]; $i+= ($bounds[1] - $bounds[0]) / $parts)
	$labels[] = "'".strftime($label_format, $i)."'";
$tpl->assign_vars("LABEL", implode(",", $labels));


$tpl->add_js_file("./lib/Chart.js");
$tpl->set_vars(array(
			'page_title'		=> 'PvP@Castle - Schlachtfelder',
			'author'			=> 'hexa-',
			'nav_active'		=> 'Schlachtfelder',
			'sub_nav_active'	=> 'Übersicht',
			'subHeadBig'		=> 'PvP@Castle',
			'subHeadSmall'		=> 'Schlachtfelder',
			'description'		=> 'PvP@Castle',
			'image'				=> "",
			'template_file'		=> 'battlegrounds.tpl',
			));
$tpl->display();
?>
