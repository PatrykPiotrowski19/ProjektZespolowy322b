<?php

$this->load->library('session');

?>

<!DOCTYPE HTML>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="Sklep internetowy" />
    <meta http-equiv="Content-type" content="text/html; charset=ISO-8859-2" />
   	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/visual/style/style.css">
    <link rel="stylesheet" type="text/css" href="/visual/style/menu.css">
    <link rel="stylesheet" type="text/css" href="/visual/style/login_form.css">
	<title>Sklep internetowy</title>
</head>

<body style="height: 100%;  font-family: Lato,sans-serif; text-align: center; font-size:16px">
<div id="menu" ><a href="/index.php"><img src="/visual/img/logo.png" align="left" height="50px" width="320px"></img></a>
 <ol>
    <li><a href="#">Produkty</a>
      <ul>
        <li><a href="#">link - 1</a></li>
        <li><a href="#">link - 2</a></li>
        <li><a href="#">link - 3</a></li>
        <li><a href="#">link - 4</a></li>
        <li><a href="#">link - 5</a></li>
      </ul>
    </li>

    <li><a href="#">menu - 2</a>
      <ul>
        <li><a href="#">link - 1</a></li>
        <li><a href="#">link - 2</a></li>
        <li><a href="#">link - 3</a></li>
      </ul>
    </li>
  </ol>
  
<ol id="account">
<li><a href="#"><?php
if(isset($_SESSION["username"]) && !empty($_SESSION["username"])){
	echo "Witaj ".$_SESSION["username"];
}
else
	echo "Konto";
?></a>
      <ul>
	  <?php
	  if(isset($_SESSION["username"]) && !empty($_SESSION["username"])){
		  echo '<li><a href="/index.php/UserManagement?Logout">Wyloguj się</a></li>';
	  }
	  else
	  	  echo '	  
        <li><a href="/index.php/UserManagement?Login">Logowanie</a></li>
        <li><a id="button" href="/index.php/UserManagement?Register">Rejestracja</a></li>';
	  
	  ?>
      </ul>
    </li>
</ol>
</div>
