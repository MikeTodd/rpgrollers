<?php
	define(DB_LOGIN, "digitax0_roller");
	define(DB_PASSWORD, "rollin");
	define(ROLL_DB, "digitax0_rollers");
	
	mysql_connect("localhost",DB_LOGIN,DB_PASSWORD) or die ("Cannot connect to database<br>" . mysql_error()); 
	mysql_select_db(ROLL_DB) or die ("Cannot select database<br>" . mysql_error());
	
	if ($_COOKIE['secret_roll_uid'] == '') {
		$uid = uniqid('', true);
		setcookie('secret_roll_uid', $uid, time()+60*60*24*30);
		//die('Set cookie to '.$uid);
	} else {
		// Refresh cookie expiration time
		setcookie('secret_roll_uid', $_COOKIE['secret_roll_uid'], time()+60*60*24*30);
		//die('Refreshed cookie, value '.$_COOKIE['secret_roll_uid']);
	}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Shadowrun 4th Edition Dice Roller</title>
<meta name="keywords" content="shadowrun dice roller rpg sr4">
<meta name="description" content="Shadowrun 4th Edition Dice Roller">
<link rel="shortcut icon" href="favicon.ico" />
<link id="page_favicon" href="favicon.ico" rel="icon" type="image/x-icon" />

<link rel="stylesheet" type="text/css" href="style.css" media="all" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>

</head>

<body>
<?php

function my_query($query) {
	$result = mysql_query($query) or die(mysql_error());
	return $result;
}

function show_previous_rolls($num_previous = 10) {
	$query = "SELECT * FROM sr4_roll_info
		WHERE (secret_id = '' OR secret_id = '".mysql_real_escape_string($_COOKIE['secret_roll_uid'])."')
		ORDER BY roll_time DESC LIMIT ".(int)$num_previous;
	$rolls_query = my_query($query);
	
	if (mysql_num_rows($rolls_query) > 0) {
		echo "<br />Previous Rolls:<br />"
			.'<table border="1">
				<tr>
					<th><acronym title="Times are EST -2">Date</acronym></th>
					<th>Action</th>
					<th>Results</th>
				</tr>';
		while ($roll = mysql_fetch_array($rolls_query)) {
		
			// Check to see if this was a secret roll
			if ($roll['secret_id'] != '' && $roll['secret_id'] != $_COOKIE['secret_roll_uid']) {
				continue;
			}
			
			$action_string = '<b>'.$roll['name'].'</b> rolls <b>'.$roll['pool'].' '.($pool == 1 ? 'die' : 'dice').'</b> to <b>'.$roll['action'].'</b>';
			if ($roll['edge_roll'] == 1) {
				$action_string .= ' (edge roll)';
			}
			if ($roll['secret_id'] != '') {
				$action_string .= ' [Secret roll]';
			}

			
			echo '<tr>
					<td valign="top" style="white-space:nowrap;">'.$roll['roll_time'].'</td>
					<td valign="top">'.$action_string.'</td>';

			// Display results
			echo '<td valign="top">';		
			$dice = my_query("SELECT die_result FROM sr4_individual_rolls WHERE roll_id = ".(int)$roll['roll_id']);
			
			if (mysql_num_rows($dice)) {
			
				$in_edge_roll = false;
				$hits = 0;
				$ones = 0;
				
				while ($die = mysql_fetch_array($dice)) {
				
					$die_result = $die['die_result'];					
					if ($die_result >= 5) {
						$hits++;
						echo '<b>';
					} elseif ($die_result == 1) {
						echo '<span class="one">';
					} else {
						echo '<span class="miss">';
					}
					
					echo $die_result.' ';
					if ($die_result >= 5) {
						echo '</b>';
					} else {
						echo '</span>';
					}
					
					if ($die_result == 1 && !$in_edge_roll) {
						$ones++;
					}
					
					if ($die_result == 6 && $roll['edge_roll'] == 1) {
						if (!$in_edge_roll) {
							echo '<span class="edge">';
							$in_edge_roll = true;
						}
					} else {
						if ($in_edge_roll) {
							echo '</span>';
							$in_edge_roll = false;
						}
					}
					
				}
				
			} else {
				echo '<i>No results</i>';
			}

			echo "| Results: {$hits} hit".($hits == 1 ? '' : 's');
			echo ", {$ones} one".($ones == 1 ? '' : 's');
			if ($ones > $roll['pool']/2) {
				if ($hits == 0) {
					echo ' (Critical glitch!)';
				} else {
					echo ' (Glitch!)';
				}
			}			
			echo '</td>';
			echo '</tr>';
		}
		
		echo '</table>';
	}
}

function create_roll($name, $action, $pool, $edge_roll, $secret_uid) {
	my_query("INSERT INTO sr4_roll_info (name, action, pool, edge_roll, secret_id)
		VALUES
		('".mysql_escape_string($name)."', '".mysql_escape_string($action)."', ".(int)$pool.", ".(int)$edge_roll.", '".mysql_escape_string($secret_uid)."')");

	return mysql_insert_id();
}

function add_die($roll_id, $die_result) {
	my_query("INSERT INTO sr4_individual_rolls (roll_id, die_result)
		VALUES (".(int)$roll_id.", ".(int)$die_result.")");
}

if ($_REQUEST['roll'] == 'Roll') {
	$num_dice = (int)$_REQUEST['base_pool'];
	
	$hits = 0;
	$ones = 0;
	if ($_REQUEST['secret_roll'] == 1) {
		$secret_uid = $_COOKIE['secret_roll_uid'];
	} else {
		$secret_uid = '';
	}
	
	$roll_id = create_roll($_REQUEST['name'], $_REQUEST['action'], $num_dice, $_REQUEST['edge_roll'], $secret_uid);
	
	for ($i=0; $i<$num_dice; $i++) {
		$result = mt_rand(1, 6);
		add_die($roll_id, $result);
		
		if ($result == 6 && $_REQUEST['edge_roll'] == 1) {
			echo '[';
		}
		
		echo '<img src="img/dice'.$result.'.png" /> ';
		if ($result >= 5) {
			$hits++;
		}
		if ($result == 1) {
			$ones++;
		}

		// Handle Edge rerolls
		if ($result == 6 && $_REQUEST['edge_roll'] == 1) {
			while ($result == 6) {
				$result = mt_rand(1, 6);
				add_die($roll_id, $result);
				echo '<img src="img/dice'.$result.'.png" /> ';
				if ($result >= 5) {
					$hits++;
				}
			}
			echo '] ';
		}
	}
	echo "<br /><b>{$hits} hits</b>, {$ones} ones.";
	if ($ones > $num_dice / 2) {
		if ($hits == 0) {
			echo '<br /><span style="color:red">Critical glitch!</span>';
		} else {
			echo '<br /><span style="color:orange">Glitch!</span>';
		}
	}
	
	/*my_query("UPDATE sr4_roll_info
			SET ones_rolled = ".(int)$ones."
				, hits_rolled = ".(int)$hits."
			WHERE roll_id = ".(int)$roll_id); /**/
	
	echo "<br />";
}
?>

<form method="GET">
Character: <input type="text" name="name" value="<?php echo $_REQUEST['name']; ?>" /><br />
Action: <input type="text" name="action" value="<?php echo $_REQUEST['action']; ?>" /><br />
Base Pool: <input type="text" name="base_pool" size="3" value="<?php echo $_REQUEST['base_pool']; ?>" /> <input type="submit" name="roll" value="Roll" />  <input type="submit" name="refresh" value="Refresh" /><br />
<label><input type="checkbox" name="edge_roll" value="1"<?php if ($_REQUEST['edge_roll'] == 1) echo ' checked="checked"'; ?> /> Reroll 6s?</label><br />
<label><input type="checkbox" name="secret_roll" value="1"<?php if ($_REQUEST['secret_roll'] == 1) echo ' checked="checked"'; ?> /> <acronym title="Only you will be able to see this roll, on the computer you are currently using. It is still recorded in the database.">Secret roll?</acronym></label><br />
<br />
<span onClick="$('#options').slideToggle();" style="cursor:pointer; font-weight:bold;">Show Cheat Sheets</span><br />
<div id="options" style="display:none">
<table>
  <tr>
    <th>Ranged Combat</th>
	<th>Melee Combat</th>
  </tr>
  <tr>
    <td valign="top">
		[ ] Attacker running (-2)<br />
		[ ] Attacker in melee combat (-3)<br />
		[ ] Attacker in a moving vehicle (-3)<br />
		[ ] Attacker firing from cover (-2)<br />
		[ ] Attacker wounded (varies, see p.163)<br />
		[ ] Attacker using laser sight (+1)<br />
		[ ] Attacker using smartlinked weapon (+2)<br />
		[ ] Attacker using off-hand weapon (-2)<br />
		[ ] Aimed shot (+1 per simple action)<br />
		[ ] Blind fire (-6)<br />
		[ ] Called shots (variable, see p.161)<br />
		[ ] Multiple targets (-2/addt'l target that Action Phase)<br />
		[ ] Tracer rounds w/short burst (+1)<br />
		[ ] Tracer rounds w/long burst (+2)<br />
		[ ] Tracer rounds w/full auto (+3)<br />
		[ ] Recoil, semi-auto (-1 for 2nd shot that Action Phase)<br />
		[ ] Recoil, burst (-2 first burst, -3 second burst)<br />
		[ ] Recoil, long burst (-5 first burst, -6 second burst)<br />
		[ ] Recoil, full auto (-9)<br />
		[ ] Recoil, heavy weapon (2x uncompensated recoil)<br />
		[ ] Recoil compensation (reduces recoil modifier)<br />
		[ ] Target point-blank (+2)
	</td>
    <td valign="top">
		[ ] Friends in the melee (+1 per friend , max +4)<br />
		[ ] Character wounded -wound modifier (see p. 163)<br />
		[ ] Character has longer Reach (+1 per point of net Reach)*<br />
		[ ] Character using off-hand weapon (-2)<br />
		[ ] Character attacking multiple targets (split dice pool)<br />
		[ ] Character has superior position (+2)<br />
		[ ] Opponent prone (+3)<br />
		[ ] Attacker making charging attack (+2)<br />
		[ ] Defender receiving a charge (+1)<br />
		[ ] Visibility impaired (consult the Visibility Table, p. 152)<br />
		[ ] Called shot Variable (see Called Shots, p. 161)<br />
		[ ] Touch-only attack (+2)<br />
		* You may apply Reach as a -1 dice pool modifier per net point to the opponent instead.
	</td>
  </tr>
</table>
</div>

<?php
	show_previous_rolls();
?>

</form>
</body>