
<p align="center" style="font-size: 45px; color:#22b14c; padding: 0px 0px 0px 10px;"><b>Twój koszyk</b></p>
<table align="center" border="1" style="background-color: #3d3970;">
<tr style="font-size: 25px; color:#92ffa1"><td width="150">Produkt</td><td width="300"></td><td width="150">Cena</td><td width="150">Ilość</td><td width="150">Razem</td><td width="90">Usuń</td></tr>


<?php


if(isset($Change_number_error))
{
		echo '<p><font size="4" color="red"><div id="notify_small_red"><p>Nie można było zwiększyć ilości produktów (za mało w magazynie/błąd systemu).</p></div></font></p>';
}

$i = 0;
$sum = 0;

	while(isset($img_url[$i]))
	{
		echo '<tr style="color:white;"><td><img align="center" width="80" src="'.$img_url[$i].'"></td><td style="font-size: 22px;">'.$product_name[$i].'</td><td>'.$product_cost[$i].'zł</td><td><font style="font-size:35px; color:green;">'.$product_count[$i].'</font>
			<form action="/index.php/Cart" method="GET">
			Zmien ilość<br><br><input type="number" min="1" value="'.$product_count[$i].'" style="width:40px;" name="Value">
			<input type="hidden" value="'.$product_id[$i].'" name="product_id">
			<input type="submit" value="Nowa ilość" name="ZmienIlosc">
			</form>

			</td><td>'.$product_count[$i]*$product_cost[$i].'zł</td><td>
			<p style="font-size: 20px; color:yellow"><a href="/index.php/Cart?remove='.$product_id[$i].'" style="color: inherit; text-decoration:none;">Usuń</a></p>

			</td></tr>';

		$sum += $product_count[$i]*$product_cost[$i];

		$i++;
	}

?>

</table>
<p style="font-size: 30px; color: white;">Razem: <?php echo $sum;  ?>zł</p>
<a href="/index.php/Cart/Checkout"><input style="font-size: 32px; background-color: orange;"type="submit" name="KUP" value="KUP"></a>