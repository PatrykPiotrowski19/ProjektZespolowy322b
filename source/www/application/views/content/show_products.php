<?php 

$iteration = 0;
?>

<div style="text-align: left; width:200px; position: absolute;">
<font color="white">

<p align="center"><font size="5">Filtry</p></font><br>
<p align="center"><b>Cena</b></p>
<form action="/index.php/Products" method="GET">
<input type="hidden" name="Subcategory" value="<?php echo $_GET['Subcategory']; ?>">
<center><p>od <input type="number" name="cost_min" size="1" min="0" step="0.01" style="width: 80px"></p>
<p>do <input type="number" name="cost_max" min="0" step="0.01" style="width: 80px"></p></center>
<?php

$i = 0;
$last_filter_name = "NULL";
$last_subfilter_name = "NULL";
if(!empty($filters))
foreach($filters as $filtry)
{

	if($last_filter_name != $filtry->name)
	{
		$last_filter_name = $filtry->name;
		echo '<p align="center"><b>'.$filtry->name.'</b></p>';

	}

	if($last_subfilter_name != $filtry->value)
	{
		$last_subfilter_name = $filtry->value;
		//echo '<center><input type="checkbox" name="'.$filtry->value.'" value="'.$filtry->filter_val_id.'">'.$filtry->value.'<br></<center>';
		echo '<center><input type="checkbox" name="Filter[]" value="'.$filtry->filter_val_id.'">'.$filtry->value.'<br></center>';
	}


	if($i == 0)
	{
		$last_filter_name = $filtry->name;
		$last_subfilter_name = $filtry->value;
	}
	$i++;
}
?>
<center><br><br><input type="submit" value="Filtruj" style="width:78px; height: 28px; font-size: 20px; background-color: silver"></center>


</form>
</font>
</div>
<div style="width: 760px; margin: auto";><table align="center">
<tr><td width="250" height="1" ></td><td width="380"></td><td width="250" ></td><td width="380"></td><td width="250"></td></tr>



<?php


if(empty($data))
{
	echo "<font style='color:red; font-size:18px'><p>Brak produktów spełniających kryteria</p></font>";
}

   foreach($data as $i){ 
   	?>

   	<td><a href="/index.php/Products?ShowProduct=<?php echo $i->ID;   ?>"><img src="<?php echo $i->imagename; ?>" width="250"></a><p><font style="color:#77baff"><b><?php echo $i->nazwa_produktu; ?></b></p><p><font style="color: orange; text-align: left"><?php echo $i->cena_produktu; ?>zł</p></font></td>



<?php

	$iteration++;

if($iteration % 3 ==0 && $iteration > 0)
{
	echo "</tr><tr>";
} 

   } 
       ?>
</table>
</div>
<!--
<table align="center">
<tr><td width="250" height="450" style="background-color: silver"></td><td width="180"></td><td width="250" height="450" style="background-color: #052222"></td><td width="180"></td><td width="250" height="450" style="background-color: orange"></td></tr>
<tr><td>Sony Xperia M</td><td></td><td>Sony Xperia M</td><td></td><td>Sony Xperia M</td></tr>
<tr><td>529zł</td><td></td><td>529zł</td><td></td><td>529zł</td></tr>
</table><br><br>
-->

