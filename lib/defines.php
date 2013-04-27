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

##########################
# Faction
##########################

# faction->id to faction->name
# self-defined, value derived from class
$_faction_name = array(
	0	=> "Allianz",
	1	=> "Horde");


?>
