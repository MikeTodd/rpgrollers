<html>
  <head>

 <?php
if ($_GET['Submit'] == 'Calculate') {
?>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Num in hand', 'P(exact)', 'P(at least)'],
<?php
	for ($i=1; $i < (int)$_GET['hand_size']; $i++) {
		$exact = hypergeometric((int)$_GET['deck_size'],(int)$_GET['num_target'],(int)$_GET['hand_size'],$i);
		$at_least = hypergeometric_at_least((int)$_GET['deck_size'],(int)$_GET['num_target'],(int)$_GET['hand_size'],$i);
		if ($at_least > 0.000) { // Don't show 0% odds
			echo "['{$i}',{$exact},{$at_least}]";
			if ($i != (int)$_GET['hand_size'] - 1)
				echo ",";
			echo "\r\n";
		}
	}/**/
?>
        ]);

        var options = {
          title: '% odds of getting X of the given card, having drawn <?= (int)$_GET['hand_size']; ?> cards',
          hAxis: {title: '# of cards'},
          vAxis: {title: 'Odds', format:'#,###%'},
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
<?php
}
?>
  </head>

  <body>
<form method="get" action="#">
	Deck size: <input type="text" name="deck_size" value="<?= $_GET['deck_size']; ?>"><br />
	Number of target card in deck: <input type="text" name="num_target" value="<?= $_GET['num_target']; ?>"><br />
	"Hand" size: <input type="text" name="hand_size" value="<?= $_GET['hand_size']; ?>"><br />
	<input type="submit" name="Submit" value="Calculate">
</form>
  </body>
</html>
<?php
if ($_GET['Submit'] == 'Calculate') {

	echo '<div id="chart_div" style="width: 900px; height: 600px;"></div>';

	echo "<table border='1'>
		<tr>
			<th># in hand</th>
			<th>P(exactly)</th>
			<th>P(at least)</th>
			<th>P(at most)</th
		</tr>";

	for ($i=1; $i < (int)$_GET['hand_size']; $i++) {
		$exact = round(hypergeometric((int)$_GET['deck_size'],(int)$_GET['num_target'],(int)$_GET['hand_size'],$i)*100, 1);
		$at_least = round(hypergeometric_at_least((int)$_GET['deck_size'],(int)$_GET['num_target'],(int)$_GET['hand_size'],$i)*100, 1);
		$at_most = 100 - $at_least;
		echo "<tr><td>{$i}</td><td>{$exact}%</td><td>{$at_least}%</td><td>{$at_most}%</td></tr>";
	}
	echo "</table>";

}

//$a = nCr(28,5);
//$b = 

// Returns hypergeometric distribution for at least the desired number of successes, up to $sample_size successes
function hypergeometric_at_least($population, $successes_in_population, $sample_size, $at_least) {

	for ($i=$at_least; $i<$sample_size; $i++) {
		$prob += hypergeometric($population, $successes_in_population, $sample_size, $i);
	}

	return $prob;

}

// Returns hypergeometric distribution
function hypergeometric($population, $successes_in_population, $sample_size, $desired_successes) {

	return nCr($successes_in_population, $desired_successes) * nCr($population - $successes_in_population, $sample_size - $desired_successes) / nCr($population, $sample_size) ;

}

// Calculates a combinations -- n choose r = n! / (r! * (n-r)!)
function nCr($n, $r) {
	if ($n <= $r || $n < 0 || $r < 0) return 0;

	$result = 1;

	for ($i = $n; $i > $r; $i--) {
		$result *= $i;
	}

	$result /= factorial($n-$r);

	return $result;
}

// Calculates a factorial
function factorial($in) {
    // 0! = 1! = 1
    $out = 1;

    // Only if $in is >= 2
    for ($i = 2; $i <= $in; $i++) {
        $out *= $i;
    }

    return $out;
}

?>