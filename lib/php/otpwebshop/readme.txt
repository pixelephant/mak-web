OTP Internetes kártyás Fizetofelület, 3.3.1 verzió 
A Fizetõfelület szolgáltatásának használatát szemléltetö rövid demonstrációs 
minta programok. PHP nyelvû forráskódok.


A vezérlõ logika megvalósítása az úgyneveztett kontroller eljárásokban 
találató, mely eljárások a simpleshop könyvtár alatti ..._control.php
programfájlokban találhatók:
- fiz3_control.php          háromszereplõs fizetési tranzakció vezérlse
- tranzLek_control.php      fizetési tranzakció lekérdezés indítása
- fiz2_control.php          kétszereplõs fizetési tranzakció vezérlése
- tranzLezaras_control.php  kétlépcsõs fizetési tranzakció lezárásának indítása

A teszt üzemû tranzakciók indítását megvalósító teszt felhasználó felület
oldalai a web_demo könyvtárban találhatók. Telepítás után a felület nyitóoldala a 
http://localhost:80/otpwebshop/web_demo/_index.php címen érhetõ el. 
A teszt oldalakról indítható tranzakciók csak akkor hajthatók végre, ha elõzetesen 
a WebShop PHP kliens sikeresen telepítésre és konfigurálásra került, 
hiszen a SimpleShop PHP a banki oldalt azon keresztül hívja meg.

Az oldalak a kontroller eljárásokon keresztül érik el a banki felülete.
Az oldalak mindegyike csak web-es felületen érhetõ el, önállóan 
(parancssorból) futtatható PHP példaprogramokat nem  mellékelünk!

Az egyes web_demo php fájlok (oldalak) elnevezése az alábbi konvenciót követik:
<tranzakció><üzemmód>_<oldal jellege/hívási mód>.php
Ahol
* a tranzakció lehet 
  - fiz3                háromszereplõs fizetési tranzakció
  - fiz2                kétszereplõs fizetési tranzakció
  - tranzAzon           tranzakció azonosító generálás
  - tranzLek            tranzakciós adatok lekérdezése
  - lezaras             kétlépcsõs fizetési tranzakció lezárása
  - ping                ping
* az üzemmód lehet
  - (üres)              alapértelmezett üzemmód/fizetési mód futtatás
  - regfiz              regisztrált ügyféllel történõ fizetés
  - reg                 ügyfél regisztrálás (fizetés nélkül)
  - fizreg              fizetés regisztrálással egybekötve
  - ketlepcsos          kétlépcsõs (foglalásos) fizetés
* az oldal jellege
  - form                beviteli oldal a tranzakció vagy lekérdezés 
                        adatainak megadásához 
  - answer_i            válasz oldal, melyet a kontroller include utasítással
                        "jelenít meg" 
  - success_r           válasz oldal a sikeresen végrehajtott tranzakciókhoz,
                        melyre a kérés redirect-álásával kerül a vezérlés
  - error_r             válasz oldal a hibásan vágrehajtott tranzakciókhoz,
                        melyre a kérés redirect-álásával kerül a vezérlés
  - unknown_r           válasz oldal a hibásan végrehajtott tranzakciókhoz,
                        melyre a kérés redirect-álásával kerül a vezérlés
  - cancelled_r         válasz oldal a visszautasított tranzakciókhoz,
                        melyre a kérés redirect-álásával kerül a vezérlés
                        
A kontrollek mûködéséhez szükséges beállításokat és egyéb rendszer szintû 
paramétereket a config könyvtár .conf állományai tartalmazzák.

