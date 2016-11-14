<br><br><br><div id="notify_small_green">

<?php

	$activation_success2 = "<p>Aktywacja przebiegła pomyślnie, możesz teraz się zalogować</p>";
	$reset_complete2 = "<p>Hasło zostało pomyślnie zmienione</p>";
	$reset_password_send_mail2 = "<p>Na podany adres e-mail został wysłany link z resetowaniem hasła.</p>";

if(isset($activation_success))
	echo $activation_success2;

if(isset($account_created))
	echo $account_created;

if(isset($reset_password_send_mail))
	echo $reset_password_send_mail2;

if(isset($reset_complete))
	echo $reset_complete2;

?>


 </div>