<?php
error_reporting(E_ALL ^ E_NOTICE);
$ci =&get_instance();
$ci->load->model("MainPage_Model");

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

 <?php

  $ci->MainPage_Model->ShowProductList();
  $ci->MainPage_Model->ShowUserBar();

?>
      </ul>
    </li>
</ol>
</div>
<br><br><br>
