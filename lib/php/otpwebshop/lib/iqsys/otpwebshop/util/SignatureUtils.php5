<?php

/**
* A WebShop PHP kliens бltal hasznбlt utility osztбly
* digitбlis alбнrбs generбlбsбra PHP5 kцrnyezetben.
* 
* @version 3.3.1
* @author Bodnбr Imre / IQSYS
*/
class SignatureUtils {

    /**
    * Privбt kulcs fбjlrendszerbхl tцrtйnх betцltйse йs йrtelmezйse.
    * A kulcs бllomбnynak PEM formбban kell lennie!
    * 
    * @param string $privKeyFileName a privбt kulcs бllomбny elйrйsi cнme
    * @return resource privбt kulcs
    */
    function loadPrivateKey($privKeyFileName) {
        $priv_key = file_get_contents($privKeyFileName);
        $pkeyid = openssl_get_privatekey($priv_key);
        return $pkeyid;
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
    * Digitбlis alбнrбs generбlбsa a Bank бltal elvбrt formбban.
    * Az alбнrбs sorбn az MD5 hash algoritmust hasznбljuk.
    * 
    * @param string $data az alбнrandу szцveg
    * @param resource $pkcs8PrivateKey privбt kulcs
    * 
    * @return string digitбlis alбнrбs, hexadecimбlis formбban (ahogy a banki felьlet elvбrja). 
    */
    function generateSignature($data, $pkcs8PrivateKey, $properties, $logger) {
        openssl_sign($data, $signature, $pkcs8PrivateKey, OPENSSL_ALGO_MD5);
        return bin2hex($signature);
    }

}

?>