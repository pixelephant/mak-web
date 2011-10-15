<?php 
 header('Content-Type: text/html; charset=utf-8'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <title>felmeres Management</title>
    
    <link rel="stylesheet" href="felmeresmanagement/smoothness/smoothness.css" />
    <link rel="stylesheet" href="felmeresmanagement/css/ui.jqgrid.css" />
    <link rel="stylesheet" href="../lib/css/reset.css" />
    <style type="text/css">
			
			#inputs{
				overflow: hidden;
			    padding: 15px;
			    width: 510px;
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
				min-width: 262px;
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
				border:1px solid black;
				position: relative;
				left: 20px;
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
    
    <script type="text/javascript" src="felmeresmanagement/js/jquery-1.6.2.js"></script>
    <script type="text/javascript" src="felmeresmanagement/js/jquery-ui-1.8.9.js"></script>
    <script type="text/javascript" src="login/login.js"></script>
  </head>
  <body>
    <section id="content">
		<div id="inputs">
			<form>
				<fieldset>
					<h3>Belépés</h3>
					<div id="login">
						<div class="row"><label for="user">Felhasználónév</label><input type="text" name="user" id="user"/></div>
						<div class="row"><label for="pass">Jelszó</label><input type="password" name="pass" id="pass"/></div>
				</fieldset>
				<input id="belepes" type="button" value="Bejelentkezés"/>
			</form>
		</div>
    </section>
  </body>
</html>