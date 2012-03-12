<?php


/*
 * 
 * tag People with a single tweet.
 * @koray_zero #SM #tagPeople
 * #tagPeople #blogger #carAdict @koray_zero
 *
 * note: a bot whichs triggers if people tag themself: "you wan't to tag yourself? o.O"
 */

include('lib/TwitterSearch.php');
include('lib/db.class.php');

echo "<h1>tagPeople</h1>";
$hastag = "lyon"; //lower case without hash '#'

$search = new TwitterSearch('#'. $hastag);
$search->user_agent = '@tagPeople - marco@5th.ch';

$results = $search->results();
//var_dump($results);

$myDB = new Database();
$myDB->connect();


foreach($results as $i)
{
	//echo $i->from_user . ": " . $i->text;

	preg_match_all('/@([a-z0-9A-Z_]{1,15})/', $i->text, $taggedOnes);
	preg_match_all('/#([a-z0-9A-Z_]+)/', $i->text, $tags);
	//$taggedOnes['0'] for the whole matched pattern / $taggedOnes['0'] for the matched pattern inside ()

	//echo $i->from_user. " tagged " . join(', ', $taggedOnes[0]) . " with " . join(', ', $tags[0]);
	echo "<strong>" . $i->text . "</strong>";
	echo "<br />";

	foreach ($tags[1] as $tag)
	{
		if(strtolower($tag) != strtolower($hastag))
		{


			foreach ($taggedOnes[1] as $user)
			{
				$result = mysql_query("SELECT id, count(id) AS count FROM tags WHERE tag = '". strtolower($tag)."'");
				$tagID = mysql_fetch_assoc($result);
				if($tagID['count'] == '0')
				{
					mysql_query("INSERT INTO tags (`id`, `tag`) VALUES (NULL, '" . strtolower($tag) . "')");
					$tagID['id'] = mysql_insert_id();
					echo "imported: #".$tag."<br />";
				}



				$result = mysql_query("SELECT id, count(id) AS count FROM users WHERE username = '". strtolower($user)."'");
				$userID = mysql_fetch_assoc($result);
				if($userID['count'] == '0')
				{
					mysql_query("INSERT INTO users (`id`, `username`) VALUES (NULL, '" . strtolower($user) . "')");
					$userID['id'] = mysql_insert_id();
					echo "imported: @".$user."<br />";
				}

				echo $userID['id'] . " >< " . $tagID['id'] . "<br />";
				mysql_query("INSERT INTO user_tag (`id`, `id_tag`, `id_user`) VALUES (NULL, ". $tagID['id'] .", ". $userID['id'] .")");
				
				
				//echo $tag . " " . $user . "-- ". $tagID['id'] . "<br />";
			}
		}
	}

}


?>