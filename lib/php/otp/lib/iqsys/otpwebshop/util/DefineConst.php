<?php

/*

A WebShop PHP kliens �s a SimpleShop PHP komponensei �ltal haszn�latos
konstans sz�vegek, melyek a banki kommunik�ci�hoz kapcsol�dnak:
- banki tranzakci�k k�djai
- tranzakci� ind�t�shoz k�t�d� xml attrib�tum nevek
- haszn�lt konfigur�ci�s �llom�nyok (.config) kulcsai

@version 3.3.1
@author Bodn�r Imre (c) IQSYS Rt.

*/

/* A bolt oldali WEB fel�let �ltal haszn�lt karakter encoding */
if (!defined('WS_CUSTOMERPAGE_CHAR_ENCODING')) define('WS_CUSTOMERPAGE_CHAR_ENCODING', 'ISO-8859-2');

/* A bank oldali fel�let fel� haszn�lt karakter encoding */
if (!defined('WF_INPUTXML_ENCODING')) define('WF_INPUTXML_ENCODING', 'UTF-8');

/* A tranzakci�s napl�f�jl d�tum form�tuma */
if (!defined('LOG_DATE_FORMAT')) define ('LOG_DATE_FORMAT', 'Y.m.d. H:i:s');

/* Az ind�that� tranzakci�k nevei. */
define('WF_TRANZAZONGENERALAS', 'WEBSHOPTRANZAZONGENERALAS');
define('WF_HAROMSZEREPLOSFIZETES', 'WEBSHOPFIZETES');
define('WF_KETSZEREPLOSFIZETES', 'WEBSHOPFIZETESKETSZEREPLOS');
define('WF_TRANZAKCIOSTATUSZ', 'WEBSHOPTRANZAKCIOLEKERDEZES');
define('WF_KETLEPCSOSFIZETESLEZARAS', 'WEBSHOPFIZETESLEZARAS');

/* A v�lasz xml-ben mejelen� sikeres v�grehajt�sra utal� �zenetk�d. */ 
define ('WF_SUCCESS_TEXTS', 'SIKER');

/* Alap xml elemek. */
define('TEMPLATENAME_TAGNAME', 'TemplateName');
define('VARIABLES_TAGNAME', 'Variables');

define('CLIENTCODE', 'isClientCode');
define('CLIENTCODE_VALUE', 'WEBSHOP');

/* Input xml v�ltoz� nevek. */
define('AMOUNT', 'isAmount');
define('BACKURL', 'isBackURL');
define('CONSUMERRECEIPTNEEDED', 'isConsumerReceiptNeeded');
define('COUNTRYNEEDED', 'isCountryNeeded');
define('COUNTYNEEDED', 'isCountyNeeded');
define('EXCHANGE', 'isExchange');
define('LANGUAGECODE', 'isLanguageCode');
define('MAILADDRESSNEEDED', 'isMailAddressNeeded');
define('NAMENEEDED', 'isNameNeeded');
define('NARRATIONNEEDED', 'isNarrationNeeded');
define('POSID', 'isPOSID');
define('SETTLEMENTNEEDED', 'isSettlementNeeded');
define('SHOPCOMMENT', 'isShopComment');
define('STREETNEEDED', 'isStreetNeeded');
define('TRANSACTIONID', 'isTransactionID');
define('ZIPCODENEEDED', 'isZipcodeNeeded');
define('CLIENTSIGNATURE', 'isClientSignature');
define('CONSUMERREGISTRATIONNEEDED', 'isConsumerRegistrationNeeded');
define('CONSUMERREGISTRATIONID', 'isConsumerRegistrationID');
define('TWOSTAGED', 'isTwoStaged');

/* Input xml v�ltoz� nevek - k�tszerepl�s fizet�shez. */
define('CARDNUMBER', 'isCardNumber');
define('CVCCVV', 'isCVCCVV');
define('EXPIRATIONDATE', 'isExpirationDate');
define('NAME', 'isName');
define('FULLADDRESS', 'isFullAddress');
define('IPADDRESS', 'isIPAddress');
define('MAILADDRESS', 'isMailAddress');
define('TELEPHONE', 'isTelephone');

/* Input xml v�ltoz� nevek - tranzakci�k lek�rdez�s�hez. */
define('QUERYMAXRECORDS', 'isMaxRecords');
define('QUERYSTARTDATE', 'isStartDate');
define('QUERYENDDATE', 'isEndDate');

/* Input xml v�ltoz� nevek - k�tl�pcs�s fizet�s lez�r�s�hoz. */
define('APPROVED', 'isApproval');

/* Az input xml-ben megjelen� k�t fajta logikai �rt�k sz�veges form�ja. */ 
define('REQUEST_TRUE_CONST', 'TRUE');
define('REQUEST_FALSE_CONST', 'FALSE');

/* Alap�rtelmezett devizanem */
define('DEFAULT_DEVIZANEM',  'HUF');

/* WebShopService konfigur�ci�s f�jl kulcs �rt�kek */
define('PROPERTY_PRIVATEKEYFILE', 'otp.webshop.PRIVATE_KEY_FILE');
define('PROPERTY_OTPMWSERVERURL',  'otp.webshop.OTPMW_SERVER_URL');

define('PROPERTY_HTTPSPROXYHOST',  'otp.webshop.client.HTTPS_PROXYHOST');
define('PROPERTY_HTTPSPROXYPORT',  'otp.webshop.client.HTTPS_PROXYPORT');
define('PROPERTY_HTTPSPROXYUSER',  'otp.webshop.client.HTTPS_PROXYUSER');
define('PROPERTY_HTTPSPROXYPASSWORD',  'otp.webshop.client.HTTPS_PROXYPASSWORD');

define('PROPERTY_TRANSACTIONLOGDIR',  'otp.webshop.TRANSACTION_LOG_DIR');
define('PROPERTY_TRANSACTIONLOG_SUCCESS_DIR',  'otp.webshop.transaction_log_dir.SUCCESS_DIR');
define('PROPERTY_TRANSACTIONLOG_FAILED_DIR',  'otp.webshop.transaction_log_dir.FAILED_DIR');

define('PROPERTY_OPENSSL_EXECUTIONPATH', 'otp.webshop.OPENSSL_EXECUTEPATH');
define('PROPERTY_OPENSSL_EXECUTIONPARAMS', 'otp.webshop.OPENSSL_EXECUTEPARAMS');

/* Banki kommunik�ci�: �jrak�ld�sek maxim�lis sz�ma */
define('RESENDCOUNT',  10);

/* Banki kommunik�ci�: �jrak�ld�sek k�zti k�sleltet�si id� */
define('RESENDDELAY',  1);

/* Banki kommunik�ci�: �jrak�ld�sek csak akkor lehets�gesek, ha a lenti sz�veg
   szerepel az elutas�t�shoz tartoz� kiv�telben. */
define('RESEND_ERRORPATTERN',  "Maximum workflow number is reached");
  
?>