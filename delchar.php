<?php
include ('common.php');
include ('lib/cache.class.php');
include ('lib/castleImport.class.php');
$c = new cache();
$castle = new castleImport();


$step = (isset($_GET['step'])) ? $_GET['step'] : 0;
$cn = (isset($_GET['cn'])) ? $_GET['cn'] : 0;
$_SESSION['reason'] = (isset($_GET['reason'])) ? $_GET['reason'] : null;
$error = null;

switch ($step) {
    case 1:
		// exist char in castle armory ?
		$castle = new castleImport();
		if($castle->getChar($cn) === false)
		{
			$step = 0;
			$error = 'oO <b>"'.$cn.'"</b> nicht in der Armory gefunden !';
			break;
		}
		// is char already in blacklist ?
		$query = ('SELECT timestamp
						FROM blacklist
						WHERE `character` = "'.$cn.'"
						LIMIT 0 , 1');
		$result = mysql_query($query);
		if(mysql_num_rows($result) != 0)
		{
			$step = 0;
			$error = 'oO <b>"'.$cn.'"</b> steh bereits auf der Blacklist !';
			break;
		}
		// ok char exist an is not in blacklist 
		//gen rnd slots 
		$step = 2;
		$rndNum = getRandoms(4, 0, 13);
		for($i=0;$i<4;$i++)
			$slots[$i] = array(
				'nr' => $rndNum[$i],
				'name' => $_slotId_name[$rndNum[$i]],
				);
				
		$_SESSION['slots'] = $slots;
		$_SESSION['cn'] = $cn;

		$tpl->assign_vars('SLOTS', $slots);
        break;
    case 3:
		//check slots 
		//save char to blacklist 
		//update existing entries in db
		$cn = $_SESSION['cn'];
		$slots = $_SESSION['slots'];
		$charData = $castle->getChar($cn);
		$tmp = array();
		$fail = false;
		for($i=0;$i<4;$i++) 
		{
			if(isset($charData['items'][ $slots[$i]['nr'] ]))
			{
				$tmp[ $slots[$i]['nr'] ] = array(
					'fail' => true,
					'slotName' => $slots[$i]['name'],
				);
				$fail = true;
			}
			else
			{
				$tmp[ $slots[$i]['nr'] ] = array(
					'fail' => false,
					'slotName' => $slots[$i]['name'],
				);
				$fail = true;
			}
		}
		if(count($charData['items']) < 15)
		{
			$error = 'Nur '.count($charData['items']).' der restlichen 15 Slots belegt!';
			$fail = true;
		}
		$tpl->assign_vars('STEP_3', $tmp);
		if($fail === false)
		{
			// add to blacklist
			$reason = null; //todo 
			$query = ('INSERT INTO blacklist (`character`, `reason`) VALUES ("'.$cn.'", "'.$reason.'")');
			$result = mysql_query($query);
			
			//del char in db 
			
		}
        break;
}

$tpl->assign_vars('CN', $cn);
$tpl->assign_vars('STEP', $step);
$tpl->assign_vars('ERROR_MSG', $error);


$tpl->set_vars(array(
			'page_title'		=> 'PvP@Castle - Delete Character',
			'author'			=> 'Doomsta',
			'nav_active'		=> 'Delete',
			'sub_nav_active'	=> '',
			'subHeadBig'		=> 'PvP@Castle',
			'subHeadSmall'		=> 'Delete Character',
			'description'		=> 'PvP@Castle',
			'template_file'		=> 'delchar.tpl',
			));
$tpl->display();

/*
@param  int  $quant # Anzahl Zufallszahlen
@param  int  $min   # kleinstmögliche Zahl
@param  int  $max   # grösstmögliche Zahl
@return array  $randary
*/
	function getRandoms($quant=1, $min=0, $max=1)
	{
		$randary = array();
		while(!(count($randary) >= $quant || count($randary) > $max-$min))
			$randary[mt_rand($min,$max)] = true; // Zufallszahl in Key speichern
		return array_keys($randary);
	}
?>
