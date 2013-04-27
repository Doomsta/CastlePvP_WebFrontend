<?php

############################
# Races
############################

# race->id to race->name
# according to ChrRaces.dbc
$_race_name = array(
	1	=> "Mensch",
	2	=> "Ork",
	3	=> "Zwerg",
	4	=> "Nachtelf",
	5	=> "Untote",
	6	=> "Taure",
	7	=> "Gnom",
	8	=> "Troll",
	9	=> "Goblin",	# 4.x
	10	=> "Blutelf",
	11	=> "Draenei",
	22	=> "Worg");	# 4.x

$_race_faction = array(
	1	=> 0,
	2	=> 1,
	3	=> 0,
	4	=> 0,
	5	=> 1,
	6	=> 1,
	7	=> 0,
	8	=> 1,
	9	=> 1,
	10	=> 1,
	11	=> 0,
	22	=> 0);

###########################
# Classes
###########################

# class->id to class->name
# according to ChrClasses.dbc
$_class_name = array(
	1	=> "Warrior",
	2	=> "Paladin",
	3	=> "Hunter",
	4	=> "Rogue",
	5	=> "Priest",
	6	=> "Death Knight",
	7	=> "Shaman",
	8	=> "Mage",
	9	=> "Warlock",
	11	=> "Druid");
	
# class->id to class->color
$_class_color = array(
	1	=> '#C69B6D',	// warrior
	2	=> '#F48CBA',	// paladin
	4	=> '#AAD372',	// hunter
	4	=> '#FFF468',	// rogue
	5	=> '#FFFFFF',	// priest
	6	=> '#C41F3B',	// DK
	7	=> '#1a3caa',	// shaman
	8	=> '#68CCEF',	// mage
	9	=> '#9382C9',	// warlock
	11	=> '#FF7C0A');	// druid

##########################
# Faction
##########################

# faction->id to faction->name
# self-defined, value derived from class
$_faction_name = array(
	0	=> "Allianz",
	1	=> "Horde");
	
# faction->id to faction->color
$_faction_color = array(
	0	=> "#0000FF",
	1	=> "#CC0000");

##########################
# Map
##########################

# map->id to map->name
# according to Maps.dbc
# excerpt for battlegrounds only!
$_map_name = array(
	489	=> "Kriegshymnenschlucht",
	529	=> "Arathibecken",
	566	=> "Auge des Sturms",
	30	=> "Alteractal",
	607	=> "Strand der Uralten",
	626	=> "Zwillingsgipfel",		# 4.x
	628	=> "Insel der Eroberung",
	736	=> "Die Schlacht um Gilneas");	# 4.x

# map->id to map->abbreviation
# accordingo to common usage
$_map_abbrev = array(
	489	=> "WSG",
	529	=> "AB",
	566	=> "EOS",
	30	=> "AV",
	607	=> "SOTA",
	626	=> "TP",
	628	=> "IOC",
	736	=> "Gilneas"); # are you Sirius? :]

?>
