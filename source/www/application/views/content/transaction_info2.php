
<p align="center" style="font-size: 45px; color:#22b14c; padding: 0px 0px 0px 10px;"><b>Transakcja nr <?php echo $info[0]->payment_id;  ?></b></p>
<table align="center" border="1" style="background-color: #3d3970;">
<tr style="font-size: 25px; color:#92ffa1"><td width="270">Nazwa</td><td width="150">Cena</td><td width="150">Ilość</td><td width="150">Razem</td></tr>


<?php

if(!empty($info))
{
foreach($info as $product)
{

	echo "<tr style='color:white'><td>".$product->product_name."</td><td>".$product->product_cost."zł</td><td>".$product->product_count."</td><td>".$product->product_cost*$product->product_count."zł</td></tr>";


}

?>

</table>

<?php
}
else
{
	echo "<font style='color:white'><p>Niepoprawna transakcja albo nie posiadasz uprawnień do tej transakcji</p></font>";
}

?>