<?php

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../../..');

require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/DefineConst.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/ConfigUtils.php');

/**
* A WebShop PHP kliens �ltal haszn�lt utility oszt�ly
* digit�lis al��r�s gener�l�s�ra PHP4 k�rnyezetben.
* 
* @version 3.3.1
* @author Bodn�r Imre / IQSYS
*/
class SignatureUtils {

    /**
    * Priv�t kulcs f�jlrendszerb�l t�rt�n� bet�lt�se �s �rtelmez�se.
    * A kulcs �llom�nynak PEM form�ban kell lennie!
    * Az elj�r�s PHP4 alatt jelenleg nem csin�l semmit,
    * a visszaadott �rt�k maga az �llom�ny el�r�s
    * 
    * @param string $privKeyFileName a priv�t kulcs �llom�ny el�r�si c�me
    * @return string a priv�t kulcs �llom�ny el�r�si c�me
    */
    function loadPrivateKey($privKeyFileName) {
        return $privKeyFileName;
    }

    /**
    * Al��rand� sz�veg el��ll�t�sa az al��rand� sz�veg �rt�kek list�j�b�l:
    * [s1, s2, s3, s4]  ->  's1|s2|s3|s4'
    * 
    * @param array al��rand� mez�k 
    * @return string al��rand� sz�veg
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
    * @desc Stream beolvas�sa. 
    * Az fopen �s fclose h�v�sokat nem tartalmazza az elj�r�s.
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
    * Digit�lis al��r�s gener�l�sa a Bank �ltal elv�rt form�ban.
    * Az al��r�s sor�n az MD5 hash algoritmust haszn�ljuk.
    * 
    * @param string $data az al��rand� sz�veg
    * @param string $pkcs8PrivateKey a priv�t kulcs �llom�ny el�r�si c�me    
    * @param array $properties a WebShop PHP kliens konfigur�ci�ja
    * @param LogCategory $logger log4php napl�z� objektum
    * 
    * @return string digit�lis al��r�s, hexadecim�lis form�ban (ahogy a banki fel�let elv�rja). 
    */
    function generateSignature($data, $pkcs8PrivateKey, $properties, $logger) {
        $openSslExecPath = ConfigUtils::safeConfigParam($properties, PROPERTY_OPENSSL_EXECUTIONPATH);
        $openSslExecParams = ConfigUtils::safeConfigParam($properties, PROPERTY_OPENSSL_EXECUTIONPARAMS);
        $substedExecParams = ConfigUtils::substConfigValue($openSslExecParams, array("0" => $pkcs8PrivateKey));

        if (is_null($openSslExecPath) || $openSslExecPath == "" ) {
            $logger->fatal("Hiba az alairas generalasanal, " . PROPERTY_OPENSSL_EXECUTIONPATH . " parameter erteke ures!");
        }

        // sz�k�zt tartalmaz� el�r�si �tvonal kezel�se
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