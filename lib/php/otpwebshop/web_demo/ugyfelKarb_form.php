<?php 
    define('SIMPLESHOP_CONFIGURATION', '../config/haromszereplosshop.conf');

    require_once('_header_footer.php');
    global $selectedMenuLabel;
    $selectedMenuLabel = 'Ügyfélkarbantartó felület (Banki oldal)';
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
        <th>Regisztrálandó ügyfél azonositó *</th>
        <td><input type="text" name="azonosito" value="" size="40" maxlength="64" class="text"/></td>
      </tr>
      <tr>
        <td colspan="2" class="info">* = Opcionális</td>
      </tr>
    </table>

    <input type="submit" name="ok" value="Banki felület >>>">
    
</form>

<?php demo_footer(); ?>