<?php 
    require_once('_header_footer.php');
    demo_header($_REQUEST['func']);
    demo_menu();
    demo_title(); 

    $today = getdate(); 
    $yesterday = getdate(time() - 24 * 60 * 60); 
?>

<form method="post" action="<?php echo dirname($_SERVER['SCRIPT_NAME']) ?>/tranzLek.php">

    <table class="input">
      <tr>
        <th>Tranzakcio azonosito *</th>
        <td><input type="text" name="tranzakcioAzonosito" value="" size="40" maxlength="32" class="text"/></td>
      </tr>
      <tr>
        <th>Shop ID</th>
        <td><input type="text" name="posId" value="#02299991" size="40" maxlength="15" class="text"/></td>
      </tr>

      <tr>
        <th>Maximális rekorszám</th>
        <td><input type="text" name="maxRekordSzam" value="10" size="15" maxlength="10" class="text"/></td>
      </tr>
      <tr>
        <th>Idõszak eleje</th>
        <td>

            <input type="checkbox" name="idoszakEleje" value="true" checked="checked">
            
            <select name="idoszakEleje_ev">
            <?php for ($i = $today["year"] - 2; $i <= $today["year"]; $i++) { ?>
               <option value="<?php echo $i ?>" <?php echo $i == $yesterday["year"] ? "selected = 'selected'" : "" ?> ><?php echo $i ?></option>
            <?php } ?>
            </select>
            <select name="idoszakEleje_honap">
            <?php for ($i=1; $i<=12; $i++) { ?>
               <option value="<?php echo $i ?>" <?php echo $i == $yesterday["mon"] ? "selected = 'selected'" : "" ?> ><?php echo $i ?></option>
            <?php } ?>
            </select>
            <select name="idoszakEleje_nap">
            <?php for ($i=1; $i<=31; $i++) { ?>
               <option value="<?php echo $i ?>" <?php echo $i == $yesterday["mday"] ? "selected = 'selected'" : "" ?> ><?php echo $i ?></option>
            <?php } ?>
            </select>
            <input type="text" name="idoszakEleje.ora" value="00" size="3" maxlength="2" class="text"/>
            <input type="text" name="idoszakEleje.perc" value="00" size="3" maxlength="2" class="text"/>
        </td>
      </tr>
      <tr>
        <th>Idõszak vége</th>
        <td>
            <input type="checkbox" name="idoszakVege" value="true" checked="checked">

            <select name="idoszakVege_ev">
            <?php for ($i = $today["year"] - 2; $i <= $today["year"]; $i++) { ?>
               <option value="<?php echo $i ?>" <?php echo $i == $today["year"] ? "selected = 'selected'" : "" ?> ><?php echo $i ?></option>
            <?php } ?>
            </select>
            <select name="idoszakVege_honap">
            <?php for ($i=1; $i<=12; $i++) { ?>
               <option value="<?php echo $i ?>" <?php echo $i == $today["mon"] ? "selected = 'selected'" : "" ?> ><?php echo $i ?></option>
            <?php } ?>
            </select>
            <select name="idoszakVege_nap">
            <?php for ($i=1; $i<=31; $i++) { ?>
               <option value="<?php echo $i ?>" <?php echo $i == $today["mday"] ? "selected = 'selected'" : "" ?> ><?php echo $i ?></option>
            <?php } ?>
            </select>
            <input type="text" name="idoszakVege.ora" value="23" size="3" maxlength="2" class="text"/>
            <input type="text" name="idoszakVege.perc" value="59" size="3" maxlength="2" class="text"/>

        </td>
      </tr>

    </table>

    <input type="submit" name="ok" value="Elküld">
    
</form>

<?php demo_footer(); ?>