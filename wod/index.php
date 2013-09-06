<?php
	define(DB_LOGIN, "digitax0_roller");
	define(DB_PASSWORD, "rollin");
	define(ROLL_DB, "digitax0_woddice");
	/**
	MODIFICATIONS
	2003-11-28 -- Added Threshold
	2005-02-27 -- Added hit counter
	**/

	//exit("Just reinstalled server; working on getting this page back up.  Check back soon!");
	
	mysql_connect("localhost",DB_LOGIN,DB_PASSWORD) or die ("Cannot connect to database<br>" . mysql_error()); 
	mysql_select_db(ROLL_DB) or die ("Cannot select database<br>" . mysql_error());
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Old World of Darkness Dice Roller</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="owod.ico" type="image/x-icon" />
<META name="Keywords" content="dice roller, roleplaying, world of darkness, wod, owod, cwod, mage, werewolf, vampire">
<SCRIPT LANGUAGE="JavaScript">
<!--
// Makes sure all appropriate values were filled in
function checkForm(theForm) {
    var why = "";
	if (theForm.NameField.value == "") {
		why += "Name\n";
	}
	if (theForm.ActionField.value == "") {
		why += "Action\n";
	}
	if (theForm.PoolField.value == "") {
		why += "Dice Pool\n";
	}
	
    if (why != "") {
		why = "Error: the following values were not filled in:\n" + why;
       alert(why);
       return false;
    }

	if (theForm.PoolField.value > 20) {
		alert("Error: Dice Pool too large");
		return false;
	}

return true;
}

function checkForm2(theForm) {
    var why = "";
	if (theForm.NameField.value == "") {
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
<link rel="shortcut icon" href="owod.ico" type="image/x-icon" />
<style type="text/css">
<!--
.style1 {
	color: #000000;
	font-weight: bold;
}
.style3 {font-weight: bold}
-->
</style>
</head>

<body bgcolor="#000000" text="#CCCCFF" link="#FFFFFF" vlink="#EEEEFF" alink="#000066" leftmargin="0" rightmargin="0" topmargin="0">
<form name="rollForm" method="post" action="<?php echo $PHP_SELF; ?>">
  <p align="center"><div style="font-size:small" align="center">
    <p><img src="WoDRoller.gif" width="658" height="49"><br>
      (Check out a roller for the new World of Darkness <a href="/nwod/">here</a>!)</p>
    </div>
  </p>
  <table width=100% border=0 cellspacing=2 cellpadding=0>
  <td valign="bottom" width="432"><table width="417" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="126"><div align="right"><b>Name:</b></div></td>
      <td colspan="3"><input type="input" name="NameField" maxlength=20 size = 49 value="<?php print(stripslashes(htmlspecialchars($NameField))); ?>">
      </td>
    </tr>
    <tr>
      <td width="126"><div align="right"><b>Action:</b></div></td>
      <td colspan="3"><input type="input" name="ActionField" maxlength=25 size = 49 value="<?php print(stripslashes(htmlspecialchars($ActionField))); ?>">
      </td>
    </tr>
    <tr>
      <td width="126"><div align="right"><b>Pool </b>(<u>&lt;</u>20)<b>:</b></div></td>
      <td width="42"><input type="input" name="PoolField" maxlength=2 size=3>
      </td>
      <td width="249" colspan="2"><div align="right"><b>Difficulty</b> (default 6):<b> </b>
                  <input type="input" name="DiffField" maxlength=2 size=3  value="<?php print($DiffField); ?>">
      </div></td>
    </tr>
    <tr>
      <td colspan="2" rowspan="2" valign="top"><div align="right"> </div>
              <p>
                <input type="submit" name="Button" value="Roll" onClick="return checkForm(rollForm);">
                <input type="submit" name="Button3" value="Initiative" onClick="return checkForm2(rollForm);">
                <font size="-7"><br>
                <br>
                </font>
                <input type="submit" name="Button2" value="Refresh">
            </p></td>
      <td width="124"><div align="right"><strong>Use Willpower
        <input type="checkbox" name="UseWPField" value="1">
      </strong></div></td>
      <td width="125"><div align="right"><b>Reroll 10s:</b><b></b>
                  <input type="checkbox" name="RerollTensField" value="1" <?php if ($HTTP_POST_VARS["RerollTensField"]=="1") print "checked"; ?>>
      </div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="left"><strong>Rules set</strong>: <br>
                  <?php
		  		// Print the different rules sets with appropriate colors
		  		$result=mysql_query("select * from rulessets rs, colorschemes cs where rs.RulesSet = cs.RulesSet") or die ("Cannot peform SELECT: ".mysql_error());
				while($row=mysql_fetch_array($result)) {
			  ?>
                  <label>
                  <input type="radio" name="RulesSet" value="<?php print($row["RulesSet"]); ?>" <?php
					// check this one if it was the last one used, or the first option if first visit
					if ($row["RulesSet"]==$HTTP_POST_VARS["RulesSet"] || $HTTP_POST_VARS["RulesSet"]=="") {
						print("checked"); $checked=1;
						$HTTP_POST_VARS["RulesSet"] = $row["RulesSet"];
					} ?>>
                  <font color="<?php print($row["PrimaryColor"]); ?>"><?php print($row["Description"]); ?></font></label>
                  <br>
                  <?php
		  		}
		  ?>
      </div>
         <font color="Gray" size=2><i>What's the difference in the rules sets? Click <a href="woddice-diffs.php" target="_blank">here</a> to find out.</i></font>
      </td>
    </tr>
  </table></td>
      <td width=496 valign="top">
	    <b>If you would like to play in an unmoderated White Wolf game, I have set up a chat <a href="http://unmodchat.com/"><font color="#FFFFFF"><b>here</b></font></a>.</b><br />
	    <address>
        <i><font color="Gray" size=2>This page is written and maintained by</font></i> <font color="Gray"><i><font size=2><a href="http://umbralechoes.com/contact-me.php"><font size="3">Mike 
          Todd</font></a></font></i></font><font color="Gray" size="2"> (plays <font color="#CCCCCC"><a href="http://sammael.umbralechoes.com/">Sammael</a></font> on the unmods)
            </font>
        </address>
          <address>
          <hr>
          <font color="Gray" size=2><i> Please send comments, suggestions, and offers 
            for high paying webmaster jobs to the above email.</i></font>
                    </address>
        <address>
        <font size="2" color="Gray"><i>Also check out the <a href="http://www.white-wolf.com/">White 
        Wolf homepage</a></i></font>
                                </address></td>
  </table>
  <table width="100%" border="0">
    <tr>
      <td valign="top"><?php
	// now, see if rolling or not
	if ($HTTP_POST_VARS["Button"] == "Roll") {
		// roll, add result to database
		roll($HTTP_POST_VARS, getenv("REMOTE_ADDR"));
	} elseif ($HTTP_POST_VARS["Button3"] == "Initiative") {
		// roll, add result to database
		rollInit($HTTP_POST_VARS, getenv("REMOTE_ADDR"));
	}
?>
<table width="100%" border="0">
          <tr bgcolor="#000066">
            <td width="*" nowrap><strong><font color="#DDEEEE">Date/Time</font></strong></td>
            <td width="*"><strong><font color="#DDEEEE">Description</font></strong></td>
            <td width="*"><strong><font color="#DDEEEE">Result</font></strong></td>
          </tr>
<?php
	$rescount = 0;
	if ($_GET['show_roll'] == '') {
		$result=mysql_query("select *, DATE_FORMAT(RollTime, '%Y-%m-%d %H:%i:%s') as RollTime from mainroll m, rulessets r, colorschemes c where m.RulesSet=r.RulesSet and r.RulesSet=c.RulesSet order by RollID DESC limit 0,50")
			or die ("Cannot peform SELECT: ".mysql_error());
	} else {
		$result=mysql_query("select *, DATE_FORMAT(RollTime, '%Y-%m-%d %H:%i:%s') as RollTime from mainroll m, rulessets r, colorschemes c
			WHERE m.RulesSet=r.RulesSet and r.RulesSet=c.RulesSet
			  AND RollID BETWEEN ".((int)$_GET['show_roll']-10)." AND ".((int)$_GET['show_roll']+10)."
			order by RollID DESC limit 0,50")
			or die ("Cannot peform SELECT: ".mysql_error());
	}
	
	// show last 30 rolls
	$count = 0;
	while ($count < 30 && $row=mysql_fetch_array($result)) {
		$count++;

		// If user looked up individual roll, highlight it
		if ((int)$_GET['show_roll'] > 0 && $row["RollID"] == (int)$_GET['show_roll']) {
			print "<tr bgcolor=\"#153515\">\n";
			$odd = !$odd;
		}
		// keep track of even and odd rows; switch background color
		elseif ($count % 2) {
			print "<tr bgcolor=\"#151515\">\n";
			$odd = false;
		} else {
			print "<tr bgcolor=\"#0A0A0A\">\n";
			$odd = true;
		}

		print '<td width="101" nowrap><font size="-1">'.$row["RollTime"].'</font></td>';
		print '<td><font size="-1"><font color="#99CCCC">'.$row["CharName"].'</font> rolls '.$row["Pool"];
		if ($row["Pool"] > 1) {
			print ' dice ';
		} else {
			print ' die ';
		}
		
		if ($row["Initiative"] == 1) {
			print 'for ';
		} else {
			print 'to ';
		}

		print '<font color="#99CCCC">'.$row["Action"].'</font>';
		$parenAdded = false;
		// Difficulty
		if ($row["Diff"] <> 6 && $row["Initiative"]!=1) {
			print ' (Diff ';
			// Threshold?
			if ($row["Diff"] > 10) {
			    if ($row["RulesSet"]==2)
					print '9';
				else
					print '10';
			} else {
				print $row["Diff"];
			}
			$parenAdded = true;
		}
		// Threshold
		if ($row["Diff"] > 10 && $row["RulesSet"]==2 && $row["Initiative"]!=1) {
			if ($parenAdded) {
				print ', threshold '.($row["Diff"]-9);
			} else {
				print '(threshold '.($row["Diff"]-9);
				$parenAdded = true;
			}
		}
		if ($row["UseWP"] == 1) {
			if ($parenAdded) {
				print ', used willpower';
			} else {
				print ' (used willpower';
				$parenAdded = true;
			}
		}
		if ($parenAdded == true) {
			print ')';
		}

		print "</font></td>\n";
		print "<td><font size=\"-1\">";
		// now print individual results
		printResults($row);
		print "</font></td>\n";
		print "</tr>";
	} /**/
	
	// Clean up old rolls
	cleanupRolls();
?>
  </font>
  
        </table>
<?php
//	$hide_counter = true;
//	include('counter.php');
//	$result = mysql_query("SELECT count(*) as hits FROM digitax0_woddice.mainroll WHERE date_add(RollTime, INTERVAL 30 DAY) > NOW()");
//	$hits = mysql_fetch_array($result);
?></td>
<?php if (false) { ?>
      <td width="130" valign="top">&nbsp;
<script type="text/javascript"><!--
google_ad_client = "pub-8264504009346974";
google_ad_width = 120;
google_ad_height = 600;
google_ad_format = "120x600_as";
google_ad_type = "text_image";
google_ad_channel ="0467680314";
google_color_border = "6699CC";
google_color_bg = "003366";
google_color_link = "FFFFFF";
google_color_text = "AECCEB";
google_color_url = "AECCEB";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>	  </td>
<?php } ?>
    </tr>
  </table>
</form>

<!--
<p><font color="black">Rolls in past 30 days: <?php echo $hits['hits']; ?></font></p>
/!-->
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-672956-1";
urchinTracker();
</script>

</body>
</html>

<?php
function roll($postVars, $IP) {
	if ($_POST["DiffField"] == "") {
		$postVars["DiffField"] = 6;
	} elseif ($_POST["DiffField"] < 2) {
		$postVars["DiffField"] = 2;
	}

	// do the roll
	srand((int)time());

	// post results to the database
	$statement = "INSERT INTO mainroll (RollTime, CharName, Action, Pool, Diff, RerollTens, RulesSet, ".
		"Initiative, IP, UseWP) values ".
	    "(NOW(), '".htmlentities($postVars["NameField"],ENT_QUOTES)."', '".
		htmlentities($postVars["ActionField"],ENT_QUOTES)."', ".$postVars["PoolField"].", ".$postVars["DiffField"].", ";
	if ($postVars["RerollTensField"]=="1") {
		$statement .= "1, ";
	} else {
		$statement .= "0, ";
	}
	$statement .= $postVars["RulesSet"].", 0, '".getenv("REMOTE_ADDR")."', ";
	if ($_POST["UseWPField"]=="1") {
		$statement .= "1)";
	} else {
		$statement .= "0)";
	}

	$result = mysql_query($statement) or die ("Cannot peform INSERT; statement was: $statement<br><br>Error was:".mysql_error());
	$insertId = mysql_insert_id();

	$rules=mysql_query("select * from rulessets r where r.RulesSet=".$postVars["RulesSet"])
		or die ("Cannot peform SELECT: ".mysql_error());
	$rulesArr = mysql_fetch_array($rules);

	$inSpec = 0;
	$trueCount = 1;
	for ($i=0; $i < $postVars["PoolField"]; $i++) {
		$die = rand(1,10);
		$result = mysql_query("insert into rolls values (".$insertId.", ".$die.", ".$trueCount.")") or die ("Cannot peform INSERT; Error:".mysql_error());
		if ($die == 10) {
			// reroll 10 only if rolling spec, and: recursive OR non-rec and not already in spec reroll
			if ($postVars["RerollTensField"]=="1" &&
				($rulesArr["RecursiveReroll"]==1 || ($rulesArr["RecursiveReroll"]==0 && $inSpec==0))) {
				$inSpec = 1;
				$i--;
			} else {
				$inSpec = 0;
			}
		}
		else {
			$inSpec = 0;
		}
		$trueCount++;
	}
}

function rollInit($postVars, $IP) {
	// do the roll
	srand((int)time());
	$die = rand(1,10);

	// post results to the database
	$statement = "INSERT INTO mainroll (RollTime, CharName, Action, Pool, Diff, RerollTens, RulesSet, ".
		"Initiative, IP, UseWP) values ".
	    "(NOW(), '".htmlentities($postVars["NameField"],ENT_QUOTES)."', 'Initiative', 1, 11, ";
	if ($postVars["RerollTensField"]=="1") {
		$statement .= "1, ";
	} else {
		$statement .= "0, ";
	}
	$statement .= $postVars["RulesSet"].", 1, '".getenv("REMOTE_ADDR")."', 0)";

	$result = mysql_query($statement) or die ("Cannot peform INSERT; statement was: $statement<br><br>Error was:".mysql_error());
	$result = mysql_query("insert into rolls values (".mysql_insert_id().", ".$die.", "."1)") or die ("Cannot peform INSERT; Error:".mysql_error());
}

function printResults($main) {
	$resultset = mysql_query("select * from rolls where RollID=".$main["RollID"]." ORDER BY Count");
	$diceTotal = mysql_num_rows($resultset);	// total number of dice actually rolled
	$count = 0;
	$inSpec = 0;
	$succ = 0;
	$thresh = 0;
	if ($main["UseWP"]==1) {
		$succ = 1;
	}
	
	// Implement Threshold, for Mage
	if ($main["Diff"] > 10 && $main["RulesSet"] == 2) {
		$thresh = $main["Diff"] - 9;
		$main["Diff"] = 9;
	}
	
	$ones = 0;
	print("<font color=".$main["PrimaryColor"].">");
	while ($die = mysql_fetch_array($resultset)) {
		if ($inSpec == 1) {
			print("<font color=".$main["RerolledTens"].">");
		}
		print($die["Result"]);
		if ($inSpec == 1) {
			print("</font>");
		}
		$count++;
		if ($die["Count"] != $diceTotal) {
			print ",";
			if ($die["Count"] % 5 == 0) print " ";
		}
		
		// tally successes
		if ($die["Result"]==1) {
			// add to onesCount, except if it's a spec reroll and 1s on spec reroll don't count
			if ($inSpec <> 1 || $main["RerolledOnesCount"]) {
				$ones++;
			}
			$inSpec = 0;
		}
		elseif ($die["Result"] == 10) {
			$succ++;
			// reroll 10 only if rolling spec, and: recursive OR non-rec and not already in spec reroll
			if ($main["RerollTens"] &&
				($main["RecursiveReroll"]==1 || ($main["RecursiveReroll"]==0 && $inSpec==0))) {
				$inSpec = 1;
				$count--;
			} else {
				$inSpec = 0;
			}
		}
		elseif ($die["Result"] >= $main["Diff"]) {
			$succ++;
			$inSpec = 0;
		} else {
			$inSpec = 0;
		}
	}
	
	print "<font color=CCCCCC><b> ";
	echo "<a href='".$PHP_SELF."?show_roll={$main["RollID"]}'>";  // Link to this roll 
	// Account for threshold
	$succ -= $thresh;
	if ($succ < 0) {
		$succ = 0;
	}
	if ($main["Initiative"] != 1) {
		if ($succ==0 && $ones>0) {
			// botch
			print(" (BOTCH x $ones)");
		} else {
			$succ -= $ones;
			if ($succ > 1)
				print("[$succ successes]");
			elseif ($succ == 1)
				print("[$succ success]");
			else
				print("[failure]");
		}
	} else {
		print("[initiative roll]");
	}
	echo "</a>";
	print("</b></font>");

	print("</font>");
}

function cleanupRolls($days_to_keep = 90) {
	$max_query = mysql_query("SELECT MAX(RollID) as `max` FROM mainroll WHERE RollTime < DATE_SUB(NOW(), INTERVAL ".(int)$days_to_keep." DAY)");
	$max_result = mysql_fetch_assoc($max_query);
	$delete_lt = $max_result['max'];
	mysql_query("delete from rolls WHERE RollID < $delete_lt");
	mysql_query("delete from mainroll WHERE RollID < $delete_lt");
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