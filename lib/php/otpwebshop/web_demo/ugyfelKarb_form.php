<?php 
    define('SIMPLESHOP_CONFIGURATION', '../config/haromszereplosshop.conf');

    require_once('_header_footer.php');
    global $selectedMenuLabel;
    $selectedMenuLabel = '�gyf�lkarbantart� fel�let (Banki oldal)';
    demo_header('ugyfelKarb');
    demo_menu();
    demo_title(); 
    
    $config = parse_ini_file(SIMPLESHOP_CONFIGURATION);
    $custPageTemplate = $config['webshop_customerpage_url'];
    $path_parts = pathinfo($custPageTemplate);
?>

<form method="post" action="<?php echo $path_parts['dirname'] . '/webShopUgyfelBejelentkezes' ?>" target="blank">

    <table class="input">
      <tr>
        <th>Shop ID *</th>
        <td><input type="text" name="posId" value="#02299991" size="40" maxlength="15" class="text"/></td>
      </tr>
      <tr>
        <th>Regisztr�land� �gyf�l azonosit� *</th>
        <td><input type="text" name="azonosito" value="" size="40" maxlength="64" class="text"/></td>
      </tr>
      <tr>
        <td colspan="2" class="info">* = Opcion�lis</td>
      </tr>
    </table>

    <input type="submit" name="ok" value="Banki fel�let >>>">
    
</form>

<?php demo_footer(); ?>