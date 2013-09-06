<?php
    // initialize session (starts session if there is none, 
    // or uses currently started session if there is) 
    //session_start();
	$name_action_color = "#99CCCC";

	mysql_pconnect("localhost","digitax0_roller","rollin") or die ("Cannot connect to database"); 
	mysql_select_db("digitax0_rollers") or die ("Cannot select database");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>World of Darkness Dice Roller</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="wod.ico" type="image/x-icon" />
<META name="Keywords" content="dice roller, roleplaying, world of darkness, nwod, wod, mage, werewolf, vampire">
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

	if (theForm.pool.value > 20) {
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
	if (theForm.character_action.value == "") {
		why += "Action\n";
	}

    if (why != "") {
		why = "Error: the following values were not filled in:\n" + why;
       alert(why);
       return false;
    }

	return true;
}

function checkForm3(theForm) {
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
<link rel="shortcut icon" href="wod.ico" type="image/x-icon" />
</head>

<body bgcolor="#000000" text="#8092B3" link="#00FFFF" vlink="#6666FF" alink="#000066">
<?
	// check for spamming
	/*
	if ($HTTP_POST_VARS["Submit"] != "Refresh") {
		$query = "select * from wod2_roll_info where roll_time+20000 > NOW() AND ip='".getenv("REMOTE_ADDR")."'";
		$result = mysql_query($query, $db) or die("Cannot perform query");
		if (mysql_num_rows($result) > 0) {
			exit("Wait a few more seconds to access this page.");
		}
	}
	/**/
?>
<form name="wod2_roll_form" method="post" action="<?php echo $PHP_SELF; ?>">
  <h1>World of Darkness Dice Roller</h1>
  <table width=100% border=0 cellspacing=2 cellpadding=0>
    <td valign="top" width="432"> <table width="417" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="124"> <div align="right"><b>Name:</b></div></td>
            <td colspan="3"> <input type="input" name="character_name" maxlength=20 size = 49 value="<? echo stripslashes(htmlspecialchars($HTTP_POST_VARS['character_name'])); ?>"> 
            </td>
          </tr>
          <tr> 
            <td width="124"> <div align="right"><b>Action:</b></div></td>
            <td colspan="3"> <input type="input" name="character_action" maxlength=25 size = 49 value="<? echo stripslashes(htmlspecialchars($HTTP_POST_VARS['character_action'])); ?>"> 
            </td>
          </tr>
          <tr> 
            <td width="124"> <div align="right"><b>Pool </b>(&lt;20)<b>:</b></div></td>
            <td width="42"> <input type="input" name="pool" maxlength=2 size=3> 
            </td>
            <td colspan="2"> <div align="right"></div></td>
          </tr>
          <tr> 
            <td colspan="2" valign="top"> <div align="right"> </div>
              <p> 
                <input type="submit" name="Submit" value="Roll" onClick="return checkForm(wod2_roll_form);">
                <br>
                <input type="submit" name="Submit" value="Chance Roll" onClick="return checkForm3(wod2_roll_form);">                
                <br>
                <input type="submit" name="Submit" value="Initiative" onClick="return checkForm3(wod2_roll_form);">
                <font size="-7"><br>
                <br>
                </font> 
                <input type="submit" name="Submit" value="Refresh">
              </p></td>
            <td width="100" valign="top">
			  <div align="right"><strong>
			      No rerolls <input type="radio" name="reroll_floor" value="11">&nbsp;<br>
                  10-again <input type="radio" name="reroll_floor" value="10" checked>&nbsp;<br>
                  9-again <input type="radio" name="reroll_floor" value="9">&nbsp;<br>
                  8-again <input type="radio" name="reroll_floor" value="8">&nbsp;
           	  </strong></div>
			</td>
            <td width="151" valign="top">
			  <div align="right"><strong>
				  Use wp <input type="checkbox" name="used_wp" value="1">&nbsp;<br>
                  Rote action <input type="checkbox" name="rote_action" value="1">&nbsp;<br>
				  1s subtract <input type="checkbox" name="ones_subtract" value="1">&nbsp;<br>
				  <s>Advanced action</s>			    <input type="checkbox" name="advanced_action" value="1">&nbsp;
           	  </strong></div>
			</td>
          </tr>
        </table></td>
    <td width=496 valign="top"> <address>
        <i><font color="Gray" size=2>This page is written and maintained by</font></i> 
        <font color="Gray"><i><font size=2><a href="http://umbralechoes.com/contact-me.php"><font size="3">Mike 
        Todd</font></a></font></i></font><font color="Gray" size="2"> (plays <font color="#CCCCCC"><a href="http://sammael.umbralechoes.com/">Sammael</a></font> on the unmods)</font>
    </address>
      <address>
      <hr>
      <font color="Gray" size=2><i> Please send comments, suggestions, and offers 
      for high paying webmaster jobs to the above email.</i></font> 
      </address>
      <address>
      <font size="2" color="Gray"><i>Also check out the <a href="http://www.white-wolf.com/" target="_blank">White 
      Wolf homepage</a></i></font></address>
	  <hr>
	  <font size="2" color="Gray">Results in <font color="lightgreen">green</font> indicate a success. <br>
	  Results in <strong>bold</strong> indicate dice rerolled due to 10-again, 9-again, or 8-again.<br>
	  Results <s>crossed out</s> indicate results rerolled due to the Rote Action effect.</font></td>
  </table>
</form>
<?
	// now, see if rolling or not
	if ($HTTP_POST_VARS["Submit"] == "Roll") {
		// roll, add result to database
		roll($HTTP_POST_VARS);
	} elseif ($HTTP_POST_VARS["Submit"] == "Chance Roll") {
		// roll, add result to database
		roll_chance($HTTP_POST_VARS);
	} elseif ($HTTP_POST_VARS["Submit"] == "Initiative") {
		// roll, add result to database
		roll_init($HTTP_POST_VARS);
	}
?>

<table width="100%" border="0">
  <tr bgcolor="#000066"> 
    <td width="*" nowrap><strong><font color="white">Date/Time</font></strong></td>
    <td width="*"><strong><font color="white">Roll description</font></strong></td>
    <td width="*"><strong><font color="white">Result</font></strong></td>
  </tr>
<?
	$rescount = 0;
	if ((int)$_GET['show_roll'] == 0) {
		$result=mysql_query("select *, DATE_FORMAT(roll_time, '%Y-%m-%d %H:%i:%s') as roll_time 
				FROM wod2_roll_info
				ORDER BY roll_id DESC limit 0,50")
			or die ("Cannot peform SELECT: ".mysql_error());
	} else {
		$result=mysql_query("select *, DATE_FORMAT(roll_time, '%Y-%m-%d %H:%i:%s') as roll_time from wod2_roll_info
			WHERE roll_id BETWEEN ".((int)$_GET['show_roll']-10)." AND ".((int)$_GET['show_roll']+10)."
			order by roll_id DESC limit 0,50")
			or die ("Cannot peform SELECT: ".mysql_error());

	}
	// show last 30 rolls
	$count = 0;
	while ($count < 30 && $row=mysql_fetch_array($result)) {
		$count++;
		// If user looked up individual roll, highlight it
		if ((int)$_GET['show_roll'] > 0 && $row["roll_id"] == (int)$_GET['show_roll']) {
			print "<tr bgcolor=\"#153515\">\n";
			$odd = !$odd;
		}
		// keep track of even and odd rows; switch background color
		elseif ($count % 2) {
			print "<tr bgcolor=\"#15151A\">\n";
			$odd = false;
		} else {
			print "<tr bgcolor=\"#0C0C0F\">\n";
			$odd = true;
		}

		print '<td width="101" nowrap><font size="-1">'.$row['roll_time'].'</font></td>';
		print '<td><font size="-1"><font color="'.$name_action_color.'">'.$row['character_name'].'</font> rolls '.$row['pool'];
		if ($row['pool'] > 1) {
			print ' dice ';
		} else {
			print ' die ';
		}
		
		if ($row['initiative'] == 1) {
			print 'for ';
		} else {
			print 'to ';
		}

		print '<font color="'.$name_action_color.'">'.$row['character_action'].'</font>';
		$paren_added = false;
		// roll-agains
		if ($row['reroll_floor'] < 9) {
			print ' (8-again';
			$paren_added = true;
		}
		if ($row['reroll_floor'] < 10) {
			if ($paren_added) {
				echo ', 9-again';
			} else {
				echo ' (9-again';
				$paren_added = true;
			}
		}
		if ($row['reroll_floor'] > 10 && !$row['initiative']) {	// don't even reroll 10s again
			if ($paren_added) {
				echo ', no rerolls';
			} else {
				echo ' (no rerolls';
				$paren_added = true;
			}
		}
		
		// ones subtract?
		if ($row['ones_subtract'] == 1) {
			if ($paren_added) {
				print ', 1s subtract';
			} else {
				print ' (1s subtract';
				$paren_added = true;
			}
		}

		// rote action?
		if ($row['chance_roll'] == 1) {
			if ($paren_added) {
				print ', chance roll';
			} else {
				print ' (chance roll';
				$paren_added = true;
			}
		}
		
		// used wp?
		if ($row['used_wp'] == 1) {
			if ($paren_added) {
				print ', used willpower';
			} else {
				print ' (used willpower';
				$paren_added = true;
			}
		}
		
		// rote action?
		if ($row['rote_action'] == 1) {
			if ($paren_added) {
				print ', rote action';
			} else {
				print ' (rote action';
				$paren_added = true;
			}
		}
		
		// advanced action?
		if ($row['advanced_action'] == 1) {
			if ($paren_added) {
				print ', advanced action';
			} else {
				print ' (advanced action';
				$paren_added = true;
			}
		}
		
		if ($paren_added == true) {
			print ')';
		}

		print "</font></td>\n";
		print "<td><font size=\"-1\">";
		// now print individual results
		print_results($row);
		print "</font></td>\n";
		print "</tr>";
	}
?>
  </font> 
</table>
<?php
	$result = mysql_query("SELECT hits, DATE_FORMAT(begin_date,'%M %D, %Y') as begin FROM hits WHERE roller = 'wod2'");
	$hits = mysql_fetch_array($result);
?>
<p><font color="black">Hits since <?php echo $hits['begin']; ?>: <?php echo $hits['hits']; ?></font></p>

<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-672956-1";
urchinTracker();
</script>

</body>
</html>

<?
/************** PERFORM ROLL **************/
function roll($postVars) {
	if (isset($postVars['used_wp'])) {
		$postVars["pool"] += 3;
	}

	// Clean up outdated results
	cleanupRolls();
	
	// do the roll
	srand((int)time());

	// post results to the database
	$statement = "INSERT INTO digitax0_rollers.wod2_roll_info
		(roll_time, character_name, character_action, 
		ip_address, pool, initiative, reroll_floor, used_wp, 
		ones_subtract, chance_roll, rote_action, advanced_action
		) values (".
	    "NOW(), '".htmlentities($postVars['character_name'],ENT_QUOTES)."', '".
		htmlentities($postVars['character_action'],ENT_QUOTES)."', '".
		getenv("REMOTE_ADDR")."', ".
		$postVars["pool"].", 0, ".
		$postVars["reroll_floor"].", ";
	if (isset($postVars['used_wp'])) {
		$statement .= "1, ";
	} else {
		$statement .= "0, ";
	}
	if (isset($postVars['ones_subtract'])) {
		$statement .= "1, ";
	} else {
		$statement .= "0, ";
	}
	$statement .= "0, ";	// chance roll
	if (isset($postVars['rote_action'])) {
		$statement .= "1, ";
	} else {
		$statement .= "0, ";
	}
	if (isset($postVars['advanced_action'])) {
		$statement .= "1)";
	} else {
		$statement .= "0)";
	}

	$result = mysql_query($statement) or die ("Cannot peform INSERT; statement was: $statement<br><br>Error was:".mysql_error());
	$roll_id = mysql_insert_id();

	$trueCount = 1;
	$rote_reroll = false;
	for ($i=0; $i < $postVars['pool']; $i++) {
		$die = rand(1,10);
		$result = mysql_query("INSERT INTO wod2_individual_results VALUES (".$roll_id.", ".$trueCount.", ".$die.")") or die ("Cannot peform INSERT; Error:".mysql_error());
		if ($die >= $postVars['reroll_floor']) {
			$i--;
		}
		
		if ($die < 8) {
			if (!$rote_reroll && $postVars['rote_action']) {
				if ($die < $postVars['reroll_floor']) {
					$i--;	// in case we already decremented, above
				}
				$rote_reroll = true;
			} elseif ($rote_reroll) {
				$rote_reroll = false;
			}
		} else {
			$rote_reroll = false;
		}
		
		$trueCount++;
	}
}

function cleanupRolls($rolls_to_keep = 90) {
	$max_query = mysql_query("SELECT MAX(roll_id) as `max` FROM wod2_roll_info");
	$max_result = mysql_fetch_assoc($max_query);
	$delete_lt = $max_result['max'] - $rolls_to_keep;
	mysql_query("delete from wod2_roll_info WHERE roll_id < $delete_lt");
	mysql_query("delete from wod2_individual_results WHERE roll_id < $delete_lt");
} 

function roll_init($postVars) {
	$postVars['pool'] = 1;
	
	// do the roll
	srand((int)time());

	// post results to the database
	$statement = "INSERT INTO digitax0_rollers.wod2_roll_info
		(roll_time, character_name, character_action, 
		ip_address, pool, initiative, reroll_floor, used_wp, 
		ones_subtract, chance_roll, rote_action, advanced_action
		) values (".
	    "NOW(), '".htmlentities($postVars['character_name'],ENT_QUOTES)."', 'initiative', '".
		getenv("REMOTE_ADDR")."', ".
		$postVars["pool"].", 1, 11, 0, 0, 0, 0, 0)";
	$result = mysql_query($statement) or die ("Cannot peform INSERT; statement was:<br>".nl2br($statement)."<br><br>Error was:".mysql_error());
	$roll_id = mysql_insert_id();

	$die = rand(1,10);
	$result = mysql_query("INSERT INTO wod2_individual_results VALUES (".$roll_id.", 1, ".$die.")") or die ("Cannot peform INSERT; Error:".mysql_error());
}

function roll_chance($postVars) {
	$postVars["pool"] = 1;
	$postVars["reroll_floor"] = 10;
	
	// do the roll
	srand((int)time());

	// post results to the database
	$statement = "INSERT INTO rollers.wod2_roll_info
		(roll_time, character_name, character_action, 
		ip_address, pool, initiative, reroll_floor, used_wp, 
		ones_subtract, chance_roll, rote_action, advanced_action
		) values (".
	    "NOW(), '".htmlentities($postVars['character_name'],ENT_QUOTES)."', '".
		htmlentities($postVars['character_action'],ENT_QUOTES)."', '".
		getenv("REMOTE_ADDR")."', ".
		$postVars["pool"].", 0, ".
		$postVars["reroll_floor"].", ";
	if (isset($postVars['used_wp'])) {
		$statement .= "1, ";
	} else {
		$statement .= "0, ";
	}
	if (isset($postVars['ones_subtract'])) {
		$statement .= "1, ";
	} else {
		$statement .= "0, ";
	}
	$statement .= "1, ";	// chance roll
	if (isset($postVars['rote_action'])) {
		$statement .= "1, ";
	} else {
		$statement .= "0, ";
	}
	if (isset($postVars['advanced_action'])) {
		$statement .= "1)";
	} else {
		$statement .= "0)";
	}

	$result = mysql_query($statement) or die ("Cannot peform INSERT; statement was: $statement<br><br>Error was:".mysql_error());
	$roll_id = mysql_insert_id();

	$trueCount = 1;
	$rote_reroll = false;
	for ($i=0; $i < $postVars['pool']; $i++) {
		$die = rand(1,10);
		$result = mysql_query("INSERT INTO wod2_individual_results VALUES (".$roll_id.", ".$trueCount.", ".$die.")") or die ("Cannot peform INSERT; Error:".mysql_error());
		if ($die >= $postVars['reroll_floor']) {
			$i--;
		}
		
		if ($die < 10) {
			if (!$rote_reroll && $postVars['rote_action']) {
				if ($die < $postVars['reroll_floor']) {
					$i--;	// in case we already decremented, above
				}
				$rote_reroll = true;
			} elseif ($rote_reroll) {
				$rote_reroll = false;
			}
		} else {
			$rote_reroll = false;
		}
		
		$trueCount++;
	}
}

/************** PRINT ROLL RESULTS **************/
function print_results($roll_info) {
	$resultset = mysql_query("SELECT * FROM wod2_individual_results WHERE roll_id = ".$roll_info["roll_id"]." ORDER BY roll_count");
	$diceTotal = mysql_num_rows($resultset);	// total number of dice actually rolled
	$target = ($roll_info['chance_roll'] == 1) ? 10 : 8;
	$inRoteReroll = false;
	$inTensReroll = false;
	$succ = 0;
	$ones = 0;

	echo '<font color="grey">';
	while ($die = mysql_fetch_array($resultset)) {
		if ($inTensReroll) {
			echo "<b>";
		}
		if ($die['result'] < $target && !$inRoteReroll && $roll_info['rote_action']) {
			echo "<s>";
		} elseif ($die['result'] >= $target) {
			echo '<font color="lightgreen">';
		}
		print($die['result']);
		if ($die['result'] < $target && !$inRoteReroll && $roll_info['rote_action']) {
			echo "</s>";
		} elseif ($die['result'] >= $target) {
			echo "</font>";
		}
		if ($inTensReroll) {
			echo "</b>";
		}

		if ($die["roll_count"] != $diceTotal) {
			print ",";
			if ($die["roll_count"] % 5 == 0) print " ";
		}
		
		if ($die['result'] >= $target) {
			$succ++;
		}
		
		if ($die['result'] < $target && !$inRoteReroll && $roll_info['rote_action']) {
			$inRoteReroll = true;
		} else {
			$inRoteReroll = false;
		}

		if ($die['result'] == 1 && !$inRoteReroll) {
			$ones++;
		}
		
		if (!$inTensReroll || !$inRoteReroll) {
			$inTensReroll = ($die['result'] >= $roll_info['reroll_floor']);
		}
	}
	echo "</font>";
	
	print '<font color="white">';
	
	// Subtract ones if necessary
	if ($roll_info['ones_subtract']) {
		$succ -= $ones;
	}
	if ($succ < 0) {
		$succ = 0;
	}
	
	// Display results
	echo " (<a href='".$PHP_SELF."?show_roll={$roll_info["roll_id"]}'>";  // Link to this roll 
	if ($roll_info['chance_roll'] && $succ < 0 && $ones) {
		echo "CRITICAL FAILURE)";
	} elseif ($roll_info['initiative']) {
		echo "initiative roll";
	} else {
		echo "$succ success";
		if ($succ != 1) echo "es";
	}
	echo "</a>)";
	echo "</font>";

	mysql_free_result($resultset);
}

function ts14tostring($ts) {
	if (substr($ts,0,4) == "0000") {
		return "never";
	} else {
		$time = mktime(substr($ts,8,2),substr($ts,10,2),substr($ts,12,2),
					   substr($ts,4,2),substr($ts,6,2),substr($ts,0,4));
		return date("m-d-Y H:i:s", $time);
	}
}

?>