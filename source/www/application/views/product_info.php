<?php

if(isset($nazwa))
{

?>
<br><br><br><br>



<table align="left">
"<?php
$iter = 0;
foreach($img as $i)
{

	if($iter == 0)
	{
 		 echo '<tr><td width="270"><img width="250" src="'.$i->imagename.'"><br>';
	}
	else
	{
		echo '<img width="80" src="'.$i->imagename.'">';
	}


  $iter++;
}
  ?></td>
</table>

<table align="left">
<tr>
<td width="45"></td><td width="720" align="left" color="#5a98ff" style="color: #5a98ff"><font size="10"><?php echo $nazwa; ?></font></p></td></tr>
</td><td></td><td align="left"><font size="6" color="orange">Cena: <?php echo $cena ?>zł</font></td></tr>
<td></td><td align="left"><font size="5" color="orange">Ilość: <?php 
if($ilosc > 0)
echo $ilosc." szt";
else
echo "<font color='red'>BRAK W MAGAZYNIE</font>"; ?></font></td></tr>

<tr><td></td><td align="right">
<?php
if($count > 0)
	{
		echo '<center><div><p><font style="font-size:30px;"><font style="color:white">Obecnie posiadasz w koszyku:</font><font style="color:green;"> '.$count.' przedmiotów</font></font></p></div></center>';
	}
?>

<table align="right" width="200" height="150">
<tr><td>
<center>



<?php 
if($ilosc > 0)
{
	?>
<div style="background-color: silver">
<form action="/index.php/Products?ShowProduct=<?php echo $ID; ?>" method="POST">
<p style="font-size:18px;">
<?php

if($count>0)
	echo 'Wprowadź nową ilość</p>';
else
	echo 'Wprowadz ilość</p>';
?>
<input type="number" name="koszyk_ilosc" max="<?php echo $ilosc; ?>" min="1" style="font-size:20px;"></p>
<input type="submit" value="Dodaj do koszyka" name="AddToCart" style="font-size:20px;"><br><br>
<input type="submit" value="KUP!" name="AddToCart" style="font-size:20px;">
</div>
<?php
}
?>
</form>
</center>
</td></tr>
</table>
</td></tr>
<tr><td></td><td align="left" style="color:white; font-size:22px;">Opis produktu:</td></tr>
<tr><td></td><td align="left" width="400" style="color:white; font-size:16px;"><?php echo $opis ?></td></tr>
</table>
</div>
</center>
</td>
</tr>
</div>
<div id="tak" width="230" height="230" style="background-color: white;">
</div>
<?php

if($insert_comments == true)
{

?>
<table width="750" style="padding: 100px 0px 0px 0px;">

<?php

	if(isset($invalid_comment))
	{
		echo '<tr><td><font size="3" color="red"><div id="notify_small_red"><p>BŁĄD. Pole tekstowe komentarza musi zawierać 5-500 znaków</p></div></font></td></tr>';
	}

?>

<tr><td width="320"><p><font style="font-size:22px; color:#ffff00; padding: 0px 0px 0px 0px; ">Wystaw komentarz</p></td></tr>
<tr><td>
<form action="/index.php/Products?ShowProduct=<?php echo $ID;?>" method="POST"><font color="white">
<p>Oceń jakość produktu: <input type="number" name="val1" value="5" min="1" max="10"></p>
<p>Oceń jakość obsługi: <input type="number" name="val2" value="5" min="1" max="10"></p>
<p>Oceń szybkość obsługi: <input type="number" name="val3" value="5" min="1" max="10"></p>
<p>Komentarz: </p><textarea id="description" name="description" rows="3" cols="40"></textarea><br>
<input type="submit" name="send_comment" value="Wyślij"></input>

</font>
</td></tr>
</form>
</table>
<?php
}
?>
<table width="750">
<tr><td></td></tr>
<tr><td><p style="color:#00ff42; font-size:22px;">Komentarze i oceny</p></td></tr>
<?php
//Wyswietlanie komentarzy
if($comments != null)
foreach($comments as $i)
{
echo '<tr><td width="10" style="background-color:#001130"></td></tr><tr><td>
<p align="left" style="color:white; font-size:14px;">



Wystawił: '.$i->LOGIN.'</p><i>
<p align="left" style="color:white; font-size:12px;">Jakość produktu: '.$i->product_quality.'<br>
Jakość obsługi: '.$i->service_quality.'<br>
Szybkość obsługi: '.$i->speed_service.'<br>
</i></p>
<p p align="left" style="color:white; font-size:14px;">Opis: '.$i->comment.'<br>

</p>
</td></tr>';
}
else
{
	echo '<tr><td><p><font size="3" color="red">Brak komentarzy</font></p></td></tr>';
}
?>
</table>
<?php
}

?>