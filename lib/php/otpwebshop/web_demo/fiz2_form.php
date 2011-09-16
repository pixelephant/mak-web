<?php 
    require_once('_header_footer.php');
    demo_header('fiz2');
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
        <th>�sszeg</th>
        <td><input type="text" name="osszeg" value="200" size="15" maxlength="10" class="text"/></td>
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
        <th>K�rtyasz�m</th>
        <td><input type="text" name="kartyaszam" size="20" maxlength="16" value="5016253399000013" class="text"/></td>
      </tr>
      <tr>
        <th>CVC/CVV ellen�rz� k�d</th>
        <td><input type="text" name="cvc2Cvv2" size="6" maxlength="4" value="111" class="text"/></td>
      </tr>
      <tr>
        <th>K�rtyalej�rat d�tuma (hh��)</th>
        <td><input type="text" name="kartyaLejarat" size="6" maxlength="4" value="0404" class="text"/></td>
      </tr>
      <tr>
        <th>Vev� n�v</th>
        <td><input type="text" name="vevoNev" size="40" value="John Customer" class="text"/></td>
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
        <td><input type="text" name="ertesitoMail" value="johnny@customers.com" size="40" class="text"/></td>
      </tr>
      <tr>
        <th>Vev� telefon *</th>
        <td><input type="text" name="ertesitoTel" size="15" maxlength="12" class="text"/></td>
      </tr>
      <tr>
        <td colspan="2" class="info">* = Opcion�lis</td>
      </tr>
    </table>

    <input type="hidden" name="func" value="fiz2">

    <input type="submit" name="ok" value="Elk�ld">
    
</form>

<?php demo_footer(); ?>