<?php


/*
 * 
 * tag People with a single tweet.
 * @koray_zero #SM #tagPeople
 * #tagPeople #blogger #carAdict @koray_zero
 *
 * note: a bot whichs triggers if people tag themself: "you wan't to tag yourself? o.O"
 */


echo "<h1>tagPeople</h1>";

include('lib/TwitterSearch.php');

$search = new TwitterSearch('#tagPeople');
$search->user_agent = '@tagPeople';

$results = $search->results();
//var_dump($results);

foreach($results as $i)
{
	//echo $i->from_user . ": " . $i->text;

	preg_match_all('/@([a-z0-9A-Z_]{1,15})/', $i->text, $taggedOnes);
	preg_match_all('/#([a-z0-9A-Z_]+)/', $i->text, $tags);
	//var_dump($taggedOnes);

	//$taggedOnes['0'] for the whole matched pattern / $taggedOnes['0'] for the matched pattern inside ()
	echo $i->from_user. " tagged " . join(', ', $taggedOnes[0]) . " with " . join(', ', $tags[0]);

	echo "<br />";
}


?>