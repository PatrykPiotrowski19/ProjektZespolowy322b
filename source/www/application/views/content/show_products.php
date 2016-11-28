<?php 

$iteration = 0;
?>
<table>
<tr><td width="250" height="1" ></td><td width="380"></td><td width="250" ></td><td width="380"></td><td width="250"></td></tr>



<?php



   foreach($data as $i){ 
   	?>

   	<td><a href="/index.php/Products?ShowProduct=<?php echo $i->ID;   ?>"><img src="/visual/product_images/<?php echo $i->imagename; ?>" width="250"></a><p><font style="color:#77baff"><b><?php echo $i->nazwa_produktu; ?></b></p><p><font style="color: orange; text-align: left"><?php echo $i->cena_produktu; ?>zł</p></font></td>



<?php

	$iteration++;

if($iteration % 3 ==0 && $iteration > 0)
{
	echo "</tr><tr>";
} 

   } 
       ?>
</table>
<!--
<table align="center">
<tr><td width="250" height="450" style="background-color: silver"></td><td width="180"></td><td width="250" height="450" style="background-color: #052222"></td><td width="180"></td><td width="250" height="450" style="background-color: orange"></td></tr>
<tr><td>Sony Xperia M</td><td></td><td>Sony Xperia M</td><td></td><td>Sony Xperia M</td></tr>
<tr><td>529zł</td><td></td><td>529zł</td><td></td><td>529zł</td></tr>
</table><br><br>
-->

