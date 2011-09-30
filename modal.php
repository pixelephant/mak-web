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
						<a id="forgotten" tabindex="-1" href="#">Elfelejtett a jelszavát?</a>

					</div>
					<div id="login-error"></div>
	        	</div>
	        <div class="hr"></div>
			<div class="bottomrow">
				<input class="yellow-button" type="submit" id="loginSubmit" value="Bejelentkezem" />
		        <label id="chl" for="rememberme"><input type="checkbox" id="rememberme" />Emlékezz rám</label>
				<div id="firsttime">

					<a href="regisztralas">Először jár nálunk? Regisztráljon!</a>
				</div>
			</div>
	</form>
	<a class="close-reveal-modal">&#215;</a>
</div>