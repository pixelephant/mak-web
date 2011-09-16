<?php 
session_start();
?>
<html>
	<head>
	
	</head>
	<body>
	<div id="main_container">
		<div id="form">
			<form action="mak_otp_test_process.php">
				<select name="kartya" id="kartya">
					<option value="bronz">Bronz kártya</option>
					<option value="ezust">Ezüst kártya</option>
					<option value="arany">Arany kártya</option>
				</select>
				<br />
				<select name="fizetesi_mod" id="fizetesi_mod">
					<option value="bank_kartya">Bank kártya</option>
					<option value="atutalas">Átutalás</option>
					<option value="csekk">Csekk</option>
				</select>
				<br />
				<input type="text" name="name" value="Név" size="40" maxlength="50" class="text"/>
				<br />
				<input type="hidden" name="posId" value="#02299991" size="40" maxlength="15" class="text"/>
				<input type="hidden" name="nyelvkod" value="hu" size="5" maxlength="2" class="text"/>
				<input type="hidden" name="tranzakcioAzonosito" size="40" maxlength="32" class="text"/>
				<input type="hidden" name="backURL" value="<?php echo 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) ?>/pdf/visszaigazolas.php" size="40"  class="text"/>
				<button id="submit" value="submit">Elküld</button>
			</form>
			<br />
			<?php 
			
			echo 'Status: '.$_REQUEST['status'];
			
			print_r($_SESSION['response']);
			
			?>
			
		</div>
	</div>
	</body>
</html>