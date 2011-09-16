<?php 
    require_once('_header_footer.php');
    demo_header('tranzAzon');
    demo_menu();
    demo_title(); 
?>

<form method="post" action="<?php echo dirname($_SERVER['SCRIPT_NAME']) ?>/tranzAzon.php">

    <table class="input">
      <tr>
        <th>Shop ID</th>
        <td><input type="text" name="posId" value="#02299991" size="40" maxlength="15" class="text"/></td>
      </tr>
    </table>

    <input type="hidden" name="func" value="tranzAzon">

    <input type="submit" name="ok" value="Elküld">
    
</form>

<?php demo_footer(); ?>