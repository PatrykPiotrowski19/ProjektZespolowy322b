 <div id="wrapper">
	<form name="login-form" class="login-form" action="/index.php/UserManagement?reset

<?php
if(isset($_POST["token_pass"]))
	echo "=".$_POST["token_pass"];
else
	echo "=".$_GET["reset"];
?>

	" method="post">
	
		<div class="header">
		<h1>Resetowanie hasła</h1>
		</div>
		<font size="2"><p>Podaj swoje nowe hasło</p></font>
		<div class="content">
		<input name="password" type="password" class="input password" placeholder="hasło" />
		<input name="password2" type="password" class="input password" placeholder="powtórz hasło" />
		<input name="token_pass" type="hidden" class="input password" placeholder="hasło"
<?php
	echo 'value="'.$_GET["reset"].'"';


?>
		/>
		</div>

		<div class="footer">
		<input type="submit" name="submit_reset_password" value="Resetuj hasło" class="button" />
		</div>
	
	</form>

</div>