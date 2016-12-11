
<div align="left" style="padding: 0px 0px 0px 10px;">
<p align="left" style="font-size: 35px; color: white;">Czy na pewno chcesz kupić:</p>

<?php


if(isset($Change_number_error))
{
		echo '<p><font size="4" color="red"><div id="notify_small_red"><p>Nie można było zwiększyć ilości produktów (za mało w magazynie/błąd systemu).</p></div></font></p>';
}

$i = 0;
$sum = 0;

	while(isset($img_url[$i]))
	{
		echo '<p align="left" style="color:white; padding: 0px 0px 0px 15px; font-size:19px;">- '.$product_name[$i].' w ilości '.$product_count[$i].'</p>';

		$sum += $product_count[$i]*$product_cost[$i];

		$i++;
	}

?>


<br><p align="left" style="font-size: 35px; color: white;">Wybierz opcję dostawy:</p>
<form action="/index.php/Cart/Checkout/" method="POST">
<select style="font-size:16px;" name="opcjaprzesylki">
<?php foreach($delivery_option as $i){

		echo '<option value='.$i->ID.'>'.$i->nazwa_przesylki.' - '.$i->koszt.'zł</option>';


	}?>
		</select>

<p align="left" style="font-size: 27px; color: white;">Łącznie: <?php echo $sum;  ?>zł + koszt przesyłki</p>
<a href="/index.php/Cart" style="color: inherit; text-decoration:none; font-size:22px; color:red; padding: 0px 35px 0px 0px">< Wróć</a>
<input style="font-size: 32px; background-color: orange;" type="submit" name="finalbuy" value="KUP"></a>
</form>
</div>