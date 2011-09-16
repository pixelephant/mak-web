<?php

/*

A Banki fel�let �ltal gener�lhat� �s dokument�lt hiba�zenet list�ja �s azok 
sz�veges megfelel�i.

Az �sszerendel�st a $errorMessages global v�ltoz� tartalmazza.

@version 3.3.1
@author Bodn�r Imre (c) IQSYS Rt.

*/

global $errorMessages;

$errorMessages = array(
    '050' => 'A megadott k�rtyaadatok hib�sak', 
    '051' => 'A megadott k�rtya lej�rt', 
    '055' => 'A megadott k�rtya blokkolt.', 
    '056' => 'A megadott k�rtyasz�m ismeretlen', 
    '057' => 'A megadott k�rtya elvesztett k�rtya', 
    '058' => 'A megadott k�rtyasz�m �rv�nytelen', 
    '059' => 'A megadott k�rtya lej�rt', 
    '069' => 'A megadott k�rtyaadatok hib�sak', 
    '070' => 'A megadott k�rtyasz�m �rv�nytelen, a BIN nem l�tezik', 
    '072' => 'A megadott k�rtya letiltott', 
    '074' => 'A megadott k�rtyaadatok hib�sak', 
    '076' => 'A megadott k�rtyaadatok hib�sak', 
    '082' => 'A megadott k�rtya terhel�se a megadott �sszeggel nem lehets�ges (jellemz�en v�s�rl�si limitt�ll�p�s miatt)', 
    '089' => 'A megadott k�rtyaadatok hib�sak, vagy nincs el�g fedezet', 
    '097' => 'A megadott bankk�rtya nem akt�v', 
    '200' => 'A megadott k�rtyaadatok hib�sak', 
    '204' => 'A megadott k�rtya terhel�se nem lehets�ges', 
    '205' => '�rv�nytelen �sszeg� v�s�rl�s', 
    '206' => 'A megadott k�rtya az �zlet�gi k�vetelm�nyeknek nem felel meg', 
    '901' => 'A megadott k�rtyasz�m �rv�nytelen, a BIN nem l�tezik', 
    '902' => 'A megadott k�rtya lej�rt', 
    '903' => 'A megadott bankk�rtya nem akt�v', 
    '909' => 'A megadott k�rtya terhel�se nem lehets�ges', 
    'BASE24TIMEOUT' => 'A k�rtya autoriz�ci�s rendszer a be�ll�tott id�n bel�l nem k�ld�tt v�laszt.', 
    'BINVISSZAUTASITVA' => 'A megadott k�rtyasz�mmal a fizet�si / regisztr�l�si tranzakci� nem enged�lyezett a bolt �ltal ig�nyelt bankk�rtya korl�toz�s miatt.', 
    'CDVKARTYA' => 'Hib�s bankk�rtyasz�m.',
    'DUPLAFIZETES' => 'A megadott tranzakci� azonos�t� nem egyedi, azzal m�r l�tezik fizet�si tranzakci�.', 
    'DUPLALEZARAS' => 'A megadott tranzakci� azonos�t�j� k�tl�pcs�s fizet�s  m�r lez�r�sra ker�lt, vagy lez�r�sa folyamatban van.', 
    'EXTREMDATUM' => 'Sz�ls�s�gesen t�voli vagy �rv�nytelen d�tum', 
    'FORMATUMBANKKARTYASZAM' => 'A megadott terhelend� k�rtyasz�m hib�s form�tum�', 
    'FORMATUMMENNYISEG' => 'A mennyis�g mez� form�tuma nem megfelel�.', 
    'FORMATUMTELEFONSZAM' => 'A megadott telefonsz�m nem �rtelmezhet� telefonsz�mk�nt.', 
    'FORMATUMTRANZAZON' => 'Hib�s form�tum� a megadott tranzakci� azonos�t�.', 
    'HIANYZIKBANKKARTYASZAM' => 'A terhelend� bankk�rtya sz�ma nem ker�lt megad�sra', 
    'HIANYZIKDATUM' => 'A bankk�rtya lej�rat d�tuma nem ker�lt megad�sra', 
    'HIANYZIKLOGIKAI' => 'K�telez�en kit�ltend� logikai �rt�k� param�ter nem ker�lt megad�sa', 
    'HIANYZIKMENNYISEG' => 'Az �sszeg mez� nem ker�lt kit�lt�sre', 
    'HIANYZIKNEV' => 'A n�v (bankk�rtya tulajdonos vagy v�s�rl� neve) adat nem ker�lt kit�lt�sre', 
    'HIANYZIKNYELVKOD' => 'A nyelvk�d nem ker�lt megad�sra', 
    'HIANYZIKPOSAZONOSITO' => 'A Shop azonos�t� �res.', 
    'HIANYZIKSHOPKERESKEDOAZONOSITO' => 'AMEX k�rty�val t�rt�n� fizet�s visszautas�t�sra ker�lt', 
    'HIANYZIKSHOPPUBLIKUSKULCS' => 'A shop-hoz a Fizet�fel�let rendszer�ben nem tal�lhat� a digit�lis al��r�s ellen�rz�s�hez sz�ks�ges publikus kulcs.', 
    'HIANYZIKTRANZAZON' => 'A tranzakci� azonos�t� �res', 
    'HIBASCVCCVV' => 'A bankk�rtya ellen�rz� (biztons�gi) k�dja nem vagy hib�san ker�lt megad�sra', 
    'HIBASDATUM' => 'Hib�s d�tum form�tum', 
    'HIBASDEVIZANEMKOD' => 'A devizanem k�d hib�s (neml�tez� vagy nem t�mogatott devizanem szerepel benne).', 
    'HIBASKLIENSALAIRAS' => 'A kapott digit�lis al��r�s nem hiteles, a t�rolt publikus kulccsal ellen�rizve hib�s ellen�rz� �sszeg keletkezett.', 
    'HIBASLEJARATDATUMA' => 'Hib�s form�tum� a k�rtya lej�rati d�tuma.', 
    'HIBASNYELVKOD' => 'Hib�s form�tum� vagy hib�s �rt�k� nyelvk�d �rt�k (l�sd ISO 639 nyelvk�dokat)', 
    'HIBASPOSAZONOSITO' => 'Hib�s form�tum� a megadott shop azonos�t� (POS ID)', 
    'IDONTULIFELOLDAS' => 'A fizet�s lez�r�sa �s a foglal�s felold�sa a t�relmi id�szak�n t�l nem lehets�ges.', 
    'IDONTULITERHELES' => 'A fizet�s lez�r�sa �s a terhel�s v�grehajt�sa a t�relmi id�szak�n t�l nem lehets�ges.', 
    'INDULODATUMNAGYOBBAKTUALIS' => 'A sz�r� id� intervallum als� hat�ra nem lehet k�s�bbi az aktu�lis id�pontn�l.', 
    'KLIENSKODHIBA' => 'A Fizet�fel�let tranzakci�iban a kliens k�d csak "WEBSHOP� lehet', 
    'LEZARTKETLEPCSOSFIZETES' => 'A megadott tranzakci� azonos�t�j� k�tl�pcs�s fizet�sre lez�r�sra (elutas�t�sra/felold�sra) ker�lt, vagy lez�r�sa folyamatban van.', 
    'LETEZOFIZETESITRANZAKCIO' => 'A megadott tranzakci� azonos�t�val m�r l�tezik fizet�si tranzakci�.',
    'MENNYISEGPOZITIV' => 'A mennyis�g mez� tartalma csak pozit�v lehet', 
    'NEMENGWEBSHOPFUNKCIO' => 'A funkci� a h�v� bolt sz�m�ra nem enged�lyezett.', 
    'NEMKETLEPCSOSFIZETES' => 'A megadott tranzakci� azonos�t� nem k�tl�pcs�s fizet�sre vonatkozik.', 
    'NEMLEZARASRAVAROTRANZAKCIO' => 'A megadott tranzakci� nem k�tl�pcs�s vagy nem a fizet�s  lez�r�s�ra v�rakozik.', 
    'NEMLOGIKAI' => 'A megadott logikai �rt�k �rv�nytelen', 
    'NINCSILYENWEBSHOP' => 'A megadott azonos�t�val (POS ID) nem l�tezik ismert shop', 
    'RENDSZERHIBA' => 'S�lyos Fizet�fel�let-oldali hiba a folyamat feldolgoz�sa k�zben. A folyamat be�ll�t�si vagy m�s bels� probl�ma miatt nem tudott helyesen lefutni.', 
    'WEBSHOPIPNEMENGEDELYEZETT' => 'Az IP c�mr�l a Bank nem fogad el fizet�fel�let tranzakci� k�r�seket', 
    'ZARODATUMNAGYOBBINDULO' => 'A sz�r� id� intervallum fels� hat�ra nem lehet k�s�bbi az als� hat�r id�pontn�l.', 
    'NEMLETEZOWEBSHOPUGYFELAZON' => 'A megadott �gyf�l regisztr�ci�s azonos�t� nem l�tezik vagy deregisztr�l�sra ker�lt.',
);

function getMessageText($messageCode)  {
    global $errorMessages;
    return $errorMessages[$messageCode];
}

?>