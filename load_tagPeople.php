<?php

/*
 * 
 * tag People with a single tweet.
 * @koray_zero #SM #tagPeople
 * #tagPeople #blogger #carAdict @koray_zero
 *
 * note: a bot whichs triggers if people tag themself: "you wan't to tag yourself? o.O"
 */


echo "tagPeople";

include('lib/TwitterSearch.php');

$search = new TwitterSearch('#ff');
$search->user_agent = '@tagPeople';

$results = $search->results();
//var_dump($results);

foreach($results as $i)
{
	echo $i->from_user . ": " . $i->text;

	//$l = preg_replace("/@([a-z0-9A-Z_]{1,15})/", "<a href=\"http://twitter.com/\\1\">@\\1</a>", $l);

	//preg_match($suchmuster, $zeichenkette, $treffer, PREG_OFFSET_CAPTURE, 3);
	preg_match('/@([a-z0-9A-Z_]{1,15})/', $i->text, $taggedOnes);
	var_dump($taggedOnes);
	foreach($taggedOnes as $j)
	{
		echo "<strong>" . $j . "</strong>";
	}
	echo "<br />";
}
?>