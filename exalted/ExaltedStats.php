<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head>	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />	<title>Exalted Statistics</title>	<link href="UmbralEchoes.css" rel="stylesheet" type="text/css" /></head>
<body>

<form id="form1" name="form1" method="post" action="<?php echo basename($PHP_SELF); ?>">
  <table width="550" border="1">
    <tr>
      <th colspan="2" scope="col">Pools</th>
    </tr>
    <tr>
      <td valign="top" scope="col">
        <div align="center">Pool 1         
        </div>
        <div align="right">Pool
            <input name="pool" type="text" size="3" value="<?php
  	echo (isset($_POST['pool']) ? $_POST['pool'] : ''); ?>" />
          </div>
          <div align="right">Target Number
            <input name="target" type="text" size="2" value="<?php
  	echo (isset($_POST['target']) ? $_POST['target'] : 7);
  ?>" />
          </div>
          <label>
          <input type="checkbox" name="double_tens" value="checked" <?php
  	echo (isset($_POST['submit']) ? $_POST['double_tens'] : 'checked');
  ?> />
            10s count as 2 successes</label></td>
      <td valign="top" scope="col">
        <div align="center">Pool 2
          
        </div>
        <div align="right">Pool
          <input name="pool2" type="text" size="3" value="<?php
  	echo (isset($_POST['pool2']) ? $_POST['pool2'] : ''); ?>" />
      </div>
        <div align="right">Target Number
          <input name="target2" type="text" size="2" value="<?php
  	echo (isset($_POST['target2']) ? $_POST['target2'] : 7);
  ?>" />
        </div>
        <label>
        <input type="checkbox" name="double_tens2" value="checked" <?php
  	echo (isset($_POST['submit']) ? $_POST['double_tens2'] : 'checked');
  ?> />
      10s count as 2 successes</label></td>
    </tr>
  </table>
  <br />
  <table width="341" border="1">
    <tr>
      <th width="331" scope="col">Calculations</th>
    </tr>
    <tr>
      <td valign="top" scope="col"><label>
          <input name="check_average" type="checkbox" value="checked" <?php echo $_POST['check_average']; ?> />
        Average number of successes</label><br />
        <div align="right">
          <label><input name="check_negs_as_zero" type="checkbox" value="checked" <?php
  	echo (isset($_POST['submit']) ? $_POST['check_negs_as_zero'] : 'checked');
  ?> /> Count negatives (botches) as 0 successes</label></div>
        <p>
			<label><input name="check_at_least" type="checkbox" value="checked" <?php echo $_POST['check_at_least']; ?> />
			At least</label> <input name="at_least" type="text" size="2" value="<?php echo $_POST['at_least'] ?>" /> successes<br />
			<label><input name="check_at_most" type="checkbox" value="checked" <?php echo $_POST['check_at_most']; ?> />
			At most </label><input name="at_most" type="text" size="2" value="<?php echo $_POST['at_most'] ?>" /> successes<br />
			<label><input name="check_exactly" type="checkbox" value="checked" <?php echo  $_POST['check_exactly']; ?> />
			Exactly </label><input name="exactly" type="text" size="2" value="<?php echo $_POST['exactly'] ?>" /> successes<br />
			<input name="check_between" type="checkbox" value="checked" <?php echo $_POST['check_between']; ?> />
			Between <input name="between_lower" type="text" size="2" value="<?php echo $_POST['between_lower'] ?>" />			and
			<input name="between_upper" type="text" size="2" value="<?php echo $_POST['between_upper'] ?>" />
			successes		</p>
        <p>vs. Calculations<br />
</p></td>
    </tr>
  </table>
  <label></label>
  <input name="submit" type="submit" value="Calculate" />
</form>
<?php
	if (isset($_POST['submit'])) {
		echo "<br>";
		
		$numDice = intval($_POST['pool']);
		$target = intval($_POST['target']);
		$doubleTens = isset($_POST['double_tens']);
		
		$odds = calculateOdds($numDice, $target, $doubleTens);
		echo "<b><u>Pool 1 Odds</u></b>";
		printProbs($odds);
		echo"<br><br>";
		
		if (isset($_POST['pool2']) && $_POST['pool2'] != '') {
			$numDice2 = intval($_POST['pool2']);
			$target2 = intval($_POST['target2']);
			$doubleTens2 = isset($_POST['double_tens2']);
			
			$odds2 = calculateOdds($numDice2, $target2, $doubleTens2);
			echo "<b><u>Pool 2 Odds</u></b>";
			printProbs($odds2);
			echo"<br><br>";

			$vs_odds = calculate_vs($odds, $odds2);
			
			echo "<b><u>Vs. Odds</u></b><br>";
			echo "Probability pool 1 wins: ".$vs_odds[0]. "<br>";
			echo "&nbsp;&nbsp;On average, 1 wins by: ".$vs_odds[2]. " successes<br>";
			echo "Probability pool 2 wins: ".$vs_odds[1]. "<br>";
			echo "&nbsp;&nbsp;On average, 2 wins by: ".$vs_odds[3]. " successes<br>";
		}
	
		echo "<br><br><b>Individual Pool 1 Odds</b>:<br>".nl2br(print_r($odds, true));
		if (isset($_POST['pool2']) && $_POST['pool2'] != '') {
			echo "<br><br><b>Individual Pool 2 Odds</b>:<br>".nl2br(print_r($odds2, true));
		}

	}
?>
</body>
</html>

<?php
	function printProbs($odds) {
		global $_POST;
		
		if (isset($_POST['check_average'])) {
			$average = calculateAverage($odds, isset($_POST['check_negs_as_zero']));
			echo "<br>Average Number of Successes: $average";
		}

		if (isset($_POST['check_at_least'])) {
			$prob_at_least = calculateAtLeast($odds, $_POST['at_least']);
			echo "<br>Probability of at least ".$_POST['at_least']." successes: $prob_at_least";
		}
	
		if (isset($_POST['check_at_most'])) {
			$prob_at_most = calculateAtMost($odds, $_POST['at_most']);
			echo "<br>Probability of at most ".$_POST['at_most']." successes: $prob_at_most";
		}
	
		if (isset($_POST['check_exactly'])) {
			echo "<br>Probability of exactly ".$_POST['exactly']." successes: ".$odds[$_POST['exactly']];
		}
	
		if (isset($_POST['check_between'])) {
			$prob_between = calculateBetween($odds, $_POST['between_lower'], $_POST['between_upper']);
			echo "<br>Probability of between ".$_POST['between_lower'].
				" and ".$_POST['between_upper']." successes: $prob_between";
		}
	}
	
	function calculateOdds($numDice, $target, $doubleTens) {
		$doubleSuccChance = 0.1 * $doubleTens;
		$botchChance = 0.1;
		$failChance = ($target-1)/10.0;  // usually 0.6
		$successChance = 1.0-$failChance - $doubleSuccChance; // usually 0.3

		$oldArr = array(0 => 1.0);	// 100% chance of getting 0 successes with 0 dice
		
		// Go through, die by die, and get odds of getting given number of successes
		for ($count=1; $count<=$numDice; $count++) {
			$newArr = array();
			for ($succCount=-$count; $succCount<=$count*2; $succCount++) {
				if ($succCount < 0) {
					$newArr[$succCount] = $oldArr[$succCount+1] * $botchChance
											+ $oldArr[$succCount] * ($failChance-$botchChance);
				} elseif ($succCount == 0) {
					$newArr[$succCount] = $oldArr[$succCount] * ($failChance - $botchChance);
				} elseif ($succCount == 1) {
					$newArr[$succCount] = arrsum($oldArr, -$count, 0) * $successChance
											+ $oldArr[1] * $failChance;
				} elseif ($succCount == 2) {
					$newArr[$succCount] = $oldArr[1] * $successChance
											+ $oldArr[2] * $failChance
											+ arrsum($oldArr, -$count, 0) * $doubleSuccChance;
				} else {				
					$newArr[$succCount] = $oldArr[$succCount-1] * $successChance
											+ $oldArr[$succCount] * $failChance
											+ $oldArr[$succCount-2] * $doubleSuccChance;
				}
			}
			$oldArr = $newArr;
		}
		
		return $newArr;
	}

	function arrsum($array, $startIndex, $endIndex) {
		$sum = 0.0;
		for ($count=$startIndex; $count <= $endIndex; $count++) {
			$sum += $array[$count];
		}
		return $sum;
	}
	
	function calculateAverage($array, $countNegativeAsZero=true) {
		$average = 0.0;
		foreach ($array as $successes => $odds) {
			if ($successes < 0 && $countNegativeAsZero) {
			} else {
				$average += $successes * $odds;
			}
		}
		return $average;
	}
	
	function calculateAtLeast($array, $atLeast) {
		$prob = 0.0;
		foreach ($array as $successes => $odds) {
			if($successes >= $atLeast) {
				$prob += $odds;
			}
		}
		return $prob;
	}
	
	function calculateBetween($array, $atLeast, $atMost) {
		$prob = 0.0;
		foreach ($array as $successes => $odds) {
			if($successes >= $atLeast && $successes <= $atMost) {
				$prob += $odds;
			}
		}
		return $prob;
	}
	
	function calculateAtMost($array, $atMost) {
		$prob = 0.0;
		foreach ($array as $successes => $odds) {
			if($successes <= $atMost) {
				$prob += $odds;
			}
		}
		return $prob;
	}
	
	function calculate_vs($arr1, $arr2) {
		$one_over_two = 0.0;
		$two_over_one = 0.0;
		
		$avg_one_over = 0.0;
		$avg_two_over = 0.0;
		
		foreach ($arr1 as $succ1 => $odds1) {
			foreach ($arr2 as $succ2 => $odds2) {
				if ($succ1 > 0 || $succ2 > 0) {
					//echo "DEBUG: calculating odds of arr 1 $succ1 odds vs. arr2 $succ2 odds<br>";
					if ($succ1 > $succ2) {
						$one_over_two += $odds1 * $odds2;
						$avg_one_over += ($succ1-$succ2) * $odds1 * $odds2;
					} elseif ($succ2 > $succ1) {
						$two_over_one += $odds1 * $odds2;
						$avg_two_over += ($succ2-$succ1) * $odds1 * $odds2;
					}
				}
			}
			//echo "<br>";
		}
			
		return array($one_over_two, $two_over_one, $avg_one_over, $avg_two_over);
	}
?>