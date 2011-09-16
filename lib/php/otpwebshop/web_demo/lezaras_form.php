<?php 
    require_once('_header_footer.php');
    demo_header('lezaras');
    demo_menu();
    demo_title(); 
?>

<form method="post" action="<?php echo dirname($_SERVER['SCRIPT_NAME']) ?>/lezaras.php">

    <table class="input">
      <tr>
        <th>Tranzakció azonositó  *</th>
        <td><input type="text" name="tranzakcioAzonosito" size="40" maxlength="32" class="text"/></td>
      </tr>
      <tr>
        <th>Shop ID</th>
        <td><input type="text" name="posId" value="#02299991" size="40" maxlength="15" class="text"/></td>
      </tr>

      <tr>
        <th>Lezárás módja</th>
        <td>
          <input type="radio" name="jovahagyo" value="true" checked="checked" id="jovahagyo"/>
          <label for="jovahagyo">Jóváhagyás</label> &nbsp;
          <input type="radio" name="jovahagyo" value="false" id="elutasito"/>
          <label for="elutasito">Elutasítás</label> &nbsp;
        </td>
      </tr>

    </table>

    <!-- Szükséges konstans paraméterek a regisztráláshoz -->
    <input type="hidden" name="func" value="lezaras"/>            

    <input type="submit" name="ok" value="Rendben"/>
    
</form>

<?php demo_footer(); ?>