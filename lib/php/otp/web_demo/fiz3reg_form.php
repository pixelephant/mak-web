<?php 
    require_once('_header_footer.php');
    demo_header('fiz3reg');
    demo_menu();
    demo_title(); 
?>

<form method="post" action="<?php echo dirname($_SERVER['SCRIPT_NAME']) ?>/fiz3.php">

    <table class="input">
      <tr>
        <th>Tranzakci� azonosit�  *</th>
        <td><input type="text" name="tranzakcioAzonosito" size="40" maxlength="32" class="text"/></td>
      </tr>
      <tr>
        <th>Shop ID</th>
        <td><input type="text" name="posId" value="#02299991" size="40" maxlength="15" class="text"/></td>
      </tr>

      <tr>
        <th>�sszeg</th>
        <td>0</td>
      </tr>
      <tr>
        <th>Devizanem</th>
        <td>HUF</td>
      </tr>
      <tr>
        <th>Nyelvk�d</th>
        <td><input type="text" name="nyelvkod" value="hu" size="5" maxlength="2" class="text"/></td>
      </tr>

      <tr>
        <th>�gyf�l regisztr�ci� kell</th>
        <td>true</td>
      </tr>
      <tr>
        <th>Regisztr�land� �gyf�l azonosit�</th>
        <td><input type="text" name="regisztraltUgyfelId" value="" size="40" maxlength="64" class="text"/></td>
      </tr>

      <tr>
        <th>Shop megjegyz�s</th>
        <td><input type="text" name="shopMegjegyzes" value="Teszt �zem� regisztr�l�s - PHP" size="40"  class="text"/></td>
      </tr>

      <tr>
        <th>Vissza link</th>
        <td><input type="text" name="backURL" value="<?php echo 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['SCRIPT_NAME']) ?>/fiz3.php?func=fiz3reg" size="40"  class="text"/><br/>
            <font size="-1">(+ fizetesValasz=true&posId=...&tranzId=... dinamikus �rt�kek)</font>
        </td>
      </tr>
      <tr>
        <th>Vev� visszaigazol�s kell</th>
        <td><input type="checkbox" name="vevoVisszaigazolasKell" value="true" checked="checked" class="check"/></td>
      </tr>
      <tr>
        <td colspan="2" class="info">* = Opcion�lis</td>
      </tr>
    </table>

    <!-- Sz�ks�ges konstans param�terek a regisztr�l�shoz -->
    <input type="hidden" name="osszeg" value="0" />    
    <input type="hidden" name="devizanem" value="HUF" />    
    <input type="hidden" name="ugyfelRegisztracioKell" value="true" />    
    
    <input type="hidden" name="func" value="fiz3reg"/>            

    <input type="submit" name="ok" value="Rendben"/>
    
</form>

<?php demo_footer(); ?>