 <div id="wrapper">
	<form name="login-form" class="login-form" action="/index.php/UserManagement?Register" method="post">
	
		<div class="header">
		<h1>Rejestracja</h1>
		</div>
	
		<div class="content">
		<input name="login" type="text" class="input username" placeholder="login" 
<?php

if(isset($_POST["login"]) && !empty($_POST["login"]))	echo	"value=".$_POST["login"];

?>
		/>
		<div class="user-icon"></div>
		<input name="password" type="password" class="input password" placeholder="hasło" />
		<div class="pass-icon"></div>	
		<input name="password2" type="password" class="input password" placeholder="powtórz hasło" /><br /><br />
        <input name="mail" type="text" class="input username" placeholder="E-mail" 
<?php

if(isset($_POST["mail"]) && !empty($_POST["mail"]))	echo	"value=".$_POST["mail"];

?>
        /><br /><br />
        <input name="name" type="text" class="input username" placeholder="Imię" 
<?php

if(isset($_POST["name"]) && !empty($_POST["name"]))	echo	"value=".$_POST["name"];

?>

       	/><br /><br />
        <input name="surname" type="text" class="input username" placeholder="Nazwisko" 
<?php

if(isset($_POST["surname"]) && !empty($_POST["surname"]))	echo	"value=".$_POST["surname"];

?>

        />  <br /><br />
        <input name="adres" type="text" class="input username" placeholder="Adres zamieszkania"
<?php

if(isset($_POST["adres"]) && !empty($_POST["adres"]))	echo	"value=".$_POST["adres"];

?>

        /><br /><br />
        <input name="kod_pocztowy" type="code" class="input username" placeholder="Kod pocztowy"
<?php

if(isset($_POST["kod_pocztowy"]) && !empty($_POST["kod_pocztowy"]))	echo	"value=".$_POST["kod_pocztowy"];

?>

        /><br /><br />
        <input name="miasto" type="code" class="input username" placeholder="Miasto"
<?php

if(isset($_POST["miasto"]) && !empty($_POST["miasto"]))	echo "value=".$_POST["miasto"];
?>

        /><br />
	   </div>

		<div class="footer">
        <font style="font-family: Lato,sans-serif; text-align: center; font-size:10px">
        <input name="regulamin" type="checkbox" />       
        *Akceptuję <a href="index.php?regulamin">regulamin</a><br />
        <input name="dane" type="checkbox" />       
        *Wyrażam zgodę na przetwarzanie danych<br />
        <input name="newsletter" type="checkbox" />       
        Chcę otrzymywać newsletter<br />
        <b>* - wymagane pola</b><br /><br />
		<input type="submit" name="submit_register" value="Zarejestruj się" class="button" />
        </font>
		</div>
	
	</form>

</div>