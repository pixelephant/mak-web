<?php

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../../..');

require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/DefineConst.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/ConfigUtils.php');

/**
* A WebShop PHP kliens бltal hasznбlt utility osztбly
* digitбlis alбнrбs generбlбsбra PHP4 kцrnyezetben.
* 
* @version 3.3.1
* @author Bodnбr Imre / IQSYS
*/
class SignatureUtils {

    /**
    * Privбt kulcs fбjlrendszerbхl tцrtйnх betцltйse йs йrtelmezйse.
    * A kulcs бllomбnynak PEM formбban kell lennie!
    * Az eljбrбs PHP4 alatt jelenleg nem csinбl semmit,
    * a visszaadott йrtйk maga az бllomбny elйrйs
    * 
    * @param string $privKeyFileName a privбt kulcs бllomбny elйrйsi cнme
    * @return string a privбt kulcs бllomбny elйrйsi cнme
    */
    function loadPrivateKey($privKeyFileName) {
        return $privKeyFileName;
    }

    /**
    * Alбнrandу szцveg elхбllнtбsa az alбнrandу szцveg йrtйkek listбjбbуl:
    * [s1, s2, s3, s4]  ->  's1|s2|s3|s4'
    * 
    * @param array alбнrandу mezхk 
    * @return string alбнrandу szцveg
    */
    function getSignatureText($signatureFields) {
        $signatureText = '';
        foreach ($signatureFields as $data) {
            $signatureText = $signatureText.$data.'|';
        }

        if (strlen($signatureText) > 0) {
            $signatureText = substr($signatureText, 0, strlen($signatureText) - 1);
        }

        return $signatureText;
    }

    /**
    * @desc Stream beolvasбsa. 
    * Az fopen йs fclose hнvбsokat nem tartalmazza az eljбrбs.
    * 
    * @param resource handle
    * @return string a stream tartalma
    */
    function streamGetContents($source) {
        $result = "";
        if ($source) {
            while (!feof($source)) {
                $result .= fgets($source, 4096);
            }
        }
        return $result;
    }
    
    /**
    * Digitбlis alбнrбs generбlбsa a Bank бltal elvбrt formбban.
    * Az alбнrбs sorбn az MD5 hash algoritmust hasznбljuk.
    * 
    * @param string $data az alбнrandу szцveg
    * @param string $pkcs8PrivateKey a privбt kulcs бllomбny elйrйsi cнme    
    * @param array $properties a WebShop PHP kliens konfigurбciуja
    * @param LogCategory $logger log4php naplуzу objektum
    * 
    * @return string digitбlis alбнrбs, hexadecimбlis formбban (ahogy a banki felьlet elvбrja). 
    */
    function generateSignature($data, $pkcs8PrivateKey, $properties, $logger) {
        $openSslExecPath = ConfigUtils::safeConfigParam($properties, PROPERTY_OPENSSL_EXECUTIONPATH);
        $openSslExecParams = ConfigUtils::safeConfigParam($properties, PROPERTY_OPENSSL_EXECUTIONPARAMS);
        $substedExecParams = ConfigUtils::substConfigValue($openSslExecParams, array("0" => $pkcs8PrivateKey));

        if (is_null($openSslExecPath) || $openSslExecPath == "" ) {
            $logger->fatal("Hiba az alairas generalasanal, " . PROPERTY_OPENSSL_EXECUTIONPATH . " parameter erteke ures!");
        }

        // szуkцzt tartalmazу elйrйsi ъtvonal kezelйse
        $openSslExecPath = trim($openSslExecPath);
        if (strpos($openSslExecPath, " ") !== false && $openSslExecPath{0} != '"' && $openSslExecPath{0} != "'") {
            $openSslExecPath = '"' . $openSslExecPath . '"';
        } 
        
        $cmdOut = null;

        $descriptorspec = array(
            0 => array("pipe", "r"),    // stdin pipe
            1 => array("pipe", "w"),    // stdout pipe 
            2 => array("pipe", "r"));   // stderr pipe
        $process = proc_open($openSslExecPath . ' ' . $substedExecParams, $descriptorspec, $pipes);

        if (is_resource($process)) {
            fwrite($pipes[0], $data);
            fclose($pipes[0]);

            $cmdOut = trim(SignatureUtils::streamGetContents($pipes[1]));
            fclose($pipes[1]);

            $cmdErr = trim(SignatureUtils::streamGetContents($pipes[2]));
            fclose($pipes[2]);
            
            $retVal = proc_close($process);

            if ($retVal !== 0) {
                $logger->fatal("Hiba az openssl futtatasanal (" . $openSslExecPath . "): " . $cmdErr);
            } 
            else if (is_null($cmdOut) || $cmdOut == "") {
                $logger->fatal("Hiba az alairas generalasanal (" . $openSslExecPath . ' ' . $substedExecParams . "): " . $cmdErr);
            }
        }
        
        return $cmdOut;
    }
   
}

?>