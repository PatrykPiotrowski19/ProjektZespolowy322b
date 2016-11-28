<?php

if(isset($nazwa))
{

?>
<br><br><br><br>



<table align="left">
<tr><td width="270"><img width="250" src="http://cellutronics.co.nz/images/Sony_Xperia_M.png"></td></tr>
</table>

<table align="left">
<tr>
<td width="45"></td><td width="720" align="left" color="#5a98ff" style="color: #5a98ff"><font size="10"><?php echo $nazwa; ?></font></p></td></tr>
</td><td></td><td align="left"><font size="6" color="orange">Cena: <?php echo $cena ?>zł</font></td></tr>
<td></td><td align="left"><font size="5" color="orange">Ilość: <?php echo $ilosc  ?> szt</font></td></tr>
<tr><td></td><td align="right"><input type="submit" value="Dodaj do koszyka" name="dodaj_do_koszyka"></td></tr>
<tr><td></td><td align="right"><input type="submit" value="         KUP!         " name="kup"></td></tr>

<tr><td></td><td align="left" style="color:white; font-size:22px;">Opis produktu:</td></tr>
<tr><td></td><td align="left" width="400" style="color:white; font-size:16px;"><?php echo $opis ?></td></tr>
</table>


<div id="tak" width="230" height="230" style="background-color: white;">
</div>

<?php
}

?>