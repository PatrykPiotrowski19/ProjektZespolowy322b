<center>
<br>
<div class="reformed-form" style="background-color: silver;width: 500px; height:880px;text-align: center;
">
<p><font size="6">Dodawanie przedmiotu</font></p>
  <form method="post" name="DodawanieProduktu" id="DodawanieProduktu" action="/index.php/Products?AddNewProduct" enctype="multipart/form-data">
    <dl>
      <dt>
        <label for="Kategoria">Kategoria</label>
      </dt>
      <dd><input type="text" id="Kategoria" name="Kategoria" value="<?php echo $Kategoria; ?>" /></dd>
                <?php if(isset($Utworz_kategorie))  echo ' <button type="submit" name="DodajPrzedmiot" value="DodajPrzedmiot1" style="color:red"><b>Dodaj nową kategorię</b></button>'; ?>
    </dl>
    <dl>
      <dt>
        <label for="Podkategoria">Podkategoria</label>
      </dt>
      <dd><input type="text" id="Podkategoria" name="Podkategoria"  value="<?php echo $Podkategoria; ?>" /></dd>
      <?php if(isset($Utworz_podkategorie))  echo ' <button type="submit" name="DodajPrzedmiot" value="DodajPrzedmiot2" style="color:red"><b>Dodaj nową podkategorię</b></button>'; ?>
    </dl>
    <dl>
      <dt>
        <label for="NazwaPrzedmiotu">Nazwa przedmiotu</label>
      </dt>
      <dd><input type="text" id="NazwaPrzedmiotu" name="NazwaPrzedmiotu"  value="<?php echo $NazwaPrzedmiotu; ?>" /></dd>
    </dl>
    <dl>
      <dt>
        <label for="Ilosc">Ilość</label>
      </dt>
      <dd><center><input type="number" id="Ilosc" class="digits" name="Ilosc" min="1"  value="<?php echo $Ilosc; ?>" /></center></dd>
    </dl>
    <dl>
      <dt>
        <label for="Ilosc">Cena</label>
      </dt>
      <dd><input type="number" id="Cena" class="digits" name="Cena" min="0.01" step="0.01" value="<?php echo $Cena; ?>" /></dd>
    </dl>
    <dl>
      <dt>
        <label for="Zdjecie1">Url Zdjęcia #1 <font color="red">wymagane</font></label>
      </dt>
      <dd><input type="text" size="50" id="Zdjecie1" name="Zdjecie1" value="<?php echo $Zdj1; ?>" /></dd>
    </dl>
    <dl>
      <dt>
        <label for="Zdjecie2">Url Zdjęcia #2</label>
      </dt>
      <dd><input type="text" size="50" id="Zdjecie2" name="Zdjecie2" value="<?php echo $Zdj2; ?>" /></dd>
    </dl>
    <dl>
      <dt>
        <label for="Zdjecie3">Url Zdjęcia #3</label>
      </dt>
      <dd><input type="text" size="50" id="Zdjecie3" name="Zdjecie3"  value="<?php echo $Zdj3; ?>"/></dd>
    </dl>
    <dl>
      <dt>
        <label for="Zdjecie4">Url Zdjęcia #4</label>
      </dt>
      <dd><input type="text" size="50" id="Zdjecie4" name="Zdjecie4"  value="<?php echo $Zdj4; ?>"/></dd>
    </dl>
    <dl>
      <dt>
        <label for="Opis">Opis</label>
      </dt>
      <dd><textarea id="Opis" class="required" name="Opis" rows="10" cols="55"><?php echo $_POST["Opis"]; ?></textarea></dd>
    </dl>
    <div id="submit_buttons">
      <button type="submit" name="DodajPrzedmiot" value="DodajPrzedmiot">Dodaj przedmiot</button>
    </div>
    </form>
</div>
</center>