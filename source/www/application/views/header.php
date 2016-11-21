<?php
//error_reporting(E_ALL ^ E_NOTICE);
$this->load->library('session');
$this->load->database();


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
            $query = $this->db->query("SELECT * FROM `category`");



            foreach ($query->result() as $row){


         
echo '<li><a href="#">'.$row->name.'</a>';

 ?>
   
      <ul>
<?php
          $query2 = $this->db->query("SELECT * from `subcategory` WHERE `category_id` = ".$row->ID." order by `ID`");

          foreach($query2->result() as $row2){

            echo '<li><a href="#">'.$row2->name.'</a></li>';
          }

  ?>
      </ul>
    </li>

<?php
   }
    
?>
<ol id="account">
<li><a href="#"><?php
if(isset($_SESSION["username"]) && !empty($_SESSION["username"])){
	echo "Witaj ".$_SESSION["username"];
}
else
	echo "Konto";
?>
  
</a>
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
