<br><br><br><div id="notify_small2_red">

<?php 


if(isset($activation_invalid_token))
	echo $activation_invalid_token;

if(isset($login_unactive))
	echo $login_unactive;

if(isset($username_short))
	echo $username_short;

if(isset($username_empty))
	echo $username_empty;

if(isset($username_busy))
	echo $username_busy;

if(isset($password_short))
	echo $password_short;

if(isset($password_differents))
	echo $password_differents;

if(isset($password_empty))
	echo $password_empty;

if(isset($register_name_error))
	echo $register_name_error;

if(isset($register_surname_error))
	echo $register_surname_error;

if(isset($register_processing))
	echo $register_processing;

if(isset($login_empty_username))
	echo $login_empty_username;

if(isset($login_empty_password))
	echo $login_empty_password;

if(isset($register_postalcode_error))
	echo $register_postalcode_error;

if(isset($register_city_error))
	echo $register_city_error;

if(isset($register_address_error))
	echo $register_address_error;

if(isset($login_invalid_login_pass))
	echo $login_invalid_login_pass;

if(isset($register_invalid_mail))
	echo $register_invalid_mail;

if(isset($register_mail_busy))
	echo $register_mail_busy;

if(isset($reset_password_empty))
	echo $reset_password_empty;

if(isset($reset_password_invalid_mail))
	echo $reset_password_invalid_mail;

if(isset($reset_token_expired))
	echo $reset_token_expired;

if(isset($rules_error))
	echo $rules_error;

if(isset($reset_invalid_token))
	echo $reset_invalid_token;


if(isset($all))
	echo $all;

 ?>

 </div>
