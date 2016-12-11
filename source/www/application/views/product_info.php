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


<div id="tak" width="230" height="230" style="background-color: white;">

</div>

<?php
}

?>