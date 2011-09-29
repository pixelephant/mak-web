<?php
    require_once('_header_footer.php');
    demo_header('fiz3');
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
        <td><input type="text" name="osszeg" value="300" size="15" maxlength="10" class="text"/></td>
      </tr>
      <tr>
        <th>Devizanem</th>
        <td><input type="text" name="devizanem" value="HUF" size="5" maxlength="3" class="text"/></td>
      </tr>
      <tr>
        <th>Nyelvk�d</th>
        <td><input type="text" name="nyelvkod" value="hu" size="5" maxlength="2" class="text"/></td>
      </tr>

      <tr>
        <th>N�v kell</th>
        <td><input type="checkbox" name="nevKell" value="true" checked="checked" class="check"/></td>
      </tr>
      <tr>
        <th>Orsz�g kell</th>
        <td><input type="checkbox" name="orszagKell" value="true" class="check"/></td>
      </tr>
      <tr>
        <th>Megye kell</th>
        <td><input type="checkbox" name="megyeKell" value="true" class="check"/></td>
      </tr>
      <tr>
        <th>Telep�l�s kell</th>
        <td><input type="checkbox" name="telepulesKell" value="true" class="check"/></td>
      </tr>
      <tr>
        <th>Ir�ny�t�sz�m kell</th>
        <td><input type="checkbox" name="iranyitoszamKell" value="true" class="check"/></td>
      </tr>
      <tr>
        <th>Utca/H�zsz�m kell</th>
        <td><input type="checkbox" name="utcaHazszamKell" value="true" class="check"/></td>
      </tr>
      <tr>
        <th>Mail cim kell</th>
        <td><input type="checkbox" name="mailCimKell" value="true" class="check"/></td>
      </tr>
      <tr>
        <th>K�zlemeny kell</th>
        <td><input type="checkbox" name="kozlemenyKell" value="true" class="check"/></td>
      </tr>

      <tr>
        <th>Shop megjegyz�s</th>
        <td><input type="text" name="shopMegjegyzes" value="Teszt �zem� v�s�rl�s - PHP" size="40"  class="text"/></td>
      </tr>

      <tr>
        <th>Vissza link</th>
        <td><input type="text" name="backURL" value="<?php echo 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) ?>/fiz3.php?func=fiz3" size="40"  class="text"/><br/>
            <span class="info">(+ fizetesValasz=true&posId=...&tranzId=... dinamikus �rt�kek)</span>
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

    <input type="hidden" name="func" value="fiz3"/>

    <input type="submit" name="ok" value="Rendben"/>

</form>

<?php demo_footer(); ?>