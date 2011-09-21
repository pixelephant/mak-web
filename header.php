<?php

$kartya[1] = 'Kék (régi)';
$kartya[2] = 'Diszkont';
$kartya[3] = 'Standard';
$kartya[4] = 'Komfort';
$kartya[5] = 'Diszkont plusz';

?>
<h1><a href="">Magyar Autóklub<span>A hűséges Partner</span></a></h1>

<?php 
if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != ''){
?>
	<div id="userBar">
		<span>Üdvözöljük <strong id="logedInName"><?php echo $_SESSION['keresztnev']; ?></strong> | Ön <strong id="loggedInKlubtagsag"><?php echo (isset($kartya[$_SESSION['tagsag']]) ? $kartya[$_SESSION['tagsag']] : 'nem'); ?></strong> klubtagunk.</span>
	</div>
<?php 
}
?>
<div id="headerButtons">
	<div id="loginContainer">
		<a href="segelyszolgalat" id="segelyButton" class="gray-button"><img src="img/pictogram-01.png" alt="Segélyszolgálat" /></a>
		<a href="szervizpontok" id="szervizButton" class="gray-button"><img src="img/pictogram-03.png" alt="Szervizpontok" /></a>
		<a href="kozlekedesbiztonsag" id="kozlekButton" class="gray-button"><img src="img/pictogram-04.png" alt="Közlekedésbiztonság" /></a>
		<a href="travel" id="travelButton" class="gray-button"><img src="img/pictogram-02.png" alt="Travel" /></a>
<?php 
	if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != ''){
?>
		<a href="#" id="logoutButton" class="gray-button"><span>Kijelentkezés</span><em></em></a>
<?php
	}else{
?>			
		<a href="#" data-reveal-id="loginModal" id="loginButton" class="gray-button"><span>Bejelentkezés</span><em></em></a>
		<div id="loginModal" class="reveal-modal">
			<form id="loginform" action="#">
					<h2>Bejelentkezés</h2>
					<div class="hr"></div>
			        	<div id="login-form-inner">
			        		<div class="row">
			        		<label for="loginEmail">Email cím</label>
				            <input type="text" name="loginEmail" class="required email" id="loginEmail" />
							</div>
							<div class="row">
								<label for="loginPassword">Jelszó</label>
								<input class="required" type="password" name="loginPassword" id="loginPassword" />
								<a id="forgotten" href="#">Elfelejtett a jelszavát?</a>
							</div>
							<div id="login-error"></div>
			        	</div>
			        <div class="hr"></div>
					<div class="bottomrow">
						<input class="yellow-button" type="submit" id="loginSubmit" value="Bejelentkezem" />
				        <label id="chl" for="rememberme"><input type="checkbox" id="rememberme" />Emlékezz rám</label>
						<div>
							<a href="regisztralok">Először jár nálunk? Regisztráljon!</a>
						</div>
					</div>
			</form>
			<a class="close-reveal-modal">&#215;</a>
		</div>
<?php 
	}
?>			
	</div>				
</div>
<!--
<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>
<a id="skypeButton" href="skype:zoltan_dublin?call"><img src="http://mystatus.skype.com/smallclassic/zoltan_dublin" style="border: none;" width="114" height="20" alt="My status" /></a>-->