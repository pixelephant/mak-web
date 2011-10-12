<?php 
/*
 * Keresés,
 * Hírlevél feliratkozás,
 * Facebook,
 * Twitter
 * az oldal bal oldalára.
 * Link a nem regisztráltaknak a regisztráció menüpontra 
 */
?>
<div id="search">
	<form action="kereses" method="POST">
		<input type="text" name="search" placeholder="Keresés..." /><input type="submit" value="Keresés" class="yellow-button" />
	</form>
</div>
<div class="hr"></div>
<div id="newsletter">
	<a href="http://facebook.com" id="facebook" target="_blank"><img height="40" src="img/fb.png" alt="Facebook" /></a>
	<!-- a href="http://twitter.com" id="twitter" target="_blank"><img height="40" src="img/tw.png" alt="Twitter" /></a-->
	<a id="newsletterbutton" class="gray-button" href="#"><span>Hírlevél</span> <em></em></a>
	<form id="newsletter-form" action="#">
		<div>
		<input type="text" class="required email" name="newsletter-mail" id="newsletter-mail" placeholder="Email cím" /><input type="submit" value="Ok" class="yellow-button" />
		</div>
	</form>
	<div id="newsletter-response"></div>
</div>
<div class="hr"></div>
<?php 
	if(isset($_SESSION['tagsag']) && $_SESSION['tagsag'] == 0){
		echo '<a href="enautoklubom/beallitasok/tagsag" id="side-cta" class="black-button"><span>Tagbelépés</span><em></em></a><div class="hr"></div>';
	}elseif(isset($_SESSION['user_id'])){
		
	}else{
		echo '<a href="regisztralas" id="side-cta" class="black-button"><span>Tagbelépés</span><em></em></a><div class="hr"></div>';
	}
?>

