<?php
     
/**
* A SimpleShop PHP �s a WebShop PHP kliens �ltal haszn�lt utility oszt�ly
* a REQUEST param�terek kezel�s�re, t�pus-konverzi�k elv�gz�s�re, URL manipul�ci�ra.
* 
* @version 3.3.1
* @author Bodn�r Imre / IQSYS
*/
class RequestUtils {

    /**
     * Logikai t�pus� request param�ter kiolvas�sa,
     * �s boolean �rt�kk� alak�t�sa.
     * Lehets�ges true �rt�kek: 'true', 'on', 'yes'.
     * (Kis- �s nagybet� �rz�kenys�g nincs.)
     * 
     * @param request http request (param�ter vektor)
     * @param paramName a param�ter neve
     * @return a param�ter sz�veges �rt�ke
     */
    function getBooleanRequestAttribute($paramMap, $paramName, $dflt = false) {
        return RequestUtils::getBooleanValue($paramMap[$paramName]);        
    }

    /**
     * Logikai t�pus� request param�ter kiolvas�sa,
     * �s boolean �rt�kk� alak�t�sa.
     * Lehets�ges true �rt�kek: 'true', 'on', 'yes', '1'.
     * (Kis- �s nagybet� �rz�kenys�g nincs.)
     * 
     * @param request http request (param�ter vektor)
     * @param paramName a param�ter neve
     * @return a param�ter sz�veges �rt�ke
     */
    function getBooleanValue($value, $dflt = false) {
        $boolValue = false;
        
        if (is_bool($value)) {
            $boolValue = $value;
        }
        else if (is_null($value)) {
            $boolValue = $dflt;
        }
        else {
            $boolValue = in_array(strtoupper($value), array ("TRUE", "ON", "YES", "1"));
        }

        return $boolValue;        
    }
    
    /**
     * Logikai t�pus� v�ltoz� �rt�k olyan string-� alak�t�sa,
     * mely a banki fel�leten a logikai �rt�ket reprezent�lja az egyes
     * h�v�sokban: "TRUE" vagy "FALSE" �rt�k.
     * 
     * Az alak�t�s szab�lya:
     * - false �rt�k: "FALSE"
     * - true vagy "true", "on", "yes" �rt�kek valamelyike: "TRUE"
     * - egy�bk�nt: a $dflt v�ltoz� �rt�ke, alap�rtelmez�s szerint "FALSE"
     * 
     * @param mixed value a logikai vagy string v�ltoz�
     * @return string a param�ter sz�veges �rt�ke
     */
    function booleanToString($value, $dflt = "FALSE") {
        $boolValue = RequestUtils::getBooleanValue($value, NULL);
        return ($boolValue === true ? "TRUE" : ($boolValue === false ? "FALSE" : $dflt));        
    }

    /**
     * Date t�pus� v�ltoz� �rt�k olyan string-� alak�t�sa,
     * mely a banki fel�leten a d�tum/id�pomt �rt�ket reprezent�lja az egyes
     * h�v�sokban: ����.HH.NN ��:PP:MM alak� �rt�k.
     * 
     * @param mixed value a d�tum v�ltoz�
     * @return string a param�ter sz�veges �rt�ke
     */
    function dateToString($value) {
        $strValue = false;
        
        if (is_string($value)) {
            $strValue = $value;
        }
        else if (is_int($value)) {
            $strValue = date("Y.m.d H:i:s", $value);
        }
                                 
        return $strValue;        
    }
    
    /**
    * @desc Adott url-hez hozz�f�z tov�bbi request param�tereket.
    * Az elj�r�ssal tetsz�leges url m�dos�that�.
    * Els�dleges c�lja a backURL manipul�l�sn�l van.
    */
    function addUrlQuery($url, $params) {
        $parsedUrl = parse_url($url); 
        parse_str($parsedUrl['query'], $queryParams);
        $queryParams = array_merge($queryParams, $params);
        $newQuery = NULL;
        foreach ($queryParams as $key => $value) {
            $newQuery .= ($newQuery ? '&' : '') . urlencode($key) . '='. urlencode($value); 
        }

        $newUrl = ''
            . (array_key_exists('scheme', $parsedUrl) ? $parsedUrl['scheme'] . '://' : '')
            . (array_key_exists('user', $parsedUrl) ? $parsedUrl['user'] : '')
            . (array_key_exists('pass', $parsedUrl) ? ':' . $parsedUrl['pass'] : '')
            . (array_key_exists('user', $parsedUrl) || array_key_exists('pass', $parsedUrl) ? '@' : '')
            . (array_key_exists('host', $parsedUrl) ? $parsedUrl['host'] : '')
            . (array_key_exists('port', $parsedUrl) ? ':' . $parsedUrl['port'] : '')
            . (array_key_exists('path', $parsedUrl) ? $parsedUrl['path'] : '')
            . ($newQuery ? '?' . $newQuery : '')
            . (array_key_exists('fragment', $parsedUrl) ? '#' . $parsedUrl['fragment'] : '');
        
        return $newUrl;
    }
    
    /**
    * @desc Vez�rl�s tov�bb�t�s adott c�mre (jellemz�en php k�dra).
    * - Amennyiben az $url-ben nincs host, felt�telezz�k, hogy lok�lis
    * f�jlr�l van sz�, ez�rt az include() utas�t�ssal hivatkozunk a 
    * f�jlra ahelyett, hogy redirect-�ln�nk r�. Ennek az az el�nye,
    * hogy a "h�v�" �ltal el��ll�tott _REQUEST �s _SESSION param�terek
    * gond n�lk�l el�rhet�ek. A f�jlnak, mint relat�v el�r�snek az 
    * include_path valamely eleme ment�n el�rhet�nek kell lennie.
    * - Ha az $url tartalmaz host megjel�l�st, akkor kliens oldali redirect
    * fog t�rt�nni ("Location" header param�ter gener�l�ssal)
    */
    function includeOrRedirect($url) {
        $parsedUrl = parse_url($url);
        if (!array_key_exists('host', $parsedUrl)) {
            include($url);   
        }
        else {
            header('Location: ' . $url);
        }
    }
    
    /**
    * @desc Konfigur�ci�s param�ter kiolvas�sa simpleshop
    * vagy multishop k�rnyezet szerint kialak�tott
    * .config �llom�nyb�l
    * 
    * @param Array config az konfigur�ci�s f�jl tartalma
    * @param String paramName a keresett konfigur�ci�s param�ter neve
    * @return string a param�ter �rt�ke vagy null
    */
    function safeParam($request, $paramName) {
        return array_key_exists($paramName, $request) ? $request[$paramName] : null;
    }
    
}

?>