<?php

/**
* A WebShop PHP kliens �ltal haszn�lt utility oszt�ly
* digit�lis al��r�s gener�l�s�ra PHP5 k�rnyezetben.
* 
* @version 3.3.1
* @author Bodn�r Imre / IQSYS
*/
class SignatureUtils {

    /**
    * Priv�t kulcs f�jlrendszerb�l t�rt�n� bet�lt�se �s �rtelmez�se.
    * A kulcs �llom�nynak PEM form�ban kell lennie!
    * 
    * @param string $privKeyFileName a priv�t kulcs �llom�ny el�r�si c�me
    * @return resource priv�t kulcs
    */
    function loadPrivateKey($privKeyFileName) {
        $priv_key = file_get_contents($privKeyFileName);
        $pkeyid = openssl_get_privatekey($priv_key);
        return $pkeyid;
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
    * Digit�lis al��r�s gener�l�sa a Bank �ltal elv�rt form�ban.
    * Az al��r�s sor�n az MD5 hash algoritmust haszn�ljuk.
    * 
    * @param string $data az al��rand� sz�veg
    * @param resource $pkcs8PrivateKey priv�t kulcs
    * 
    * @return string digit�lis al��r�s, hexadecim�lis form�ban (ahogy a banki fel�let elv�rja). 
    */
    function generateSignature($data, $pkcs8PrivateKey, $properties, $logger) {
        openssl_sign($data, $signature, $pkcs8PrivateKey, OPENSSL_ALGO_MD5);
        return bin2hex($signature);
    }

}

?>