<?php

//header_nocache();
global $mainMenu;
$mainMenu = array(
    'fiz3_main' => array (
        'Háromszereplõs fizetés', array (
            'fiz3' => array ('Alapértelmezett mód', 'fiz3_form.php'),
            'fiz3reg' => array ('Ügyfél regisztrálás', 'fiz3reg_form.php'),
            'fiz3regfiz' => array ('Regisztrálás fizetéssel', 'fiz3regfiz_form.php'),
            'fiz3fizreg' => array ('Fizetés regisztrált ügyféllel', 'fiz3fizreg_form.php'),
        )
    ),
    'fiz2_main' => array (
        'Kétszereplõs fizetés', array (
            'fiz2' => array ('Alapértelmezett mód','fiz2_form.php'),
            'fiz2regfiz' => array ('Fizetés regisztrált ügyféllel', 'fiz2regfiz_form.php'),
        )
    ),
    'tranzLezaras_main' => array (
        'Kétlépcsõs fizetés', array (
            'fiz3ketlepcsos' => array ('Kétlépcsõs háromszereplõs fizetés', 'fiz3ketlepcsos_form.php'),
            'fiz2ketlepcsos' => array ('Kétlépcsõs kétszereplõs fizetés', 'fiz2ketlepcsos_form.php'),
            'lezaras' => array ('Kétlépcsõs fizetés lezárás', 'lezaras_form.php'),
        )
    ),
    'tranzAzon_main' => array (
        'Tranz.azon. generálás', array (
            'tranzAzon' => array ('Tranzakció azonosító generálás', 'tranzAzonGen_form.php'),
        )
    ),
    'tranzLek_main' => array (
        'Tranzakció lekérdezés', array (
            'tranzLek' => array ('Tranzakció lekérdezés', 'tranzLek_form.php'),
            // 'feldolgAlattiTranzLek' => array ('Feldolgozás alatti tranzakciók lekérdezése', 'tranzLek_feldolgAlatt_form.php'),
            // fejlesztés alatt...
        )
    ),
    'ping_main' => array (
        'Ping', array (
            'ping' => array('Ping', 'ping.php'),
        )
    )
);

function demo_header($func) {

    global $mainMenu;
    global $selectedSubMenu;
    global $selectedMenuId;
    global $selectedMenuLabel;
    global $selectedSubLabel;

    reset($mainMenu);
    while ($nextElmt = each($mainMenu)) {
        list($menuId, $menuData) = $nextElmt;

        $currentMenuLabel = current($menuData);
        $currentSubmenu = next($menuData);

        $isActive = ($menuId == $func || array_key_exists($func, $currentSubmenu)) ;

        if ($isActive) {
            $selectedSubMenu = $currentSubmenu;
            $selectedMenuId = $menuId;
            $selectedMenuLabel = $currentMenuLabel;

            if (count($currentSubmenu) > 1 && array_key_exists($func, $currentSubmenu)) {
                $selectedSubLabel = current($currentSubmenu[$func]);
            }
            else if (count($currentSubmenu) == 1 && array_key_exists($func, $currentSubmenu)) {
                $selectedMenuLabel = current($currentSubmenu[$func]);
            }
        }
    }

    header('Content-Type: text/html;charset=ISO-8859-2');

    ?>

    <html>

    <head>
        <title>PHP WebShop demo - <?php echo $selectedMenuLabel ?><?php if ($selectedSubLabel) echo " - ".$selectedSubLabel; ?></title>
        <link href="style/demo.css" rel="stylesheet" type="text/css" />
        <meta content="text/html; charset=ISO-8859-2" http-equiv="Content-type"/>
    </head>

    <body>

    <?php
}

function demo_menu() {

    global $mainMenu;
    global $selectedSubMenu;
    global $selectedMenuId;
    global $selectedMenuLabel;
    global $selectedSubLabel;

    ?>
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td width="1%"><img src="images/logo_aloldal_1.jpg" border="0"></td>
          <td width="100%">

            <table height="100%" cellpadding="0" cellspacing="0" id="felsomenu">
              <tr>
                <?php
                    reset($mainMenu);
                    $nextElmt = each($mainMenu);
                    while (!($nextElmt === FALSE)) {
                        list($menuId, $menuData) = $nextElmt;
                ?>
                <td class="felsomenu_menuelem" valign="bottom" <?php echo $menuId == $selectedMenuId ? 'id="aktivfelsomenu"' : "" ?>>
                    <a class="felsomenu" href="<?php echo dirname($_SERVER['PHP_SELF']) ?>/_index.php?func=<?php echo $menuId ?>"><?php echo current($menuData) ?></a>
                </td>
                <?php
                        $nextElmt = each($mainMenu);
                        if (!($nextElmt === FALSE)) {
                ?>
                <td valign="top"><img border="0" alt="" src="images/felsomenuelem_vonal.gif" id="fooldal_vonal"></td>
                <?php
                        }
                    }
                ?>
                <td valign="top"><img border="0" alt="" src="images/felsomenuelem_vonal.gif" id="fooldal_vonal"></td>
                <td width="100%">&nbsp;</td>
                <td valign="top"><img border="0" alt="" src="images/felsomenuelem_vonal.gif" id="fooldal_vonal"></td>
                <td class="felsomenu_menuelem" valign="bottom">
                    <a class="felsomenu" href="<?php echo dirname($_SERVER['PHP_SELF']) ?>/ugyfelKarb_form.php?func=ugyfelKarb">Ügyfélkarbantartó felület</a>
                </td>
              </tr>
            </table>

          </td>
        </tr>

        <tr>
          <td colspan="2" id="alsomenu">

            <table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0" id="alsomenu">
              <tr>
                <td width="1%" rowspan="2"><img src="images/bbox_1x_felsokep_aloldal.jpg" border="0"></TD>

                <?php
                    if (is_array($selectedSubMenu)) {

                        reset($selectedSubMenu);
                        $nextElmt = each($selectedSubMenu);
                        while (!($nextElmt === FALSE)) {
                            list($menuId, $menuData) = $nextElmt;
                            $menuLabel = current($menuData);
                            ?>
                            <td class="alsomenu_menuelem" nowrap="nowrap" valign="center">
                                <a class="alsomenu" href="<?php echo dirname($_SERVER['PHP_SELF']).'/'.next($menuData) ?>?func=<?php echo $menuId ?>"><?php echo $menuLabel ?></a>
                            </td>
                            <?php
                                        $nextElmt = each($selectedSubMenu);
                                        if (!($nextElmt === FALSE)) {
                            ?>
                            <td><img border="0" alt="" src="images/felsomenuelem_vonal.gif" id="fooldal_vonal"></td>
                            <?php

                            }
                        }
                ?>

                 <?php  } ?>
                <td width="100%" />
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td colspan="2" id="alsomenu_border"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td width="1%" class="header_info">
            PHP verzió: <?php echo phpversion() ?>&nbsp;<a href="<?php echo dirname($_SERVER['PHP_SELF']).'/_phpinfo.php' ?>" target="blank"><img border="0" alt="" src="images/link_nyil.gif"></a>
            <!--
            <br />
            <span>CURL / HTTPS <?php echo extension_loaded('curl') ? 'ok' : 'failed' ?></span>
            -->
          </td>
        </tr>
      </table>
    <?php
    }

function demo_title() {
    global $selectedMenuLabel;
    global $selectedSubLabel;
    ?>
        <h1><?php echo $selectedMenuLabel ?><?php if ($selectedSubLabel) echo " - ".$selectedSubLabel; ?></h1>
    <?php
}

function demo_footer() {
    ?>
          </body>
        </html>
    <?php
    }
?>