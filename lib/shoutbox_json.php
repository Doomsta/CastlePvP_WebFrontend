<?php
require_once('../config.php');
mysql_connect($mysql_host, $mysql_user, $mysql_pass);
mysql_select_db($mysql_db);
unset($mysql_pass);
$setOddEven = 0;
$postClass = "entries";

	function messageCountSet($cnt){
		if(isset($cnt) && $cnt != ''){
			if($cnt=='all' || is_numeric($cnt) && $cnt >= '1'){
				if($cnt=='all'){
					$count='all';
				}else{
					$count=$cnt;
				}
			}else{
				$count=5;
			}
		}else{
			$count = 5;
		}
		return $count;
	}
	/* Pre Set $action */
	if(isset($_GET['count'])){ $count = messageCountSet($_GET['count']); }else{ $count = messageCountSet(''); }
	if(!isset($_POST['action']))
		{ $action = 'fetch'; }
		else
		{ $action = $_POST['action']; }
	/* Write a new entry to the database */
	if($action == "write"){
		$errorOne = 0;
		$errorTwo = 0;
		$error = 0;
		if($_POST['name'] == ''){ $errorOne = 1; $error++; }else{ $name= stripslashes(htmlspecialchars($_POST['name'])); }
		if($_POST['message'] == ''){ $errorTwo = 1; $error++; }else{ $message = stripslashes(htmlspecialchars($_POST['message'])); }
		if($error == 0){
			mysql_query("INSERT INTO shoubox (name, message, ip, date) VALUES ('".$name."', '".$message."', '".$_SERVER['REMOTE_ADDR']."', '".time()."')");
		}
		/* AJAX check  */
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') { die(); }
	}
	
	/* Fetch entries from databse */
	if($action == "fetch"){
		$postsCount = 1; /* Post count */
		if($count >= '1'  && is_numeric($count) && $count != 'all'){
			$sql_query = mysql_query("SELECT * FROM shoubox ORDER BY date DESC LIMIT 0,$count");
		}else{
			$sql_query = mysql_query("SELECT * FROM shoubox ORDER BY date DESC");
		}
		while($row = mysql_fetch_assoc($sql_query)){
			$name= stripslashes($row['name']);
			$message = stripslashes($row['message']); /* Old: htmlentities(stripslashes(htmlspecialchars($row['message']))); */
			if($setOddEven == 1){
				if($postsCount & 1){
					$postClassJson = ', "odd"';
					$postClass = ' odd';
				}else{
					$postClassJson = ', "even"';
					$postClass = ' even';
				}
			}
			if(isset($_GET['call']) && $_GET['call'] == 'json'){
				echo '{
					"date": "'.date('d.m.Y H:i:s', $row['date']).'",
					"name": "'.$name.'",
					"message": "'.$message.'",
					"ids": ["'.$row['id'].'",'.$postsCount.$postClassJson.']
				}<br />';
			}else{
				 echo '<div class="post round drop-shadow'.$postClass.'" id="post'.$postsCount.'">
						<div class="metaInfo"><abbr title="Am '.date('d.m.Y H:i:s', $row['date']).'"><b>'.$name.'</b></abbr> schrieb:</div>
						<div class="text"><p>'.$message.'</p></div>
						</div>';
			}
			$postsCount++;
		}
	}
?>


