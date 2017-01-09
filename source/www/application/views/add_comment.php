<?php

if(isset($success))
{

echo '<p align="center"><font color="green" style="font-size: 15px;">Komentarz został prawidłowo wystawiony.</font></p>';

}
else
{

?>
<form action="/index.php/Comments?add_comment=<?php echo $token;?>" method="POST"><font color="white">
<p>Oceń jakość produktu: <input type="number" name="val1" value="5" min="1" max="10"></p>
<p>Oceń jakość obsługi: <input type="number" name="val2" value="5" min="1" max="10"></p>
<p>Oceń szybkość obsługi: <input type="number" name="val3" value="5" min="1" max="10"></p>
<p>Komentarz: </p><textarea id="description" name="description" rows="3" cols="40"></textarea><br>
<input type="submit" name="send_comment" value="Wyślij"></input>

</font>
</td></tr>
</form>

<?php
}

?>