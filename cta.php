<?php 
	if(isset($_SESSION['tagsag']) && $_SESSION['tagsag'] == 0){
		echo '<section id="ctaWrap">
	<div id="cta" class="wrapper">
		<h3>Legyen Ön is klubtag!</h3>
		<ul>
			<li>Kedvezményes Assistance szolgáltatás</li>
			<li>Megbízható háttér</li>
			<li>Évszázados tapasztalat</li>
		</ul>
		<div class="a">
			<a class="yellow-button" href="enautoklubom/beallitasok/tagsag"><span>Tagbelépés</span> <em></em></a>
		</div>
	</div>
</section>';
	}elseif(isset($_SESSION['user_id'])){
		
	}else{
		echo '<section id="ctaWrap">
	<div id="cta" class="wrapper">
		<h3>Legyen Ön is klubtag!</h3>
		<ul>
			<li>Kedvezményes Assistance szolgáltatás</li>
			<li>Megbízható háttér</li>
			<li>Évszázados tapasztalat</li>
		</ul>
		<div class="a">
			<a class="yellow-button" href="regisztralas"><span>Tagbelépés</span> <em></em></a>
		</div>
	</div>
</section>';
	}
?>