OTP Internetes k�rty�s Fizetofel�let, 3.3.1 verzi� 
A Fizet�fel�let szolg�ltat�s�nak haszn�lat�t szeml�ltet� r�vid demonstr�ci�s 
minta programok. PHP nyelv� forr�sk�dok.


A vez�rl� logika megval�s�t�sa az �gyneveztett kontroller elj�r�sokban 
tal�lat�, mely elj�r�sok a simpleshop k�nyvt�r alatti ..._control.php
programf�jlokban tal�lhat�k:
- fiz3_control.php          h�romszerepl�s fizet�si tranzakci� vez�rlse
- tranzLek_control.php      fizet�si tranzakci� lek�rdez�s ind�t�sa
- fiz2_control.php          k�tszerepl�s fizet�si tranzakci� vez�rl�se
- tranzLezaras_control.php  k�tl�pcs�s fizet�si tranzakci� lez�r�s�nak ind�t�sa

A teszt �zem� tranzakci�k ind�t�s�t megval�s�t� teszt felhaszn�l� fel�let
oldalai a web_demo k�nyvt�rban tal�lhat�k. Telep�t�s ut�n a fel�let nyit�oldala a 
http://localhost:80/otpwebshop/web_demo/_index.php c�men �rhet� el. 
A teszt oldalakr�l ind�that� tranzakci�k csak akkor hajthat�k v�gre, ha el�zetesen 
a WebShop PHP kliens sikeresen telep�t�sre �s konfigur�l�sra ker�lt, 
hiszen a SimpleShop PHP a banki oldalt azon kereszt�l h�vja meg.

Az oldalak a kontroller elj�r�sokon kereszt�l �rik el a banki fel�lete.
Az oldalak mindegyike csak web-es fel�leten �rhet� el, �n�ll�an 
(parancssorb�l) futtathat� PHP p�ldaprogramokat nem  mell�kel�nk!

Az egyes web_demo php f�jlok (oldalak) elnevez�se az al�bbi konvenci�t k�vetik:
<tranzakci�><�zemm�d>_<oldal jellege/h�v�si m�d>.php
Ahol
* a tranzakci� lehet 
  - fiz3                h�romszerepl�s fizet�si tranzakci�
  - fiz2                k�tszerepl�s fizet�si tranzakci�
  - tranzAzon           tranzakci� azonos�t� gener�l�s
  - tranzLek            tranzakci�s adatok lek�rdez�se
  - lezaras             k�tl�pcs�s fizet�si tranzakci� lez�r�sa
  - ping                ping
* az �zemm�d lehet
  - (�res)              alap�rtelmezett �zemm�d/fizet�si m�d futtat�s
  - regfiz              regisztr�lt �gyf�llel t�rt�n� fizet�s
  - reg                 �gyf�l regisztr�l�s (fizet�s n�lk�l)
  - fizreg              fizet�s regisztr�l�ssal egybek�tve
  - ketlepcsos          k�tl�pcs�s (foglal�sos) fizet�s
* az oldal jellege
  - form                beviteli oldal a tranzakci� vagy lek�rdez�s 
                        adatainak megad�s�hoz 
  - answer_i            v�lasz oldal, melyet a kontroller include utas�t�ssal
                        "jelen�t meg" 
  - success_r           v�lasz oldal a sikeresen v�grehajtott tranzakci�khoz,
                        melyre a k�r�s redirect-�l�s�val ker�l a vez�rl�s
  - error_r             v�lasz oldal a hib�san v�grehajtott tranzakci�khoz,
                        melyre a k�r�s redirect-�l�s�val ker�l a vez�rl�s
  - unknown_r           v�lasz oldal a hib�san v�grehajtott tranzakci�khoz,
                        melyre a k�r�s redirect-�l�s�val ker�l a vez�rl�s
  - cancelled_r         v�lasz oldal a visszautas�tott tranzakci�khoz,
                        melyre a k�r�s redirect-�l�s�val ker�l a vez�rl�s
                        
A kontrollek m�k�d�s�hez sz�ks�ges be�ll�t�sokat �s egy�b rendszer szint� 
param�tereket a config k�nyvt�r .conf �llom�nyai tartalmazz�k.

