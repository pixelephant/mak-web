<?php 
session_start();
ob_start();

if(!isset($_SESSION['admin_user']) || $_SESSION['admin_user'] == ''){
	header("Location: login.php");
}
?>
<!DOCTYPE HTML>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="en">
	<!--<![endif]-->
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
		<meta charset="UTF-8">
		<meta content="Kulcsszó1, Kulcsszó2, Kulcsszó3" name="keywords"><meta content="Description szövege jön ide..." name="description">
		
		<title>Adminisztráció - Magyar Autóklub</title>		
		<link rel="stylesheet" href="lib/css/reset.css" />
		<link rel="stylesheet" href="lib/css/main.css" />
		<script src="lib/js/modernizr-2.min.js"></script>
	</head>
	<body>
	
		<div class="header-wrap">
			<div class="header-outer">
			<header class="wrapper">
				<h1>
					<a href="#">Magyar Autóklub <span>Adminisztráció</span></a>
				</h1>
			</header>
			</div>
		</div>
	<nav>
		<ul>
			<li><a href="hirlevel.php">Hírlevél kezelés</a></li>
			<li><a href="felhasznalokezeles.php">Felhasználók kezelése</a></li>
			<li><a href="statisztikak.php">Statisztikák</a></li>
			<li><a href="hirdeteskezeles.php">Hirdetés kezelése</a></li>
			<li><a href="felmereskezeles.php">Felmérések kezelése</a></li>
			<li><a href="elonezet.php">Előnézet</a></li>
			<li><a href="login/login.php">Kilépés</a></li>
		</ul>
	</nav>
	<div id="content">
		<div id="newsletter">
			<iframe src="hirdetesmanagement/index.php" width="100%" height="495px"></iframe>
		</div>
	</div>
	
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js">
		</script>
		<script>
window.jQuery || document.write('<script src="lib/js/jquery-1.6.2.js">\x3C/script>')
		</script>
		<script type="text/javascript" src="lib/js/admin.js">
		</script>
	</body>
</html>
<?php 
ob_end_flush();
?>