<center>
<br>
<div class="reformed-form" style="background-color: silver;width: 500px; height:820px;text-align: center;
">
<p><font size="5">Dodawanie przedmiotu</font></p>
  <form method="post" name="Dodawanieproduktu" id="Dodawanieproduktu" action="index.php" enctype="multipart/form-data">
    <dl>
      <dt>
        <label for="Kategoria">Kategoria</label>
      </dt>
      <dd><input type="text" id="Kategoria" name="Kategoria" /></dd>
    </dl>
    <dl>
      <dt>
        <label for="Podkategoria">Podkategoria</label>
      </dt>
      <dd><input type="text" id="Podkategoria" name="Podkategoria" /></dd>
    </dl>
    <dl>
      <dt>
        <label for="NazwaPrzedmiotu">Nazwa przedmiotu</label>
      </dt>
      <dd><input type="text" id="NazwaPrzedmiotu" name="NazwaPrzedmiotu" /></dd>
    </dl>
    <dl>
      <dt>
        <label for="Ilosc">Ilość</label>
      </dt>
      <dd><center><input type="number" id="Ilosc" class="digits" name="Ilosc" /></center></dd>
    </dl>
    <dl>
      <dt>
        <label for="Ilosc">Cena</label>
      </dt>
      <dd><input type="number" id="Cena" class="digits" name="Cena" /></dd>
    </dl>
    <dl>
      <dt>
        <label for="Zdjecie1">Zdjęcie #1</label>
      </dt>
      <dd><input type="file" id="Zdjecie1" name="Zdjecie1" /></dd>
    </dl>
    <dl>
      <dt>
        <label for="Zdjecie2">Zdjęcie #2</label>
      </dt>
      <dd><input type="file" id="Zdjecie2" name="Zdjecie2" /></dd>
    </dl>
    <dl>
      <dt>
        <label for="Zdjecie3">Zdjęcie #3</label>
      </dt>
      <dd><input type="file" id="Zdjecie3" name="Zdjecie3" /></dd>
    </dl>
    <dl>
      <dt>
        <label for="Zdjecie4">Zdjęcie #4</label>
      </dt>
      <dd><input type="file" id="Zdjecie4" name="Zdjecie4" /></dd>
    </dl>
    <dl>
      <dt>
        <label for="Zdjecie5">Zdjęcie #5</label>
      </dt>
      <dd><input type="file" id="Zdjecie5" name="Zdjecie5" /></dd>
    </dl>
    <dl>
      <dt>
        <label for="Opis">Opis</label>
      </dt>
      <dd><textarea id="Opis" class="required" name="Opis" rows="10" cols="55">
</textarea></dd>
    </dl>
    <div id="submit_buttons">
      <button type="submit">Submit</button>
    </div>
    </form>
</div>
</center>