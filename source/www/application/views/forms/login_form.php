
 <div id="wrapper">
	<form name="login-form" class="login-form" action="/index.php/UserManagement?Login" method="post">
	
		<div class="header">
		<h1>Logowanie do sklepu</h1>
		</div>
	
		<div class="content">
		<input name="login" type="text" class="input username" placeholder="login" />
		<div class="user-icon"></div>
		<input name="password" type="password" class="input password" placeholder="hasło" />
		<div class="pass-icon"></div>		
		</div>

		<div class="footer">
		<font size="2"><a href="/index.php/UserManagement?ResetPassword"><i>Nie pamiętam hasła</i></font></a>
		<input type="submit" name="submit_login" value="Zaloguj" class="button" />
		</div>
	
	</form>

</div>