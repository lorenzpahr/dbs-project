<?
	session_start();
	$dbconn = pg_connect("host=localhost dbname=h1550811 user=h1550811 password=h1550811");
	$errormsg = "";

	if(isset($_GET['login']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];

		$query = "select * from users where username='".$username."'";
		$res = pg_query($query);
		$r = pg_fetch_object($res);
		if($r != null)
		{
			if(($r -> password) == $password)
			{
				$_SESSION['userID'] = $r -> username;
			}else{$errormsg = "Wrong username or password!";}
		} else {
			$errormsg = "Username does not exist!";
		}
	}

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
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<div class="container">
		<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="#"> _< pr0cat</a>
		    </div>
		    <!--<ul class="nav navbar-nav">
		      <li class="active"><a href="#">Home</a></li>
		    </ul>-->
		    <ul class="nav navbar-nav navbar-right">
		      <!--<li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>-->
		      <!--<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>-->
		      <? if (!isset($_SESSION['userID'])) { ?> <!-- if there is no user session yet, display the login field-->
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
               <? } else {?> <!-- if there already is a user session, display the username instead of the login field-->
               	<li><a><span class="glyphicon glyphicon-user" aria-hidden="true"></span><?echo " ".$_SESSION['userID']?></a></li>
               	<li><a href="index.php?logout=1">Logout</a></li>
               <? } ?>
		    </ul>
		  </div>
		</nav>
	</div>
	<? if ($errormsg != "") { ?> 
			<div class="container alert alert-danger">
  				<strong>Meeeoww. You did a mistake, Hooman! Here is some info: </strong> <?echo $errormsg;?>
			</div>
	<? } ?> 
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-lg-4">
				<div class="container-fluid post_wrapper">
					<h3>Look at this awesome cat tho</h3>
					<img class="imgres" src="img/kitten2.jpg">
					<div class="comment_wrapper">
						<h4>Comments: </h4>
						<p> Comment 1 </p>
						<p> asdf </p>
						<p> That cat tho !! </p>
						<p> omfg that is so THICC! </p>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-lg-4">
				<div class="container-fluid post_wrapper">
					<h3>This cat is crazy af, lul lul lul lul lul lul</h3>
					<img class="imgres" src="img/kitten1.jpg">
				</div>
				<div class="comment_wrapper">
					<h4>Comments: </h4>
				</div>
			</div>
			<div class="col-md-6 col-lg-4">
				<div class="container-fluid post_wrapper">
					<h3>He loves me!</h3>
					<img class="imgres" src="img/kitten3.jpg">
					<div class="comment_wrapper">
						<h4>Comments: </h4>
						<p> Nah, bra, hes just hungry af! </p>
						<p> Cats cant love! </p>
						<p> He`s only hungry you dork! </p>
					</div>
				</div>
			</div>
		</div>
	</div>
		
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>