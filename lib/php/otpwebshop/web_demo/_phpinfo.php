<?php
    if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../lib');
    require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/WebShopService.php');
    require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/ConfigUtils.php'); 

    $service = new WebShopService();
    $serviceProps = $service->property;
    
    $phpversion = phpversion();
?>

<?php
    header('Content-Type: text/html;charset=ISO-8859-2');
?>

<html>

<head>
    <title>PHP WebShop demo - PHP info</title>
    <link href="style/demo.css" rel="stylesheet" type="text/css" />
    <meta content="text/html; charset=ISO-8859-2" http-equiv="Content-type"/>
</head>

<body>

    <h2>PHP környezet, beállítások</h2>

    <table class="eredmenytabla1">
      <tr>
        <th>PHP verziószám:</th>
        <td><?php echo $phpversion ?></td>
      </tr>    
      <tr>
        <th>Igényelt modulok:</th>
        <td>
            <?php if ($phpversion{0} == "5") { ?>
                SOAP - <?php echo extension_loaded('soap') ? 'ok' : 'hiba' ?>
                <br />
                OpenSSL - <?php echo extension_loaded('openssl') ? 'ok' : 'hiba' ?>
                <br />
                Iconv - <?php echo extension_loaded('iconv') ? 'ok' : 'hiba' ?>
                <br />
                DOM (xml) - <?php echo extension_loaded('dom') ? 'ok' : 'hiba' ?>
            <?php } else { ?>
                CURL - <?php echo extension_loaded('curl') ? 'ok' : 'hiba' ?>
                <br />
                OpenSSL - <?php echo extension_loaded('openssl') ? 'ok' : 'hiba' ?>
                <br />
                Iconv - <?php echo extension_loaded('iconv') ? 'ok' : 'hiba' ?>
                <br />
                DOMXML - <?php echo extension_loaded('domxml') ? 'ok' : 'hiba' ?>
            <?php } ?>
        </td>
      </tr>    
      <tr>
        <th>Extension dir:</th>
        <td><?php echo ini_get("extension_dir") ?></td>
      </tr>    
      <tr>
        <th>Error log:</th>
        <td><?php echo ini_get("log_errors") ? ini_get("error_log") : " - "?></td>
      </tr>  
      <tr>
        <th rowspan="2">Script:</th>
        <td>
            <?php echo __FILE__ ?>
        </td>    
      </tr>  
      <tr>
        <td>
            <?php echo $_SERVER['PHP_SELF'] ?>            
        </td>
      </tr>  
    </table>

    <h2>WebShop PHP kliens</h2>

    <table class="eredmenytabla1">
      
      <tr>
        <th>Verziószám:</th>
        <td><?php echo WEBSHOP_LIB_VER ?></td>
      </tr>    
      <tr>
        <th>Forráskód elérés:</th>
        <td><?php echo realpath(WEBSHOP_LIB_DIR) ?></td>
      </tr>    
      <tr>
        <th>Konfigurációs könyvtár:</th>
        <td><?php echo realpath(WEBSHOP_CONF_DIR) ?></td>
      </tr>    
 
    </table>
    
    <h2>WebShop PHP kliens beállítások</h2>

    <table class="eredmenytabla1">
      
      <tr>
        <th>Banki szerver:</th>
        <td><?php echo ConfigUtils::getConfigParam($serviceProps, PROPERTY_OTPMWSERVERURL) ?></td>
      </tr>    
      <tr>
        <th>Kliens https proxy host:</th>
        <td><?php echo ConfigUtils::getConfigParam($serviceProps, PROPERTY_HTTPSPROXYHOST) ?></td>
      </tr> 
      <tr>
        <th>Kliens https proxy port:</th>
        <td><?php echo ConfigUtils::getConfigParam($serviceProps, PROPERTY_HTTPSPROXYPORT) ?></td>
      </tr> 
      <tr>
        <th>Kliens https proxy user:</th>
        <td><?php echo ConfigUtils::getConfigParam($serviceProps, PROPERTY_HTTPSPROXYUSER) ?></td>
      </tr> 
      <tr>
        <th>Kliens https proxy password:</th>
        <td><?php echo (ConfigUtils::getConfigParam($serviceProps, PROPERTY_HTTPSPROXYPASSWORD) ? "******" : "") ?></td>
      </tr>     
      <tr>
        <th>Privát kulcs (default posId):</th>
        <td><?php echo $service->getPrivKeyFileName($serviceProps, null) ?></td>
      </tr>       
      <tr>
        <th>Tranzakciós napló könyvtár (default posId):</th>
        <td><?php 
                $dirs = $service->getTranLogDir($serviceProps, null);
                echo reset($dirs);
                echo "<br />";
                echo "[Sikeres vásárlások] " . next($dirs);
                echo "<br />";
                echo "[Sikertelen vásárlások] " . next($dirs);
            ?></td>
      </tr>       
      <tr>
        <th>Napló állomány:</th>
        <td><?php echo ConfigUtils::getConfigParam($serviceProps, "log4php.appender.WebShopClient.File") ?></td>
      </tr>     
      

      
    </table>    
    
    
</body>    