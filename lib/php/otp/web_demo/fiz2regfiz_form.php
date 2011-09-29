<?php 
    require_once('_header_footer.php');
    demo_header('fiz2regfiz');
    demo_menu();
    demo_title(); 
?>

<form method="post" action="<?php echo dirname($_SERVER['SCRIPT_NAME']) ?>/fiz2.php">
    <table class="input">
      <tr>
        <th>Tranzakci� azonos�t� *</th>
        <td><input type="text" name="tranzakcioAzonosito" value="" size="40" maxlength="32" class="text"/></td>
      </tr>
      <tr>
        <th>Shop ID</th>
        <td><input type="text" name="posId" value="#02299991" size="40" maxlength="15" class="text"/></td>
      </tr>

      <tr>
        <th>Osszeg</th>
        <td><input type="text" name="osszeg" value="220" size="15" maxlength="10" class="text"/></td>
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
        <th>Regisztr�lt �gyf�l azonosit�</th>
        <td><input type="text" name="regisztraltUgyfelId" value="" size="40" maxlength="200" class="text"/></td>
      </tr>

      <tr>
        <th>Vev� n�v</th>
        <td><input type="text" name="vevoNev" size="40" value="Bob Customer" class="text"/></td>
      </tr>
      <tr>
        <th>Vev� lakc�m *</th>
        <td><input type="text" name="vevoPostaCim" size="40" value="Some street, Neverhood" class="text"/></td>
      </tr>
      <tr>
        <th>Vev� kliens IP *</th>
        <td><input type="text" name="vevoIPCim" size="20" value="<?php echo $_SERVER['REMOTE_ADDR'] ?>" class="text"/></td>
      </tr>
      <tr>
        <th>Vev� email c�m *</th>
        <td><input type="text" name="ertesitoMail" size="40" value="bobby@customers.com" class="text"/></td>
      </tr>
      <tr>
        <th>Vev� telefon *</th>
        <td><input type="text" name="ertesitoTel" size="15" maxlength="12" class="text"/></td>
      </tr>
      <tr>
        <td colspan="2" class="info">* = Opcion�lis</td>
      </tr>
    </table>

    <input type="hidden" name="func" value="fiz2regfiz">

    <input type="submit" name="ok" value="Elk�ld">
    
</form>

<?php demo_footer('fiz2'); ?>