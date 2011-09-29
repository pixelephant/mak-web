<?php 

require '../../lib/php/Wixel/gump.class.php';
require '../../lib/php/class.db.php';
require '../../lib/php/class.mak.php';

$main = new mak(false);

$target_path = '';

if(isset($_FILES)){
	$target_path = "img/";
	$target_path = $target_path . basename($_FILES['kep']['name']);
	if(move_uploaded_file($_FILES['kep']['tmp_name'], $target_path)){
		$target_path = 'admin/elonezet/' . $target_path;
	}else{
		$target_path = $_FILES['error'];
	}
	
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
		<base href="http://sfvm104.serverfarm.hu/mak/" />
		<title>Regisztráció - Magyar Autóklub</title>		
		<link rel="stylesheet" href="lib/css/reset.css" />
		<link rel="stylesheet" href="lib/css/main.css" />
		<link rel="stylesheet" href="lib/css/sub.css" />
		<link rel="stylesheet" href="lib/smoothness/style.css" />
		<script src="lib/js/modernizr-2.min.js"></script>
		<style type="text/css">
			
			#inputs{
				overflow: hidden;
			    padding: 15px;
			}
		
			#content form{
				color: #1c1c1c;
				padding-top: 20px;
			}

			#content form h2{
				font-size: 20px;
				margin-bottom: 55px;
			}

			#content form fieldset{
				background: #E8E8E8;
				margin-bottom: 40px;		
			    -webkit-border-radius: 2px; 
			    -moz-border-radius: 2px; 
			    border-radius: 2px; 
			    -moz-background-clip: padding; -webkit-background-clip: padding-box; background-clip: padding-box;
			    border:1px solid #B4B4B4;
				padding-bottom:8px;
			}

			#content form h3{
				padding: 6px;
				font-size: 16px;
				color: white;
				background-color: #4691B0;
				background-image: -webkit-gradient(linear, left top, left bottom, from(#4691B0), to(#04739E)); 
				background-image: -webkit-linear-gradient(top, #4691B0, #04739E); 
				background-image:    -moz-linear-gradient(top, #4691B0, #04739E); 
				background-image:     -ms-linear-gradient(top, #4691B0, #04739E); 
				background-image:      -o-linear-gradient(top, #4691B0, #04739E); 
				background-image:         linear-gradient(top, #4691B0, #04739E);
				border-bottom:1px solid #B4B4B4;
				margin-bottom:8px;
			}

			#content form label{
				min-width: 190px;
				text-align: left;
				margin-right: 5px;
				color: #29384C;
				display: block;
				float: left;
				height: 24px;
				line-height: 24px;
				padding-left:10px;
			}

			#content form label.error{
				font-size: 12px;
				color: red;
				width: auto;
				margin: 0 !important;
				min-width: 0 !important;
				float: right;
				padding:0 10px;
			}

			#content form input[type='text'],#content form input[type='password']{
				width: 200px;
				height: 20px;
				float: left;
				border: 1px solid #797e82;	
				background-color: #E0E0E0;
				background-image: -webkit-gradient(linear, left top, left bottom, from(#E0E0E0), to(#F5F5F5)); 
				background-image: -webkit-linear-gradient(top, #E0E0E0, #F5F5F5); 
				background-image:    -moz-linear-gradient(top, #E0E0E0, #F5F5F5); 
				background-image:     -ms-linear-gradient(top, #E0E0E0, #F5F5F5); 
				background-image:      -o-linear-gradient(top, #E0E0E0, #F5F5F5); 
				background-image:         linear-gradient(top, #E0E0E0, #F5F5F5);
				filter: progid:DXImageTransform.Microsoft.gradient(startColorStr='#E0E0E0', EndColorStr='#F5F5F5'); 
				font-size: 13px;
			}

			/*Input méret igazítások */

			#content form .zip{
				width: 40px !important;
			}

			#content form .datepicker{
				width: 90px !important;
			}

			#content form input[type='radio']{
				margin-left: 5px;
			}

			#content form div.row{
				background:#e8e8e8;
				padding: 8px;
				overflow: hidden;
				position:relative;
				height:24px;
			}

			#content form .info{
				margin-top: 3px;
				margin-left: 5px;
			}

			#standardPlateFoInputRow{
				display: none;
			}

			.step2,.step3,.step4{
				display: none;
			}

			.detail{
				display: none;
			}

			span.sum{
				float:right;
			}

			.otp{
				background : url(../../img/otp.png) no-repeat right center #e8e8e8  !important;
			}

			#registerform input[type="checkbox"]{
				float:none;
				margin-top:5px;
			}

			#modechoose{
				overflow:hidden;
			}

			#modechoose .row{
				width:199px;
				display:block;
				float:left;	
				text-align:center;
				margin-top:15px;
				overflow: visible !important;
				height: 50px !important;
			}

			#modechoose label{
				font-weight:bold;
				min-width:0 !important;
				padding:10px;
				display:inline !important;
				float:none !important;
			}

			#modechoose input[type="radio"]{
				display:inline !important;
				float:none !important;
				margin:15px 0 !important;
				position:relative;
				left:-4px;
			}

			#content form input[type='button'], #content form input[type='submit']{
				-moz-box-shadow: inset 0px 1px 0px 0px #ffff00;
			    -webkit-box-shadow: inset 0px 1px 0px 0px #ffff00;
			    box-shadow: inset 0px 1px 0px 0px #ffff00;
			    background: -webkit-gradient( linear, left top, left bottom, color-stop(0.05, #FDD300), color-stop(1, #FCB614) );
			    background: -moz-linear-gradient( center top, #FDD300 5%, #FCB614 100% );
			    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fdd300', endColorstr='#fcb614');
			    background-color: #FDD300;
			    -moz-border-radius: 2px;
			    -webkit-border-radius: 2px;
			    border-radius: 2px;
			    border: 1px solid #DAA41A;
			    display: inline-block;
			    color: #1C1C1C;
			    font-size: 12px;
			    font-weight: bold;
			    padding: 8px 24px;
			    text-decoration: none;
			    text-shadow: 1px 1px 0px yellow;
			    float:right;
				border:1px solid black;
			}


			#content form input[type='button']:active, #content form input[type='submit']:active {
			   background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #fcb614), color-stop(1, #fdd300) );
			   background:-moz-linear-gradient( center top, #fcb614 5%, #fdd300 100% );
			   filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#fcb614', endColorstr='#fdd300');
			   background-color:#fcb614;
			}

			#content form input[type='button']:hover, #content form input[type='submit']:hover{
			     position:relative;
			     top:1px;
			}

			/*Tooltip*/
			#tooltip {
				position: absolute;
				z-index: 3000;
				border: 1px solid #FFD400;
				background-color: #F2BE00;
				padding: 6px;
				opacity: 0.85;
			    -webkit-border-radius: 6px; 
			    -moz-border-radius: 6px; 
				border-radius: 6px;       
				-moz-background-clip: padding; -webkit-background-clip: padding-box; background-clip: padding-box; 
				font-size: 13px;

			}
			#tooltip h3, #tooltip div { margin: 0; }


			/*Profil szerkesztés miatt my.css-ből*/

			#countdown{
				margin-bottom: 30px;
			}

			#countdown h3{
				padding: 0;
				text-align: center;
				margin: 0;
				font-size: 16px;
				font-weight: bold;
			}

			#timeleft{
				text-align: center;
				font-size: 12px;
			}

			.timeleft{
				float:none;
				width:auto;
			}

			.resp{
			    height: 35px;
			    line-height: 35px;
				float:right;
			}

			.resp .error{
				position:static;
				line-height:35px;
				display: inline !important;
				float: none !important;
			}














			#cardNum1{
				margin-right:10px;
				width:50px !important;
			}

			#cardNum2{
				margin-left:10px;
				width:50px !important;
			}

			.dash{
				float:left;
			}
			
			.tx{
				height:250px !important;
			}
			
			textarea{
				height:200px;
				width:400px;
			}
			.head{
				display:none;
			}
		</style>
	</head>
	<body id="elonezet">
	
	<div id="wrap">
		<div class="header-wrap">
			<div class="header-outer">
				<header class="wrapper">
					<?php include "../../header.php" ?> 
				</header>
			</div>
		</div>
	<nav>
		<?php
			echo $main->render_felso_menu('');
		?>
	</nav>
	<section id="main" class="wrapper">
		<aside>
			<?php include "../../newsletter.php" ?>
			<h2 id="">Tartalom előnézet</h2>
			<div id="subcontact">
				<h3>1/111-111</h3>
				<h4>web@autoklub.hu</h4>
			</div>
			<?php 
				echo $main->render_hirdetes('regisztraciomegerositese','','','');
			?>
		</aside>
		<section id="content">
			<div class="head">
			</div>
			<div id="inputs">
				<form action="" enctype="multipart/form-data" method="POST">
					<fieldset>
						<h3>Előnézeti adatok</h3>
					<div class="row">
						<label for="h1">Cím</label>
						<input type="text" name="h1" id="h1" /><br />
					</div>
					<div class="row tx">
						<label for="szoveg">Szöveg</label>
						<textarea name="szoveg" id="szoveg"></textarea>
					</div>
					<div class="row">
						<label for="kep">Kép</label>
						<input type="file" name="kep" id="kep" /><br />
					</div>
					</fieldset>
					<input type="submit" value="Előnézet" />
				</form>
			</div>
			<div class="hr"></div>
			<article>
				<h1><?php echo $_POST['h1']; ?></h1>
				<section id="elonezet">
					<div class="rightside">
						<img alt="" src="<?php echo $target_path; ?>">
					</div>
					<div class="leftside">
						<?php echo $_POST['szoveg']; ?>
					</div>
				</section>
			</article>
		</section>
	</section>
	<?php include "../../cta.php" ?>
	<footer>
		<div class="footerIn">
			<div class="wrapper">
				<div id="footerNav">
					<?php 
						echo $main->render_also_menu();
					?>
				</div>
			</div>
		</div>
		<div id="fotterMiscWrap">
			<div id="footerMisc">
				<?php include '../../footer.php';?>
			</div>
		</div>
	</footer>
	</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js">
		</script>
		<script>
window.jQuery || document.write('<script src="lib/js/jquery-1.6.2.js">\x3C/script>')
		</script>
		<script type="text/javascript" src="lib/js/ui-1.8.15.js">
		</script>
		<script type="text/javascript" src="lib/js/main.js">
		</script>
		<script type="text/javascript" src="lib/js/sub.js">
		</script>
		<script>
var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
s.parentNode.insertBefore(g,s)}(document,'script'));
		</script>
	</body>
</html>
<?php 
$main->close();
?>