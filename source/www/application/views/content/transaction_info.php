
<p align="center" style="font-size: 45px; color:#22b14c; padding: 0px 0px 0px 10px;"><b>Moje transakcje</b></p>
<table align="center" border="1" style="background-color: #3d3970;">
<tr style="font-size: 25px; color:#92ffa1"><td width="160">ID transakcji</td><td width="180">Status</td><td width="220">Data zakupu</td></tr>


<?php

if(!empty($info))
foreach($info as $inf)
{
	echo "<tr style='font-size:14px; color:white'><td><a style='color:white;' href='/index.php/UserManagement?Transactions&View=".$inf->ID."'>".$inf->ID."</td><td>".$inf->name."</td><td style='font-size:12px;'>".date("d.m.y",$inf->buy_time)."r. o godzinie ".date("H:i:s",$inf->buy_time)."</td></tr>";
}

?>
