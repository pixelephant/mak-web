<?php 

include 'lib/php/Wixel/gump.class.php';

include 'lib/php/class.db.php';
include 'lib/php/class.mak.php';

error_reporting(0);

$main = new mak(false);

if(isset($_POST['search'])){
	$search = trim($_POST['search']);
}

if(isset($_POST['advanced-search-input'])){
	$search = trim($_POST['advanced-search-input']);
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
		<base href="http://www.pixelephant.hu/projects/on-going/mak/" />
		<title>Keresés - Magyar Autóklub</title>		
		<link rel="stylesheet" href="lib/css/reset.css" />
		<link rel="stylesheet" href="lib/css/main.css" />
		<link rel="stylesheet" href="lib/css/sub.css" />
		<link rel="stylesheet" href="lib/smoothness/style.css" />
		<script src="lib/js/modernizr-2.min.js"></script>
	</head>
	<body id="register">
	<div id="wrap">
		<div class="header-wrap">
			<div class="header-outer">
				<header class="wrapper">
					<?php include "header.php" ?> 
				</header>
			</div>
		</div>
	<nav>
		<?php
			echo $main->render_felso_menu();
		?>
	</nav>
	<section id="main" class="wrapper">
		<aside>
			<?php include "newsletter.php" ?>
			<div id="subcontact">
				<h3>1/111-111</h3>
				<h4>web@autoklub.hu</h4>
			</div>
			<?php include "ad.php" ?>
		</aside>
		<section id="content">
		<article>
			<h1>Kártya összehasonlítás</h1>
			<table class="mak-table" id="compare" valign="center">
				<thead>
					<tr>
						<th></th>
						<th id="compare-diszkont">Diszkont</th>
						<th id="compare-standard">Standard</th>
						<th id="compare-komfort">Komfort</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td></td>
						<td><a href="/regisztralas" class="gray-button">Belépek</a></td>						
						<td><a href="/regisztralas" class="gray-button">Belépek</a></td>
						<td><a href="/regisztralas" class="gray-button">Belépek</a></td>
					</tr>
				</tfoot>
				<tbody>
					<tr>
						<td>Szállás</td>
						<td></td>
						<td></td>
						<td class="pipa"><img src="img/tick-blue.png" /></td>
					</tr>
					<tr>
						<td>Gépjármű tárolás szerviz nyitásig</td>
						<td></td>
						<td></td>
						<td class="pipa"><img src="img/tick-blue.png" /></td>
					</tr>
					<tr>
						<td>Haza(tovább) utazás vasúton/távolsági autóbusszal</td>
						<td></td>
						<td></td>
						<td class="pipa"><img src="img/tick-blue.png" /></td>
					</tr>
					<tr>
						<td>Visszautazás gépjárműért vasúton/távolsági autóbusszal</td>
						<td></td>
						<td></td>
						<td class="pipa"><img src="img/tick-blue.png" /></td>
					</tr>
					<tr>
						<td>Csereautó</td>
						<td></td>
						<td></td>
						<td class="pipa"><img src="img/tick-blue.png" /></td>
					</tr>
					<tr>
						<td>Segélyszolgálat</td>
						<td></td>
						<td class="pipa"><img src="img/tick-blue.png" /></td>
						<td class="pipa"><img src="img/tick-blue.png" /></td>
					</tr>
					<tr>
						<td>Jogi tanácsadás</td>
						<td></td>
						<td class="pipa"><img src="img/tick-blue.png" /></td>
						<td class="pipa"><img src="img/tick-blue.png" /></td>
					</tr>
					<tr>
						<td>Baleseti helyszínelés</td>
						<td></td>
						<td></td>
						<td class="pipa"><img src="img/tick-blue.png" /></td>
					</tr>
					<tr>
						<td>Autósélet</td>
						<td></td>
						<td class="pipa"><img src="img/tick-blue.png" /></td>
						<td class="pipa"><img src="img/tick-blue.png" /></td>
					</tr>
					<tr>
						<td>Csoportos élet- és balesetbiztosítás</td>
						<td></td>
						<td class="pipa"><img src="img/tick-blue.png" /></td>
						<td class="pipa"><img src="img/tick-blue.png" /></td>
					</tr>
					<tr>
						<td>Taxi a műszaki hiba helyétől a legközelebbi vasút/buszállomásra</td>
						<td></td>
						<td class="pipa"><img src="img/tick-blue.png" /></td>
						<td class="pipa"><img src="img/tick-blue.png" /></td>
					</tr>
					<tr>
						<td>Speciális segélyhívó telefon: 188</td>
						<td class="pipa"><img src="img/tick-blue.png" /></td>
						<td class="pipa"><img src="img/tick-blue.png" /></td>
						<td class="pipa"><img src="img/tick-blue.png" /></td>
					</tr>
					<tr>
						<td>Gépjármű szállítás legközelebbi szervizbe</td>
						<td class="percentage"><img src="img/dot.png" /></td>
						<td class="pipa"><img src="img/tick-blue.png" /></td> 
						<td class="pipa"><img src="img/tick-blue.png" /></td>
					</tr>
					<tr>
						<td>MAK műszaki szolgáltatások</td>
						<td></td>
						<td class="percentage"><img src="img/dot.png" /></td>
						<td class="pipa"><img src="img/tick-blue.png" /></td>
					</tr>
					<tr>
						<td>Gépjármű hazaszállítás</td>
						<td></td>
						<td class="percentage"><img src="img/dot.png" /></td>
						<td class="pipa"><img src="img/tick-blue.png" /></td>
					</tr>
					<tr>
						<td>Gépjárművezető képzés</td>
						<td class="percentage"><img src="img/dot.png" /></td>
						<td class="percentage"><img src="img/dot.png" /></td>
						<td class="percentage"><img src="img/dot.png" /></td>
					</tr>
					<tr>
						<td>Bérautó (Assistrent)</td>
						<td class="percentage"><img src="img/dot.png" /></td>
						<td class="percentage"><img src="img/dot.png" /></td>
						<td class="percentage"><img src="img/dot.png" /></td>
					</tr>
					<tr>
						<td>Gépjármű biztosítások (kötelező, casco)</td>
						<td class="percentage"><img src="img/dot.png" /></td>
						<td class="percentage"><img src="img/dot.png" /></td>
						<td class="percentage"><img src="img/dot.png" /></td>
					</tr>
					<tr>
						<td>Utazási biztosítáok (BBP)</td>
						<td class="percentage"><img src="img/dot.png" /></td>
						<td class="percentage"><img src="img/dot.png" /></td>
						<td class="percentage"><img src="img/dot.png" /></td>
					</tr>
					<tr>
						<td>Szervezett Autoclub Travel utazások</td>
						<td class="percentage"><img src="img/dot.png" /></td>
						<td class="percentage"><img src="img/dot.png" /></td>
						<td class="percentage"><img src="img/dot.png" /></td>
					</tr>
					<tr>
						<td>Klub cikkek</td>
						<td class="percentage"><img src="img/dot.png" /></td>
						<td class="percentage"><img src="img/dot.png" /></td>
						<td class="percentage"><img src="img/dot.png" /></td>
					</tr>
					<tr>
						<td>Bizományosi cikkek (térképek, útikönyvek, úti cikkek)</td>
						<td class="percentage"><img src="img/dot.png" /></td>
						<td class="percentage"><img src="img/dot.png" /></td>
						<td class="percentage"><img src="img/dot.png" /></td>
					</tr>
					<tr>
						<td>Egyéb kedvezmények</td>
						<td class="percentage"><img src="img/dot.png" /></td>
						<td class="percentage"><img src="img/dot.png" /></td>
						<td class="percentage"><img src="img/dot.png" /></td>
					</tr>
					<tr>
						<td>Külföldi partnerek szolgáltatói kedvezménye: Show your Card!</td>
						<td class="percentage"><img src="img/dot.png" /></td>
						<td class="percentage"><img src="img/dot.png" /></td>
						<td class="percentage"><img src="img/dot.png" /></td>
					</tr>
				</tbody>
			</table>
			<div id="seged">
				<p><strong>Nem tud dönteni?</strong> <a href="#">Próbálja ki kártyaválasztó segédünket! <img src="img/right_02.png" alt="" /></a></p>
			</div>
			
			
			<div id="jatek">
				<div id="jatek-bg">
					<img src="img/jatek/1.png" data-correct="1" alt="" />
					<img src="img/jatek/2.png" data-correct="2" alt="" />
					<img src="img/jatek/3.png" data-correct="3" alt="" />
					<img src="img/jatek/4.png" data-correct="4" alt="" />
					<img src="img/jatek/5.png" data-correct="5" alt="" />
				</div>
				<div id="choices">
					<select name="choice-select" id="choice-select">
						<option value="1">Egyes szám</option>
						<option value="2">Kettes szám</option>
						<option value="3">Hármas szám</option>
						<option value="4">Négyes szám</option>
						<option value="5">Ötös szám</option>
					</select>
					<button id="tipp">Ok</button>
				</div>
				<div id="score">
					<button id="startgame">Start</button>
					<span id="currentscore">0</span>
				</div>
			</div>
			
		</article>					
		</section>
	</section>
	<?php include "cta.php" ?>
	<footer>
		<div class="wrapper">
			<div id="footerNav">
				<?php 
					echo $main->render_also_menu();
				?>
			</div>
			<div id="footerMisc">
				<?php include 'footer.php';?>
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
		<script type="text/javascript">
		/*
* jQuery.fn.rand();
*
* Return a random, but defined numbers of elements from a jQuery Object.
* $('element').rand(); // returns one element from the jQuery Object.
* $('element').rand(4); // returns four elements from the jQuery Object.
*
* Version 0.8.5
* www.labs.skengdon.com/rand
* www.labs.skengdon.com/rand/js/rand.min.js
*
* And:
* http://phpjs.org/functions/array_rand:332
*/
;(function($){$.fn.rand=function(number){var array_rand=function(input,num_req){var indexes=[];var ticks=num_req||1;var checkDuplicate=function(input,value){var exist=false,index=0;while(index<input.length){if(input[index]===value){exist=true;break;};index++;};return exist;};while(true){var rand=Math.floor((Math.random()*input.length));if(indexes.length===ticks){break;};if(!checkDuplicate(indexes,rand)){indexes.push(rand);}};return((ticks==1)?indexes.join():indexes);};if(typeof number!=='number')var number=1;if(number>this.length)number=this.length;var numbers=array_rand(this,number);var $return=[];for(var i=0;i<number;i++){$return[i]=this.get(numbers[i]);};return $($return);};}(jQuery));
		
		$("#jatek-bg").find("img").hide();
		
		var correctNo = 0;
		
		
		$("#startgame").click(function(){
			startGame();
		});
		
		function startGame(){
			var $items = $("#jatek-bg").find("img").rand(5);
			$("#jatek-bg").empty().append($items);
			$items.eq(0).addClass("current").fadeIn();
		}
		
		$("#tipp").click(function(){
			if($("#jatek-bg .current").data("correct") == $("#choice-select").find("option:selected").val()){
				correctNo++;
				$("#currentscore").css("background","green").html(correctNo);
				$("#jatek-bg .current").fadeOut().removeClass("current").next("img").addClass("current").fadeIn();
			}
			else{
				$("#jatek-bg .current").fadeOut().removeClass("current").next("img").addClass("current").fadeIn();
				$("#currentscore").css("background","red");
			}
		});
		
		</script>
		<script>
var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
s.parentNode.insertBefore(g,s)}(document,'script'));
		</script>
	</body>
</html>