<?php
include ('common.php');
include ('lib/castleImport.class.php');

$castle = new castleImport();
$tmp = null;
$error = null;
$page_title = 'PvP@Castle - Profil';

if(isset($_GET['cn']) AND ctype_alpha($_GET['cn'])) 
{
	$cn = $_GET['cn'];
	if(($tmp = $castle->getChar($cn)) !== false)
	{
		$page_title .= '/'.$cn;
		$tmp['raceName'] = $_race_name[$tmp['raceId']];
		//add class colors 
		$tmp['classColor'] = $_class_color[$tmp['classId']];
		if(isset($tmp['arena']))
			foreach( $tmp['arena'] as $i => $teams)
				foreach( $teams['member'] as $j => $member)
					$tmp['arena'][$i]['member'][$j]['classColor'] = $_class_color[$member['classId']];
	}
	else
		$error = 'Char "'.$cn.'" not found';
}



$tpl->assign_vars('CHAR', $tmp);
$tpl->assign_vars('ERROR', $error);
$tpl->set_vars(array(
			'page_title'		=> $page_title,
			'author'			=> 'Doomsta',
			'nav_active'		=> 'Charakterprofil',
			'sub_nav_active'	=> '',
			'subHeadBig'		=> 'PvP@Castle',
			'subHeadSmall'		=> 'Profile',
			'description'		=> 'PvP@Castle',
			'template_file'		=> 'profile.tpl',
			));
$tpl->display();
?>