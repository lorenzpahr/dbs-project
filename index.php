<?php  // PHP-Session-Code
	session_start();
	$errormsg = "";

	if(isset($_GET['login']))
	{
		$dbconn = pg_connect("host=localhost dbname=h1550811 user=h1550811 password=h1550811");
		$username = $_POST['username'];
		$password = $_POST['password'];

		$u_query = "select * from users where username='".$username."'";
		$u_res = pg_query($u_query);
		$u_r = pg_fetch_object($u_res);
		if($u_r != null)
		{
			if(($u_r -> password) == $password)
			{
				$_SESSION['userID'] = $u_r -> username;
			}else{$errormsg = "Wrong username or password!";}
		} else {
			$errormsg = "Username does not exist!";
		}
		pg_close();
	}

	//Destroy session and cookie
	if(isset($_GET['logout']))
	{
		$_SESSION = array();
		if (ini_get("session.use_cookies")) {
    		$params = session_get_cookie_params();
    		setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
		}
		session_destroy();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Meow-Board</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>

	<!-- NAVBAR -->
	<div class="container">
		<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="#"> Meow-Board </a>
		    </div>
		    <ul class="nav navbar-nav navbar-right">
		      <?php if (!isset($_SESSION['userID'])) { ?> <!-- if there is no user session yet, display the login field-->
		      	<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-log-in"></span> Login <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-lr animated slideInRight" role="menu">
                        <div class="col-lg-12">
                            <div class="text-center"><h2><b>Login</b></h2></div>
                            <form id="ajax-login-form" action="?login=1" method="post" role="form" autocomplete="off">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="e.g. testuser1" value="" autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="e.g. 1234" autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-success" value="Login">
                                        </div>
                                    </div>
                                </div>
                                <!--<input type="hidden" class="hide" name="token" id="token" value="a465a2791ae0bae853cf4bf485dbe1b6">-->
                            </form>
                        </div>
                    </ul>
                </li>
							<?php } else {?> <!-- if there already is a user session, display the username and a logout instead of the login field-->
               	<li><a href="dashboard.php"><span class="glyphicon glyphicon-user" aria-hidden="true"></span><?php echo (" ".$_SESSION['userID']); ?></a></li>
               	<li><a href="index.php?logout=1">Logout</a></li>
							<?php } ?>
		    </ul>
		  </div>
		</nav>
	</div>

	<!-- Error-Field -->
	<?php if ($errormsg != "") { ?>
			<div class="container alert alert-danger">
	  			<strong>Meeeoww. You did a mistake, Hooman! Here is some info: </strong> <?php echo $errormsg;?>
			</div>
	<?php } ?>

	<!-- Posts TODO: CLEAN THIS MESS UP!-->
	<div class="wrapper"> <!-- load all the images from the database -->
		<div class="row">
		<?php
			$dbconn = pg_connect("host=localhost dbname=h1550811 user=h1550811 password=h1550811");
			$counter = -1;
			$p_query = 'Select * from post order by p_id desc'; //newest posts first to show
			$p_res = pg_query($p_query);
			$p_r = pg_fetch_object($p_res);
			while($p_r != null)
			{
				if ($counter < 0){
					if(isset($_SESSION['userID'])){
					?> <!-- if logged in, the first post is for adding new posts-->
					<div class="col-md-6 col-lg-3">
						<div class="container-fluid post_wrapper addPost">
							<div class="circle">
							  <div class="bar vert_cross"></div>
							  <div class="bar hor_cross"></div>
							</div>
						</div>
					</div>
				<?php
			}
				$counter = $counter + 1;
			} else {?>
			<div class="col-md-6 col-lg-3">
				<div <?php echo ("id='".$p_r -> p_id."'");?> class="container-fluid post_wrapper">
					<h3 id="postHead" hidden> <?php echo($p_r -> title); ?></h3>
					<!-- Check if user is logged in to show comments -->
					<?php if (isset($_SESSION['userID'])) { ?>

						<img href="#" class="imgres" id="postImage" <?php echo ('src="'. $p_r -> storageurl .'"');?>>
						<!--<a href="#" data-target="#post_modal" data-toggle="modal" <?php //echo ("data-id='".$p_r -> p_id."'");?>>Show details >></a>-->
						<div class="img_overlay" data-target="#post_modal" data-toggle="modal" <?php echo ("data-id='".$p_r -> p_id."'");?>>
							<div class="overlay_text"><a>Show details.</a></div>
						</div>
					<?php } else { ?>
						<img id="postImage" class="imgres" <?php echo ('src="'. $p_r -> storageurl .'"');?>>
						<div class="img_overlay">	<!--<p>Login to see the full post!</p>-->
							<div class="overlay_text"><a>Login to show post!</a></div>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php
			$p_r = pg_fetch_object($p_res);
			$counter = $counter + 1;
				}
			}
			pg_close();
		?>
				</div>
	</div>

	<!-- Post_Detail_View Modal -->
	<div class="modal fade" id="post_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h4 class="modal-title" id="modal_title_id">Modal title</h4>
	      </div>
	      <div class="modal-body">
	       		<img id="modal_img" class="imgMod" src="" />
	      </div>
	      <div class="modal-footer">
	        <!--comments added by javascript-->
	      </div>
	    </div>
	  </div>
	</div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>
