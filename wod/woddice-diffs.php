<?php
	define(DB_LOGIN, "digitax0_roller");
	define(DB_PASSWORD, "rollin");
	define(ROLL_DB, "digitax0_woddice");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Dice Rolling Rules Differences</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#000000" text="#CCCCFF" link="#00FFFF" vlink="#6666FF" alink="#000066">
<p>Here's a brief table explaining how different systems say to handle Specialty 
  rerolls.</p>
<p>&quot;Recursive&quot; means that if you get a 10 on the result of a Specialty 
  reroll, you roll it again; if you get another 10, then you reroll that as well, 
  and so forth. If this is &quot;no&quot;, then you only get to reroll once, regardless 
  of whether you get a 10 on the reroll or not.</p>
<p>&quot;1s count&quot; means that 1s on a Specialty reroll subtract successes 
  as normal. If this is &quot;no&quot;, then 1s on a Specialty reroll do <strong>not</strong> 
  subtract from your total successes.</p>
<table border="1" cellpadding="3" cellspacing="1" bordercolor="#00CCFF">
  <tr> 
    <td><strong>System</strong></td>
    <td><strong>Recursive?</strong></td>
    <td><strong>1s Count?</strong></td>
  </tr>
  <?
	$db=mysql_connect("localhost",DB_LOGIN, DB_PASSWORD) or die ("Cannot connect to database"); 
	mysql_select_db(ROLL_DB,$db) or die ("Cannot select database");
	$result=mysql_query("select * from rulessets rs, colorschemes cs where rs.RulesSet = cs.RulesSet",$db) or die ("Cannot peform SELECT: ".mysql_error());
	while($row=mysql_fetch_array($result)) {
  ?>
  <tr> 
    <td><? print($row["Description"]); ?></td>
    <td><? print($row["RecursiveReroll"]==1 ? "yes" : "no"); ?></td>
    <td><? print($row["RerolledOnesCount"]==1 ? "yes" : "no"); ?></td>
  </tr>
  <?
  	}
  ?>
</table>
<p>&nbsp;</p>
</body>
</html>
