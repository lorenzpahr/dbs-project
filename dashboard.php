<?php session_start();

$dbconn = pg_connect("host=localhost dbname=h1550811 user=h1550811 password=h1550811");

//get user picture
$res = pg_query("SELECT picture FROM users WHERE username='".$_SESSION['userID']."';");
$r = pg_fetch_object($res);
$userImg = $r -> picture;

//get Number of total posts
$res = pg_query("SELECT count(*) as counter FROM users NATURAL JOIN post WHERE username='".$_SESSION['userID']."';");
$r = pg_fetch_object($res);
$postCount = $r -> counter;

//get Number of total comments
$res = pg_query("SELECT count(*) as counter FROM users NATURAL JOIN comments WHERE username='".$_SESSION['userID']."';");
$r = pg_fetch_object($res);
$commentCount = $r -> counter;

//get most used Tag
/*
requires further implementing --> more posts from same user
for starter, list all tags (working) --> select tagName from users natural join post natural join tag_post natural join tag where username='admin';
*/

//get average Comments on your posts
/*
requires further implementing. way to get the p_id from username!!! and also add more posts per user
for starter, here is the select when u have the correct p_id for 1 post --> select comments.text from post, comments where post.p_id = comments.p_id and comments.p_id='1';
*/


pg_close();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Meow-Board</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  	<link rel="stylesheet" type="text/css" href="css/dashboard.css">
  </head>
  <body>
    <div class="dashboard container">
      <div id="temp"></div>
      <div class="dashboard_header">
        <div class="row">
          <div class="col-lg-6 dashboard_image" <?php echo "style='background:url(".$userImg.") no-repeat center center'"?>>
            <!-- Image is css background -->
          </div>
          <div class="col-lg-6 dashboard_title">
            <h1 id="usernameID"> <?php echo ($_SESSION['userID']);?> </h1>
          </div>
        </div>
      </div>
      <div class="dashboard_body">
        <div class="dashboard_statistics">
          <h1 class="header_style">Statistics: </h1>
          <h3>Number of Posts: <?php echo $postCount;?></h3>
          <h3>Number of Comments: <?php echo $commentCount;?></h3>
          <!-- <h3>Most used Tag: requires further implementing</h3>
          <h3>Average Comments on your Posts: requires further implementing</h3> -->
        </div>
        <div class="dashboard_createPost">
          <h1 class="header_style">Create a new Post: </h1>
            <form>
              <div class="form-group">
                <h3><label for="titleInput">Enter Headline: </label></h3>
                <input type="text" class="form-control" id="titleInput" aria-describedby="titleHelp" placeholder="enter title...">
                <small id="titleHelp" class="form-text text-muted">Enter a title with a maximum of 50 characters.</small>
              </div>
              <div class="form-group">
                <h3><label for="imgURL">Image URL: </label></h3>
                <input type="text" class="form-control" id="imgURL" aria-describedby="imgHelp" placeholder="enter image url...">
                <small id="imgHelp" class="form-text text-muted">e.g. img/kitten1.jpg</small>
              </div>
              <button type="submit" class="btn btn-success submit_post">Submit</button>
            </form>
          </div>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/main.js"></script>
  </body>
</html>
