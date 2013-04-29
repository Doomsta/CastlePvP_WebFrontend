<?php
/*
* tsShoutbox
* Version: 1.0
* (C) 2009 by Top-Side.de
* Lizenz: http://creativecommons.org/licenses/by-nc-sa/3.0/deed.de
*/
include("sb_files/data/config.php");

$font_size_small = $font_size * 0.75;
$width_left = round($width / 3);
$width_right = $width - $width_left;
$border = "border: ".$border_width."px ".$border_style." ".$border_color;
$style = "
td.left { color: ".$font_color."; width: ".$width_left."px; ".$border."; vertical-align: top; background: ".$color_cell_left." }
td.right { color: ".$font_color."; width: ".$width_right."px; ".$border."; background: ".$color_cell_right." }
.inverse { color: ".$color_background_center."; background: ".$border_color."; padding: 2px }
table { ".$border."; border-collapse: collapse; spacing: 0 }
body { scrollbar-base-color: ".$color_background."; scrollbar-arrow-color: ".$border_color."; background: ".$color_background." }
td { color: ".$font_color."; font-family: ".$font_family."; font-size: ".$font_size."px; padding: 5px; background: ".$color_background_center." }
a:link { color: ".$link_color."; font-family: ".$font_family."; font-size: ".$font_size."px; text-decoration: ".$link_style." }
a:active { color: ".$link_color."; font-family: ".$font_family."; font-size: ".$font_size."px; text-decoration: ".$link_style." }
a:visited { color: ".$link_color."; font-family: ".$font_family."; font-size: ".$font_size."px; text-decoration: ".$link_style." }
a:hover { color: ".$link_color_hover."; font-family: ".$font_family."; font-size: ".$font_size."px; text-decoration: ".$link_style_hover." }
textarea { color: ".$font_color."; font-family: ".$font_family."; font-size: ".$font_size."px; background-color: ".$color_background_center."; ".$border." }
input { color: ".$font_color."; font-family: ".$font_family."; font-size: ".$font_size."px; background-color: ".$color_background_center."; ".$border." }
select { color: ".$font_color."; font-family: ".$font_family."; font-size: ".$font_size."px; background-color: ".$color_background_center."; ".$border." }
table.none { border: none }\ntable.none td { padding: 0px; background-color: transparent }\nimg { border: none }
";

function Redirect()
{
	echo "<tr><td colspan=\"2\">\n";
	echo "<meta http-equiv=\"refresh\" content=\"3; url=shoutbox.php\">\n";
    echo "Du wirst in 3 Sekunden weitergeleitet, falls nicht <a href=\"shoutbox.php\">klick hier</a>.\n";
	echo "</td></tr>\n";
}

function BB_Code($input)
{
	$input = str_replace('\"', '"', $input);
	$input = str_replace(":-)", "<img src=\"sb_files/smilies/smile.png\" alt=\":-)\">", $input);
	$input = str_replace("%-(", "<img src=\"sb_files/smilies/confused.png\" alt=\"%-(\">", $input);
	$input = str_replace("8-]", "<img src=\"sb_files/smilies/in_love.png\" alt=\"8-]\">", $input);
	$input = str_replace(":-D", "<img src=\"sb_files/smilies/lol.png\" alt=\":-D\">", $input);
	$input = str_replace(":-z", "<img src=\"sb_files/smilies/mad.png\" alt=\":-z\">", $input);
	$input = str_replace(":-(", "<img src=\"sb_files/smilies/sad.png\" alt=\":-(\">", $input);
	$input = str_replace(";-)", "<img src=\"sb_files/smilies/winking.png\" alt=\";-)\">", $input);
	return $input;
}

function CheckLogin()
{
	if(!$_SESSION['login'])
	{
		echo "<tr><td colspan=\"2\">\n";
		echo "<font style=\"color: #ff0000; font-weight: bold\">Nicht eingeloggt!</font>&nbsp;\n";
		echo "<a href=\"shoutbox.php?p=login\">Login</a>\n";
		echo "</td></tr>\n";
		echo "</table>\n</td></tr>\n</table>\n</body>\n\n</html>";
		die();
	}
}

session_start();
if(!isset($_SESSION['login']))
	$_SESSION['login'] = false;
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"
        \"http://www.w3.org/TR/html4/loose.dtd\">\n";
echo "<html>\n<head>\n";
echo "<title>".$title."</title>\n";
echo "<script type=\"text/javascript\">\n";
echo "function smilie(name)\n{\ndocument.inscribe.entry.value += name;\ndocument.inscribe.entry.focus();\n}\n";
echo "</script>\n";
echo "<style type=\"text/css\">".$style."</style>\n";
echo "</head>\n\n";
echo "<body>\n";

echo "<table align=\"center\" width=\"".$width."\">\n";
echo "<tr><td>\n";
echo "<table style=\"width: 100%; border: 0\">\n";

if($_SESSION['login'])
{
	echo "<tr><td colspan=\"2\" class=\"left\">\n";
	echo "<table style=\"text-align: center\"><tr>\n";
	echo "<td><b>Admin<br>Control<br>Panel</b></td>\n";
	echo "<td><a href=\"shoutbox.php?p=settings\" style=\"text-decoration: none\"><img src=\"sb_files/images/config.png\" alt=\"Einstellungen\"><br>Einstellungen</a></td>\n";
	echo "<td><a href=\"shoutbox.php?p=setpassword\" style=\"text-decoration: none\"><img src=\"sb_files/images/password.png\" alt=\"Passwort &auml;ndern\"><br>Passwort &auml;ndern</a></td>\n";
	echo "<td><a href=\"shoutbox.php?p=deleteall\" style=\"text-decoration: none\"><img src=\"sb_files/images/trash.png\" alt=\"Shoutbox leeren\"><br>Shoutbox leeren</a></td>\n";
	echo "</tr></table>\n</td></tr>\n";
	echo "<tr><td colspan=\"2\">&nbsp;</td></tr>\n";
}

if(!isset($_GET['p']))
	$_GET['p'] = "";
switch($_GET['p'])
{
	case "login":
		echo "<form action=\"shoutbox.php?p=login\" method=\"post\" name=\"login\">\n";
		echo "<tr>\n<td class=\"left\"><b>Passwort</b></td>\n";
		echo "<td class=\"right\"><input type=\"password\" name=\"passwort\" size=\"25\" maxlength=\"20\"></td>\n</tr>\n";
		echo "<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" name=\"login\" value=\"Login\"></td></tr>\n";
		echo "</form>\n";
		
		if($_POST['login'])
		{
			echo "<tr><td colspan=\"2\">\n";
			if($_POST['passwort'] == $adminPass)
			{
				$_SESSION['login'] = true;
				echo "<font style=\"color: #008b00; font-weight: bold\">Login erfolgreich.</font>\n";
				Redirect();
			}
			else
			{
				echo "<font style=\"color: #ff0000; font-weight: bold\">Login fehlerhaft. Falsches Passwort!</font>\n";
			}
			echo "</td></tr>\n";
		}
		break;
	case "logout":
		$_SESSION['login'] = false;
		echo "<tr><td colspan=\"2\">\n";
		echo "<font style=\"color: #008b00; font-weight: bold\">Erfolgreich ausgeloggt.</font>\n";
		echo "</td></tr>\n";
		Redirect();
		break;
	case "settings":
		CheckLogin();
		echo "<form action=\"shoutbox.php?p=settings\" method=\"post\" name=\"settings\">\n";
		echo "<tr>\n<td class=\"left\"><b>Titel / Name des G&auml;stebuchs</b></td>\n";
		echo "<td class=\"right\"><input type=\"text\" name=\"title\" size=\"25\" value=\"".$title."\"></td>\n</tr>\n";
		echo "<tr>\n<td class=\"left\"><b>Eintr&auml;ge pro Seite</b></td>\n";
		echo "<td class=\"right\"><input type=\"text\" name=\"entriesPerPage\" size=\"25\" value=\"".$entriesPerPage."\"></td>\n</tr>\n";
		echo "<tr>\n<td class=\"left\"><b>Badword-Filter</b><br><font style=\"font-size: ".$font_size_small."px\">(W&ouml;rter mit Kommas trennen)</font></td>\n";
		echo "<td class=\"right\"><textarea name=\"badWords\" cols=\"22\" rows=\"3\">".$badWords."</textarea></td>\n</tr>\n";
		echo "<tr>\n<td class=\"left\"><b>Breite in Pixel</b></td>\n";
		echo "<td class=\"right\"><input type=\"text\" name=\"width\" size=\"25\" value=\"".$width."\"></td>\n</tr>\n";
		
		echo "<tr><td colspan=\"2\" class=\"left\">Farbe:</td></tr>\n";
		echo "<tr>\n<td class=\"left\"><b>Hintergrund</b></td>\n";
		echo "<td class=\"right\"><input type=\"text\" name=\"color_background\" size=\"25\" value=\"".$color_background."\"></td>\n</tr>\n";
		echo "<tr>\n<td class=\"left\"><b>Hintergrund (Mitte)</b></td>\n";
		echo "<td class=\"right\"><input type=\"text\" name=\"color_background_center\" size=\"25\" value=\"".$color_background_center."\"></td>\n</tr>\n";
		echo "<tr>\n<td class=\"left\"><b>Linke Zellen</b></td>\n";
		echo "<td class=\"right\"><input type=\"text\" name=\"color_cell_left\" size=\"25\" value=\"".$color_cell_left."\"></td>\n</tr>\n";
		echo "<tr>\n<td class=\"left\"><b>Rechte Zellen</b></td>\n";
		echo "<td class=\"right\"><input type=\"text\" name=\"color_cell_right\" size=\"25\" value=\"".$color_cell_right."\"></td>\n</tr>\n";
		
		echo "<tr><td colspan=\"2\" class=\"left\">Schrift:</td></tr>\n";
		echo "<tr>\n<td class=\"left\"><b>Farbe</b></td>\n";
		echo "<td class=\"right\"><input type=\"text\" name=\"font_color\" size=\"25\" value=\"".$font_color."\"></td>\n</tr>\n";
		echo "<tr>\n<td class=\"left\"><b>Art</b><br><font style=\"font-size: ".$font_size_small."px\">(z.B.: Arial, Helvetica, Sans-Serif, Verdana)</font></td>\n";
		echo "<td class=\"right\"><input type=\"text\" name=\"font_family\" size=\"25\" value=\"".$font_family."\"></td>\n</tr>\n";
		echo "<tr>\n<td class=\"left\"><b>Gr&ouml;&szlig;e</b></td>\n";
		echo "<td class=\"right\"><input type=\"text\" name=\"font_size\" size=\"25\" value=\"".$font_size."\"></td>\n</tr>\n";
		
		echo "<tr><td colspan=\"2\" class=\"left\">Link:</td></tr>\n";
		echo "<tr>\n<td class=\"left\"><b>Farbe</b></td>\n";
		echo "<td class=\"right\"><input type=\"text\" name=\"link_color\" size=\"25\" value=\"".$link_color."\"></td>\n</tr>\n";
		echo "<tr>\n<td class=\"left\"><b>Farbe (Hover)</b></td>\n";
		echo "<td class=\"right\"><input type=\"text\" name=\"link_color_hover\" size=\"25\" value=\"".$link_color_hover."\"></td>\n</tr>\n";
		echo "<tr>\n<td class=\"left\"><b>Textdekoration</b></td>\n";
		echo "<td class=\"right\"><select name=\"link_style\" size=\"1\">\n";
		echo "<option value=\"underline\"";if($link_style=="underline")echo" selected";echo">unterstrichen</option>\n";
		echo "<option value=\"overline\"";if($link_style=="overline")echo" selected";echo">&uuml;berstrichen</option>\n";
		echo "<option value=\"line-through\"";if($link_style=="line-through")echo" selected";echo">durchgestrichen</option>\n";
		echo "<option value=\"none\"";if($link_style=="none")echo" selected";echo">keine</option>\n";
		echo "</select></td>\n</tr>\n";
		echo "<tr>\n<td class=\"left\"><b>Textdekoration (Hover)</b></td>\n";
		echo "<td class=\"right\"><select name=\"link_style_hover\" size=\"1\">\n";
		echo "<option value=\"underline\"";if($link_style_hover=="underline")echo" selected";echo">unterstrichen</option>\n";
		echo "<option value=\"overline\"";if($link_style_hover=="overline")echo" selected";echo">&uuml;berstrichen</option>\n";
		echo "<option value=\"line-through\"";if($link_style_hover=="line-through")echo" selected";echo">durchgestrichen</option>\n";
		echo "<option value=\"none\"";if($link_style_hover=="none")echo" selected";echo">keine</option>\n";
		echo "</select></td>\n</tr>\n";
		
		echo "<tr><td colspan=\"2\" class=\"left\">Rahmen:</td></tr>\n";
		echo "<tr>\n<td class=\"left\"><b>Breite</b></td>\n";
		echo "<td class=\"right\"><input type=\"text\" name=\"border_width\" size=\"25\" value=\"".$border_width."\"></td>\n</tr>\n";
		echo "<tr>\n<td class=\"left\"><b>Linienart</b></td>\n";
		echo "<td class=\"right\"><select name=\"border_style\" size=\"1\">\n";
		echo "<option value=\"solid\"";if($border_style=="solid")echo" selected";echo">durchgezogen</option>\n";
		echo "<option value=\"dotted\"";if($border_style=="dotted")echo" selected";echo">gepunktet</option>\n";
		echo "<option value=\"dashed\"";if($border_style=="dashed")echo" selected";echo">gestrichelt</option>\n";
		echo "<option value=\"none\"";if($border_style=="none")echo" selected";echo">keine</option>\n";
		echo "</select></td>\n</tr>\n";
		echo "<tr>\n<td class=\"left\"><b>Farbe</b></td>\n";
		echo "<td class=\"right\"><input type=\"text\" name=\"border_color\" size=\"25\" value=\"".$border_color."\"></td>\n</tr>\n";
			
		echo "<tr><td colspan=\"2\" align=\"center\">\n";
		echo "<input type=\"submit\" name=\"settings_save\" value=\"Einstellungen speichern\"></td></tr>\n";
		echo "</form>\n";
		
		if($_POST['settings_save'])
		{
			$file = "sb_files/data/config.php";
			$input = "<?php\n";
			$input .= "\$adminPass = \"".$adminPass."\";\n";
			$input .= "\$title = \"".$_POST['title']."\";\n";
			$input .= "\$entriesPerPage = ".$_POST['entriesPerPage'].";\n";
			$input .= "\$badWords = \"".$_POST['badWords']."\";\n";
			$input .= "\$width = ".$_POST['width'].";\n";
			$input .= "\$color_background = \"".$_POST['color_background']."\";\n";			
			$input .= "\$color_background_center = \"".$_POST['color_background_center']."\";\n";
			$input .= "\$color_cell_left = \"".$_POST['color_cell_left']."\";\n";
			$input .= "\$color_cell_right = \"".$_POST['color_cell_right']."\";\n";
			$input .= "\$font_color = \"".$_POST['font_color']."\";\n";
			$input .= "\$font_family = \"".$_POST['font_family']."\";\n";
			$input .= "\$font_size = ".$_POST['font_size'].";\n";
			$input .= "\$link_color = \"".$_POST['link_color']."\";\n";
			$input .= "\$link_color_hover = \"".$_POST['link_color_hover']."\";\n";
			$input .= "\$link_style = \"".$_POST['link_style']."\";\n";
			$input .= "\$link_style_hover = \"".$_POST['link_style_hover']."\";\n";
			$input .= "\$border_width = ".$_POST['border_width'].";\n";
			$input .= "\$border_style = \"".$_POST['border_style']."\";\n";
			$input .= "\$border_color = \"".$_POST['border_color']."\";\n";
			$input .= "?>";
			$handle = fopen($file, "w");
			fwrite($handle, $input);
			fclose($handle);
			echo "<script>location.href=\"shoutbox.php?p=settings\";</script>";
		}
		break;
	case "setpassword":
		CheckLogin();
		echo "<form action=\"shoutbox.php?p=setpassword\" method=\"post\" name=\"setpassword\">\n";
		echo "<tr>\n<td class=\"left\"><b>altes Passwort</b></td>\n";
		echo "<td class=\"right\"><input type=\"password\" name=\"password_old\" size=\"25\"></td>\n</tr>\n";
		echo "<tr>\n<td class=\"left\"><b>neues Passwort</b></td>\n";
		echo "<td class=\"right\"><input type=\"password\" name=\"password_new1\" size=\"25\"></td>\n</tr>\n";
		echo "<tr>\n<td class=\"left\"><b>neues Passwort wiederholen</b></td>\n";
		echo "<td class=\"right\"><input type=\"password\" name=\"password_new2\" size=\"25\"></td>\n</tr>\n";
		echo "<tr><td colspan=\"2\" align=\"center\">\n";
		echo "<input type=\"submit\" name=\"password_save\" value=\"Passwort speichern\"></td></tr>\n";
		echo "</form>\n";
		
		if($_POST['password_save'])
		{
			$error = "";
			if($_POST['password_old'] != $adminPass)
				$error .= "&bull; altes Passwort nicht korrekt<br>\n";
			if($_POST['password_new1'] == "")
				$error .= "&bull; kein neues Passwort angegeben<br>\n";
			if($_POST['password_new2'] == "")
				$error .= "&bull; kein neues Passwort (Wiederholung) angegeben<br>\n";
			if($_POST['password_new1'] != $_POST['password_new2'])
				$error .= "&bull; neues Passwort und Wiederholung stimmen nicht &uuml;berein<br>\n";
			if($error == "")
			{
				$file = "sb_files/data/config.php";					
				$input = "<?php\n";
				$input .= "\$adminPass = \"".$_POST['password_new1']."\";\n";
				$input .= "\$title = \"".$title."\";\n";
				$input .= "\$entriesPerPage = ".$entriesPerPage.";\n";
				$input .= "\$badWords = \"".$badWords."\";\n";
				$input .= "\$width = ".$width.";\n";
				$input .= "\$color_background = \"".$color_background."\";\n";
				$input .= "\$color_background_center = \"".$color_background_center."\";\n";
				$input .= "\$color_cell_left = \"".$color_cell_left."\";\n";
				$input .= "\$color_cell_right = \"".$color_cell_right."\";\n";
				$input .= "\$font_color = \"".$font_color."\";\n";
				$input .= "\$font_family = \"".$font_family."\";\n";
				$input .= "\$font_size = ".$font_size.";\n";
				$input .= "\$link_color = \"".$link_color."\";\n";
				$input .= "\$link_color_hover = \"".$link_color_hover."\";\n";
				$input .= "\$link_style = \"".$link_style."\";\n";
				$input .= "\$link_style_hover = \"".$link_style_hover."\";\n";
				$input .= "\$border_width = ".$border_width.";\n";
				$input .= "\$border_style = \"".$border_style."\";\n";
				$input .= "\$border_color = \"".$border_color."\";\n";
				$input .= "?>";
				$handle = fopen($file, "w");
				fwrite($handle, $input);
				fclose($handle);
				echo "<script>location.href=\"shoutbox.php?p=setpassword\";</script>";
			}
			else
			{
				echo "<tr><td colspan=\"2\">\n";
				echo "<font style=\"color: #ff0000; font-weight: bold\">\n".$error."</font><br>\n";
				echo "</td></tr>\n";
			}
		}
		break;
	case "delete":
		CheckLogin();
		if($_GET['index'] != "")
		{
			$entriesDelete = file("sb_files/data/content");
			$entriesDelete[$_GET['index']] = "";
			$fileDelete = fopen("sb_files/data/content", "w");
			fputs($fileDelete, implode("", $entriesDelete));
			fclose($fileDelete);
			if(!isset($_GET['indexPage']))
				echo "<script>location.href=\"shoutbox.php\";</script>";
			else
				echo "<script>location.href=\"shoutbox.php?p=archiv&page=".$_GET['indexPage']."\";</script>";
		}
		break;
	case "deleteall":
		CheckLogin();
		$count = sizeof(file("sb_files/data/content"));
		echo "<form action=\"shoutbox.php?p=deleteall\" method=\"post\" name=\"deleteall\">\n";
		echo "<tr>\n<td colspan=\"2\" align=\"center\" class=\"left\"><b>Alle Eintr&auml;ge der Shoutbox l&ouml;schen?</b></td></tr>\n";
		echo "<tr><td colspan=\"2\" align=\"center\" class=\"right\">\n";
		if($count == 0)
			echo "Keine Eintr&auml;ge vorhanden";
		else
			echo "<input type=\"submit\" name=\"delete_all\" value=\"Alle ".$count." Eintr&auml;ge l&ouml;schen\">\n";
		echo "</td></tr>\n</form>\n";
		if($_POST['delete_all'])
		{
			$file = fopen("sb_files/data/content", "w");
			fclose($file);
			echo "<script>location.href=\"shoutbox.php?p=deleteall\";</script>";
		}
		break;
	case "archiv":
		$file = array_reverse(file("sb_files/data/content"));
		$count = sizeof($file);
		if($count == 0)
			echo "<tr><td colspan=\"2\"><b>Keine Eintr&auml;ge vorhanden</b></td></tr>\n";
		else
		{			
			$pageHTML = "<tr><td colspan=\"2\" style=\"vertical-align: middle; text-align: center\">\n";
			$pages = ceil($count / $entriesPerPage);
			$currentPage = $_GET['page'];
			if(!isset($currentPage))
				$currentPage = 1;
			$pageHTML .= "<span class=\"inverse\">Seite ".$currentPage." von ".$pages."</span>&nbsp;&nbsp;&nbsp;\n";
			if($currentPage - 1 >= 1)
				$pageHTML .= "<a href=\"shoutbox.php?p=archiv&page=1\">1</a>&nbsp;\n";
			if($currentPage > 4)
				$pageHTML .= "<a href=\"shoutbox.php?p=archiv&page=".($currentPage - 1)."\">&laquo;</a>&nbsp;...&nbsp;\n";
			if($currentPage - 2 > 1)
				$pageHTML .= "<a href=\"shoutbox.php?p=archiv&page=".($currentPage - 2)."\">".($currentPage - 2)."</a>&nbsp;\n";
			if($currentPage - 1 > 1)
				$pageHTML .= "<a href=\"shoutbox.php?p=archiv&page=".($currentPage - 1)."\">".($currentPage - 1)."</a>&nbsp;\n";
			$pageHTML .= "<b>".$currentPage."</b>&nbsp;\n";
			if($currentPage + 1 < $pages)
				$pageHTML .= "<a href=\"shoutbox.php?p=archiv&page=".($currentPage + 1)."\">".($currentPage + 1)."</a>&nbsp;\n";
			if($currentPage + 2 < $pages)
				$pageHTML .= "<a href=\"shoutbox.php?p=archiv&page=".($currentPage + 2)."\">".($currentPage + 2)."</a>&nbsp;\n";
			if($currentPage < $pages - 3)
				$pageHTML .= "<a href=\"shoutbox.php?p=archiv&page=".($currentPage + 1)."\">&raquo;</a>&nbsp;...&nbsp;\n";
			if($currentPage + 1 <= $pages)
				$pageHTML .= "<a href=\"shoutbox.php?p=archiv&page=".$pages."\">".$pages."</a>\n";
			$pageHTML .= "</td></tr>\n";
			if($pages > 1)
				echo $pageHTML;
			
			$start = ($currentPage - 1) * $entriesPerPage;
			$end = $currentPage * $entriesPerPage;
			if($end > $count)
				$end = $count;
			for($i = $start; $i < $end; $i++)
			{
				$item = explode("|@|", $file[$i]);
				echo "<tr>\n<td class=\"left\" style=\"border-right: none\">\n";
				if($_SESSION['login']) { echo "<a name=\"".($count - $i - 1)."\"></a>"; }
				echo "#".($count - $i).": <b>".$item[1]."</b>\n</td>\n";
				echo "<td class=\"left\" style=\"text-align: right; border-left: none\">\n";
				echo date("d.m.Y - H:i:s", $item[0])."\n";
				if($_SESSION['login'])
				{
					$indexFile = ($count - $i - 1);
					if(!isset($_GET['page']))
						$_GET['page'] = 1;
					echo "<a href=\"shoutbox.php?p=delete&index=".$indexFile."&indexPage=".$_GET['page']."\">";
					echo "<img src=\"sb_files/images/delete.png\" style=\"vertical-align: middle\" title=\"Eintrag l&ouml;schen\" alt=\"L&ouml;schen\">\n";
				}
				echo "</td>\n</tr>\n";
				echo "<tr>\n<td class=\"right\" colspan=\"2\">\n";
				echo BB_Code($item[4])."</td>\n</tr>\n";
				if($i < $end - 1)
					echo "<tr style=\"height: 10px\"><td colspan=\"2\"></td></tr>\n";
			}
			if($pages > 1)
				echo $pageHTML;
		}
		break;
	default:
		echo "<form action=\"shoutbox.php\" method=\"post\" name=\"inscribe\">\n";
		echo "<tr>\n<td class=\"left\"><b>Name</b></td>\n";
		echo "<td class=\"right\"><input type=\"text\" name=\"name\" size=\"25\" maxlength=\"20\"></td>\n</tr>\n";
		echo "<tr>\n<td class=\"left\"><b>Text</b></td>\n";
		echo "<td class=\"right\"><input type=\"text\" name=\"entry\" size=\"25\" maxlength=\"20\"><br><br>\n";
		echo "<a href=\"javascript:void(0);\" onclick=\"javascript:smilie(' :-)')\"><img src=\"sb_files/smilies/smile.png\" alt=\":-)\"></a>\n";
		echo "<a href=\"javascript:void(0);\" onclick=\"javascript:smilie(' %-(')\"><img src=\"sb_files/smilies/confused.png\" alt=\"%-(\"></a>\n";
		echo "<a href=\"javascript:void(0);\" onclick=\"javascript:smilie(' 8-]')\"><img src=\"sb_files/smilies/in_love.png\" alt=\"8-]\"></a>\n";
		echo "<a href=\"javascript:void(0);\" onclick=\"javascript:smilie(' :-D')\"><img src=\"sb_files/smilies/lol.png\" alt=\":-D\"></a>\n";
		echo "<a href=\"javascript:void(0);\" onclick=\"javascript:smilie(' :-z')\"><img src=\"sb_files/smilies/mad.png\" alt=\":-z\"></a>\n";
		echo "<a href=\"javascript:void(0);\" onclick=\"javascript:smilie(' :-(')\"><img src=\"sb_files/smilies/sad.png\" alt=\":-(\"></a>\n";
		echo "<a href=\"javascript:void(0);\" onclick=\"javascript:smilie(' ;-)')\"><img src=\"sb_files/smilies/winking.png\" alt=\";-)\"></a>\n";
		echo "</td>\n</tr>\n";
		echo "<tr><td colspan=\"2\" align=\"center\">\n";
		echo "<input type=\"submit\" name=\"inscribe\" value=\"Shout\">\n";
		echo "</form><br><br>\n";
		
		if(isset($_POST['inscribe']))
		{
			$error = array(false, false, false);
			if(!preg_match("/^[a-zA-Z0-9äÄüÜöÖß -]{3,}$/", $_POST['name']))
				$error[0] = true;
			$entry = strip_tags($_POST['entry']);
			$entry = str_replace("\\", "", $entry);
			$entry = str_replace("|@|", "", $entry);
			if($entry == "")
				$error[1] = true;
			if($badWords != "")
			{
				$badWordsFound = "";
				$badWordsArray = explode(",", $badWords);
				foreach($badWordsArray as $badword)
				{
					$badword = trim($badword);
					if(eregi($badword, $entry))
						$badWordsFound .= $badword.", ";
				}
				if($badWordsFound != "")
					$error[2] = true;
			}
			if($error[0] || $error[1] || $error[2])
			{
				$errorString = "";
				echo "<tr><td colspan=\"2\">\n";
				echo "<script>\n";
				if($error[0])
				{
					echo "document.inscribe.name.style.backgroundColor = '#FF0000';\n";
					echo "document.inscribe.name.style.color = '#FFFFFF';\n";
					$errorString .= "&bull; Name ist ung&uuml;ltig<br>\n";
				}
				if($error[1])
				{
					echo "document.inscribe.entry.style.backgroundColor = '#FF0000';\n";
					echo "document.inscribe.entry.style.color = '#FFFFFF';\n";
					$errorString .= "&bull; Kein Text geschrieben<br>\n";
				}
				if($error[2])
				{
					echo "document.inscribe.entry.style.backgroundColor = '#FF0000';\n";
					echo "document.inscribe.entry.style.color = '#FFFFFF';\n";
					$errorString .= " &bull; Eintrag enth&auml;lt gesperrte W&ouml;rter: ".$badWordsFound;
				}
				echo "document.inscribe.name.value = '".$_POST['name']."'\n";
				echo "document.inscribe.entry.value = '".$entry."'\n";
				echo "</script>\n";
				echo "<font style=\"color: #ff0000; font-weight: bold\">\n".$errorString."</font><br>\n";
				echo "</td></tr>\n";
			}
			else
			{
				$entry = str_replace("\\r\\n", "<br>", $entry);
				if($_POST['inscribe'])
				{
					$file = "sb_files/data/content";
					$key = time();
					$input = $key."|@|".$_POST['name']."|@|".$_POST['email']."|@|".$_POST['homepage']."|@|".$entry."|@||@|\n";
					$handle = fopen($file, "a");
					fwrite($handle, $input);
					fclose($handle);
					echo "<script>location.href=\"shoutbox.php\";</script>";
				}
			}
		}		
		
		$file = array_reverse(file("sb_files/data/content"));
		$count = sizeof($file);
		if($count == 0)
			echo "<tr><td colspan=\"2\"><b>Keine Eintr&auml;ge vorhanden</b></td></tr>\n";
		else
		{
			if($count < $entriesPerPage)
				$entriesPerPage = $count;
			for($i = 0; $i < $entriesPerPage; $i++)
			{
				$item = explode("|@|", $file[$i]);
				echo "<tr>\n<td class=\"left\" style=\"border-right: none\">\n";
				if($_SESSION['login']) { echo "<a name=\"".($count - $i - 1)."\"></a>"; }
				echo "#".($count - $i).": <b>".$item[1]."</b>\n</td>\n";
				echo "<td class=\"left\" style=\"text-align: right; border-left: none\">\n";
				echo date("d.m.Y - H:i:s", $item[0])."\n";				
				if($_SESSION['login'])
				{
					$indexFile = ($count - $i - 1);
					echo "<a href=\"shoutbox.php?p=delete&index=".$indexFile."\">";
					echo "<img src=\"sb_files/images/delete.png\" style=\"vertical-align: middle\" title=\"Eintrag l&ouml;schen\" alt=\"L&ouml;schen\">\n";
				}
				echo "</td>\n</tr>\n";
				echo "<tr>\n<td class=\"right\" colspan=\"2\">\n";
				echo BB_Code($item[4])."</td>\n</tr>\n";				
				if($i < $entriesPerPage - 1)
					echo "<tr style=\"height: 10px\"><td colspan=\"2\"></td></tr>\n";
			}
		}
		break;
}
echo "</table>\n</td></tr>\n";
echo "<tr><td>\n";
echo "<table width=\"100%\" class=\"none\"><tr><td>\n";
if($_GET['p'] == "")
	echo "<a href=\"shoutbox.php?p=archiv\" style=\"text-decoration: none\"><img src=\"sb_files/images/archiv.png\" style=\"vertical-align: middle\" alt=\"Archiv\">Archiv</a>\n";
else
	echo "<a href=\"shoutbox.php\" style=\"text-decoration: none\"><img src=\"sb_files/images/shoutbox.png\" style=\"vertical-align: middle\" alt=\"Shoutbox\">Shoutbox</a>\n";
echo "</td>\n<td style=\"text-align: right\">";
if($_SESSION['login'])
	echo "<img src=\"sb_files/images/loginok.png\" style=\"vertical-align: middle\" alt=\"Login\"> eingeloggt | <a href=\"shoutbox.php?p=logout\">Logout</a>\n";
else
	echo "<a href=\"shoutbox.php?p=login\" style=\"text-decoration: none\"><img src=\"sb_files/images/login.png\" style=\"vertical-align: middle\" alt=\"Login\">Login</a>\n";
echo "</td></tr></table>\n";
echo "</td></tr>\n";
echo "<tr><td style=\"text-align: center\">\n";
echo "tsShoutbox &copy; <a href=\"http://www.top-side.de\" target=\"_blank\">top-side.de</a>\n</td></tr>\n</table>\n";

echo "</body>\n\n</html>";
?>