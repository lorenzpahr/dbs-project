<?php 
	
	$dbconn = pg_connect("host=localhost dbname=h1550811 user=h1550811 password=h1550811");
	
	$title = $_POST['title'];
	$imgURL = $_POST['url'];
	$username = $_POST['username'];

	//Select max ID for adding posts
	$res = pg_query("SELECT max(p_id) as pid from post;");
	$r = pg_fetch_object($res);
	$post_id = ($r -> pid) + 1;

	//Select current userID
	$res = pg_query("SELECT u_id as uid from users where username='".$username."';");
	$r = pg_fetch_object($res);
	$user_id = $r -> uid;


	//Craft query for the insert
	$query = "INSERT INTO post values('".$post_id."','".$user_id."','".$title."','".$imgURL."');";
	$res = pg_query($query);
?>
