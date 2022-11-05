<?php

require_once("zapcallib.php");

$examples = 
array(
	array(
		"name" => "Abraham Lincon's birthday",
		"date" => "2015-02-12",
		"rule" => "FREQ=YEARLY;INTERVAL=1;BYMONTH=2;BYMONTHDAY=12"
	),

	array(
		"name" => "Start of U.S. Supreme Court Session (1st Monday in October)",
		"date" => "2015-10-01",
		"rule" => "FREQ=YEARLY;INTERVAL=1;BYMONTH=10;BYDAY=1MO"
	)
);

// Use maxdate to limit # of infinitely repeating events
$maxdate = strtotime("2022-12-31");

foreach($examples as $example)
{
	echo $example["name"] . ":\n";
	$rd = new ZCRecurringDate($example["rule"],strtotime($example["date"]));
	$dates = $rd->getDates($maxdate);
	foreach($dates as $d)
	{
		echo "  " . date('l, F j, Y ',$d) . "<br>\n";
	}
	echo "<br>\n";
}
