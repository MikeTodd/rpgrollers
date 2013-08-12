<?php
	$db=mysql_connect("localhost","digitax0_roller","rollin") or die ("Cannot connect to database"); 
	mysql_select_db("digitax0_rollers") or die ("Cannot select database");
//	mysql_query("UPDATE hits SET hits = hits + 1 WHERE roller = 'exalted'") or die ("Error while updating hits table: " . mysql_error());
?>

<html>
<head>
<title>Exalted Dice Roller</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<SCRIPT LANGUAGE="JavaScript">
<!--

function checkForm(theForm) {
    var why = "";
	if (theForm.character_name.value == "") {
		why += "Name\n";
	}
	if (theForm.character_action.value == "") {
		why += "Action\n";
	}
	if (theForm.pool.value == "") {
		why += "Dice Pool\n";
	}
	
    if (why != "") {
		why = "Error: the following values were not filled in:\n" + why;
       alert(why);
       return false;
    }

	if (theForm.pool.value > 40) {
		alert("Error: Dice Pool too large");
		return false;
	}

return true;
}

function checkForm2(theForm) {
    var why = "";
	if (theForm.character_name.value == "") {
		why += "Name\n";
	}
	
    if (why != "") {
		why = "Error: the following values were not filled in:\n" + why;
       alert(why);
       return false;
    }

	return true;
}
// -->
</SCRIPT>
<link rel="shortcut icon" href="solar.ico" type="image/x-icon" />
</head>

<body bgcolor=#000000 text=#999966 link=#FFFF00 alink=#FFFF99 vlink=#999933>

<form name="rollForm" method="post" action="<?php echo $PHP_SELF; ?>">
  <a href="http://www.white-wolf.com/exalted/index.php?line=intro" target="_blank"><img src="ExaltedLogo.gif" width="300" height="111" border="0"></a><br>
  <table width=100% border=0 cellspacing=2 cellpadding=0>
    <td valign="bottom" width="432"> <table width="417" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="126"> <div align="right"><b>Name:</b></div></td>
            <td colspan="2"> <input type="input" name="character_name" maxlength=20 size = 49 value="<? print(stripslashes(htmlspecialchars($HTTP_POST_VARS['character_name']))); ?>"> 
            </td>
          </tr>
          <tr> 
            <td width="126"> <div align="right"><b>Action:</b></div></td>
            <td colspan="2"> <input type="input" name="character_action" maxlength=25 size = 49 value="<? print(stripslashes(htmlspecialchars($HTTP_POST_VARS['character_action']))); ?>"> 
            </td>
          </tr>
          <tr> 
            <td width="126"> <div align="right"><b>Pool </b>(&lt;40)<b>:</b></div></td>
            <td width="42"> <input type="input" name="pool" maxlength=2 size=3> 
            </td>
            <td width="249"> <div align="right"><b>Difficulty </b>(# of necessary 
                suxx)<b>: </b> 
                <input type="input" name="difficulty" maxlength=2 size=3  value="<? if (isset($_POST['difficulty']) && $_POST['difficulty'] > 1) { print((int)$_POST['difficulty']); }?>">
              </div></td>
          </tr>
          <tr> 
            <td width="126"> <div align="right"><b>Damage Roll?</b> </div></td>
            <td width="42"><input type="checkbox" name="damage_roll"> </td>
            <td width="249"> <div align="right"><b>Target # </b>(standard 7)<b>:</b> 
                <input type="input" name="target_number" maxlength=1 size=3 value="<? print($HTTP_POST_VARS['target_number']); ?>">
              </div></td>
          </tr>
          <tr>
            <td colspan="2"><input type="submit" name="Submit" value="Roll" onClick="return checkForm(rollForm);">
              <input type="submit" name="Submit" value="Initiative" onClick="return checkForm2(rollForm);">
            </td>
            <td><div align="right"><strong>Use willpower</strong>              
              <input type="checkbox" name="used_wp"> 
              </div></td>
          </tr>
          <tr> 
            <td colspan="2"><input type="submit" name="Submit" value="Refresh"> 
            </td>
          </tr>
        </table></td>
    <td width=496 valign="top"> <address>
      <i><font color="Gray" size=2>This page is written and maintained 
      by:</font></i>
      </address>
      <address>
      <font color="Gray"><i><font size=2><a href="mailto:MikeTodd13@hotmail.com?subject=Exalted%20Dice%20Rolling%20Script">Mike 
      Todd</a></font></i></font><font color="Gray" size="2"> </font>
      </address>
      <address>
      <hr>
      <font color="Gray" size=2><i> Please send comments, suggestions, and offers for 
      high paying webmaster jobs to the above email.</i></font>
      </address>
      <address>
      <font size="2" color="Gray"><i>Also check out the <a href="http://www.white-wolf.com/">White 
      Wolf homepage</a></i></font></address></td>
  </table>
</form>
  
<?
	// now, see if rolling or not
	if ($HTTP_POST_VARS["Submit"] == "Roll") {
		// roll, add result to database
		roll($HTTP_POST_VARS);
	} elseif ($HTTP_POST_VARS["Submit"] == "Initiative") {
		// roll, add result to database
		rollInit($HTTP_POST_VARS);
	}
?>

<table width="100%" border="0">
  <tr bgcolor="#000066"> 
    <td width="101" nowrap><strong><font color="white">Date/Time</font></strong></td>
    <td width="310"><strong><font color="white">Description</font></strong></td>
    <td width="*"><strong><font color="white">Result</font></strong></td>
  </tr>
<?
	$rescount = 0;
	$showMax = 30;
	$result=mysql_query("select *, DATE_FORMAT(roll_time, '%Y-%m-%d %H:%i:%s') as roll_time from exalted_roll_info order by roll_id DESC LIMIT 0,$showMax") or die ("Cannot peform SELECT: ".mysql_error());
	
	// show last $showMax rolls
	$count = 0;
	while ($count < $showMax && $row=mysql_fetch_array($result)) {
		$count++;
		if ($count % 2) {
			print "  <tr bgcolor=\"#333333\">\n";
			$odd = false;
		} else {
			print "  <tr bgcolor=\"#111111\">\n";
			$odd = true;
		}
		print '    <td width="101" nowrap><font size="-1">'.$row['roll_time'].'</font></td>';
		print '    <td>'."\n".'      <font size="-1"><font color="#99CCCC">'.htmlspecialchars($row['character_name']).'</font> rolls '.$row['pool'];
		if ($row['pool'] > 1) {
			print ' dice ';
		} else {
			print ' die ';
		}
		
		if ($row['intiative'] == 1) {
			print 'for ';
		} else {
			print 'to ';
		}

		print '<font color="#99CCCC">'.htmlspecialchars($row['character_action']).'</font>';
		$parenAdded = false;
		if ($row['difficulty'] <> 1) {
			print ' (Diff '.$row['difficulty'];
			$parenAdded = true;
		}
		if ($row['target_number'] <> 7) {
			if ($parenAdded == false) {
				print " (target # ";
				$parenAdded = true;
			} else {
				print ", target #";
			}
			print $row['target_number'];
		}
		if ($row['used_wp']) {
			if ($parenAdded == false) {
				print " (used willpower";
				$parenAdded = true;
			} else {
				print ", used willpower";
			}
		}
		if ($row['damage_roll'])	 {
			if ($parenAdded == false) {
				print " (damage roll";
				$parenAdded = true;
			} else {
				print ", damage roll";
			}
		}
		if ($parenAdded == true) {
			print ")";
		}
		print "      </font>\n  </td>\n";
		print "    <td><font size=\"-1\">".printResults($row)."</font></td>\n";
		print "  </tr>\n";
	} /**/
?>
  </font> 
</table>
<?php
//	$result = mysql_query("SELECT hits, DATE_FORMAT(begin_date,'%M %D, %Y') as begin FROM hits WHERE roller = 'exalted'");
//	$hits = mysql_fetch_array($result);
?>
<!-- <p><font color="black">Hits since <?php echo $hits['begin']; ?>: <?php echo $hits['hits']; ?></font></p> /!-->

<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-672956-1";
urchinTracker();
</script>

</body>
</html>

<?
function roll($postVars) {
	cleanupRolls();

	$name = $postVars["character_name"];
	$action = $postVars["character_action"];
	$pool = $postVars["pool"];
	$diff = $postVars["difficulty"];
	if ($diff == "") {
		$diff = 1;
	}
	$target = $postVars['target_number'];
	if ($target == "") {
		$target = 7;
	}
	$dmgRoll = isset($postVars["damage_roll"]) ? 1 : 0;
	$wp = isset($postVars['used_wp']) ? 1 : 0;

	// insert main roll info	
	$insert_roll_info = "INSERT INTO exalted_roll_info
		(character_name, character_action, 
		pool, difficulty, target_number, used_wp, initiative, 
		damage_roll, roll_time, ip)
		VALUES
		('$name', '$action', 
		$pool, $diff, $target, $wp, 0, 
		$dmgRoll, NOW(), '".getenv('REMOTE_ADDR')."')";
	mysql_query($insert_roll_info) or die('Could not insert roll info.  Insert statement was: ' . $insert_roll_info . '<br>MySQL Error: ' . mysql_error());

	// do the roll and insert individual results
	$roll_id = mysql_insert_id();
	srand((int)time());
	for ($diceCount=1; $diceCount<=$pool; $diceCount++) {
		$die = rand(1,10);
		$die_insert = "INSERT INTO exalted_individual_results
			(roll_id, roll_count, roll_result)
			VALUES
			($roll_id, $diceCount, $die)";
		mysql_query($die_insert) or die('Could not insert roll result.  Insert statement was: ' . $die_insert . '<br>MySQL Error: ' . mysql_error());
	}
}

function rollInit($postVars) {
	cleanupRolls();
	
	$name = $postVars["character_name"];
	$action = "initiative";
	$pool = 1;
	$diff = 1;
	$target = 7;
	$dmgRoll = 0;
	$wp = 0;

	// insert main roll info	
	$insert_roll_info = "INSERT INTO exalted_roll_info
		(character_name, character_action, 
		pool, difficulty, target_number, used_wp, initiative, 
		damage_roll, roll_time, ip)
		VALUES
		('$name', '$action', 
		$pool, $diff, $target, $wp, 1, 
		$dmgRoll, NOW(), '".getenv('REMOTE_ADDR')."')";
	mysql_query($insert_roll_info) or die('Could not insert roll info.  Insert statement was: ' . $insert_roll_info . '<br>MySQL Error: ' . mysql_error());

	// do the roll and insert individual results
	$roll_id = mysql_insert_id();
	srand((int)time());
	for ($diceCount=1; $diceCount<=$pool; $diceCount++) {
		$die = rand(1,10);
		$die_insert = "INSERT INTO exalted_individual_results
			(roll_id, roll_count, roll_result)
			VALUES
			($roll_id, $diceCount, $die)";
		mysql_query($die_insert) or die('Could not insert roll result.  Insert statement was: ' . $die_insert . '<br>MySQL Error: ' . mysql_error());
	}
}

function printResults($roll_info) {
	$die_rolls = mysql_query("SELECT * FROM exalted_individual_results WHERE roll_id = '".$roll_info['roll_id']."'") or die('Could not get results: ' . mysql_error());
	$ones = 0;
	$succ = $roll_info['used_wp'] ? 1 : 0;
	$results = "";
	$count = 0;
	
	// go through each die, print results, and tally successes
	while ($result = mysql_fetch_array($die_rolls)) {
		$count++;
		$die = $result['roll_result'];
		if ($die == 1) {
			$ones++;
			$results .= $die;
		} elseif ($die >= $roll_info['target_number']) {
			$succ++;
			$results .= '<font color="#99CCCC">'.$die.'</font>';
			if ($die == 10 && $roll_info['damage_roll'] == 0) {
				$succ++;
			}
		} else {
			$results .= $die;
		}

		if ($count <> $roll_info['pool']) {
			$results .= ',';
		}
		
		if ($count % 5 == 0) {
			$results .= ' ';
		}
	}
	$results .= '&nbsp;&nbsp;';
	
	// now get overall results
	if ($roll_info['initiative']) {
		$results .= '<font color="lightgray">';
		$results .= ' (initiative)';
	} else {
		if ($succ && $succ > $roll_info['difficulty']-1) {
			$succ -= ($roll_info['difficulty'] - 1);
			$results .= '<font color="lightgreen">';
			$results .= ' (' . $succ . ' success';
			if ($succ > 1) $results .= 'es';
			$results .= ')';
		} elseif ($ones && !$roll_info['damage_roll'] && !$succ) {	// can't botch a damage roll
			$results .= '<font color="red">';
			$results .= ' (botch x ' . $ones . ')';
		} else {
			$results .= '<font color="gray">';
			$results .= ' (failure)';
		}
	}
	$results .= '</font>';
	
	return($results);
}

function cleanupRolls($rolls_to_keep = 90) {
	$max_query = mysql_query("SELECT MAX(roll_id) as `max` FROM exalted_roll_info");
	$max_result = mysql_fetch_assoc($max_query);
	$delete_lt = $max_result['max'] - $rolls_to_keep;
	mysql_query("delete from exalted_roll_info WHERE roll_id < $delete_lt");
	mysql_query("delete from exalted_individual_results WHERE roll_id < $delete_lt");
}

?>