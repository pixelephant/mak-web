<h1><a href="">Magyar Autóklub</a></h1>
<div id="headerButtons">
	<div id="loginContainer">
		<a href="#" id="segelyButton"><img src="img/pictogram-01.png" alt="Segélyszolgálat" /></a>
		<a href="#" id="szervizButton"><img src="img/pictogram-03.png" alt="Szervizpontok" /></a>
		<a href="#" id="kozlekButton"><img src="img/pictogram-04.png" alt="Közlekedésbiztonság" /></a>
		<a href="#" id="travelButton"><img src="img/pictogram-02.png" alt="Travel" /></a>
		<a href="#" data-reveal-id="loginModal" id="loginButton"><span>Bejelentkezés</span><em></em></a>
		<div id="loginModal" class="reveal-modal">
			<form id="loginform" action="#">
					<h2>Bejelentkezés</h2>
			        <fieldset>
			        	<div class="row">
			        		<label for="loginEmail">Email cím</label>
				            <input type="text" name="loginEmail" class="required email" id="loginEmail" />
			        	</div>
			        	<div class="row">
			        		<label for="loginPassword">Jelszó</label>
				            <input class="required" type="password" name="loginPassword" id="loginPassword" />
				            <a id="forgotten" href="#">Elfelejtett jelszó?</a>
			        	</div>
			        </fieldset>
			        <input type="submit" id="loginSubmit" value="Belépés" />
			        <label id="chl" for="checkbox"><input type="checkbox" id="rememberme" />Emlékezz rám</label>
					<div>
						<a href="register.php">Még nem klubtagunk? Regisztráljon!</a>
					</div>
			</form>
			<a class="close-reveal-modal">&#215;</a>
		</div>
	</div>				
</div>
<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>
<a id="skypeButton" href="skype:zoltan_dublin?call"><img src="http://mystatus.skype.com/smallclassic/zoltan_dublin" style="border: none;" width="114" height="20" alt="My status" /></a>