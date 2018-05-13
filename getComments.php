<?php
	$id = intval($_GET['id']);
	$dbconn = pg_connect("host=localhost dbname=h1550811 user=h1550811 password=h1550811");

	$query = "Select username from post, users where post.u_id=users.u_id and post.p_id='".$id."'";
	$res = pg_query($query);
	$r = pg_fetch_object($res);
	$username = $r -> username;

	$query = "Select comments.text as text, users.username as username from comments, users where comments.u_id=users.u_id and p_id='".$id."'";
	$res = pg_query($query);

	$r = pg_fetch_object($res);
	echo('<p> posted by ' .$username. '</p>');
	echo('<div class="comment_wrapper">');
	echo('<h4>Comments: </h4>');
	while($r != null){
		echo("<a><span class='glyphicon glyphicon-user' aria-hidden='true'></span> ". $r -> username . "</a>");
		echo("<p>". $r -> text . "</p>");
		$r = pg_fetch_object($res);
	}
	echo('</div>');

	pg_close();
?>
