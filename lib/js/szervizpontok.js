	var locations = [
		['<b>Szervizpont, Műszaki állomás</b><br />1112 Budapest, Budaörsi út 138.<br /><a href="szervizpont/1">Részletes adatok</a>', 47.464414,19.010164],
		['<b>Műszaki állomás</b><br />1095 Budapest, Soroksári út 158/a<br /><a href="szervizpont/2">Részletes adatok</a>', 47.44735,19.091018],
		['<b>Műszaki állomás</b><br />1183 Budapest, Nefelejcs u. 4.<br /><a href="szervizpont/allomas">Részletes adatok</a>', 47.454695,19.16821],
		['<b>Szervizpont, Műszaki állomás</b><br />1043 Budapest, Berda J. u. 15. <br /><a href="szervizpont/4">Részletes adatok</a>', 47.556291,19.085008],
		['<b>Műszaki állomás</b><br />1044 Budapest, Megyeri út 15/a <br /><a href="szervizpont/5">Részletes adatok</a>', 47.576196,19.084214],
		['<b>Műszaki állomás</b><br />9027 Győr,  Tompa u. 2. <br /><a href="szervizpont/6">Részletes adatok</a>',47.690511,17.655222],
		['<b>Műszaki állomás</b><br />9200 Mosonmagyaróvár, Gabona rkp. 2-6.<br /><a href="szervizpont/7">Részletes adatok</a>',47.844962,17.283382],
		['<b>Szervizpont, Műszaki állomás</b><br />2500 Esztergom, Schweidel u. 5.<br /><a href="szervizpont/8">Részletes adatok</a>',47.775108,18.744132],
		['<b>Szervizpont, Műszaki állomás</b><br />2800 Tatabánya, Komáromi u. 68.<br /><a href="szervizpont/9">Részletes adatok</a>',47.591998,18.393669],
		['<b>Műszaki állomás</b><br />2084 Pilisszentiván, Bánki D. u. 1. <br /><a href="szervizpont/10">Részletes adatok</a>',47.606179,18.902942],
		['<b>Műszaki állomás</b><br />2310 Szigetszentmiklós, Gyári út 9. kapu<br /><a href="szervizpont/11">Részletes adatok</a>',47.33795,19.035358],
		['<b>Szervizpont, Műszaki állomás</b><br />9400 Sopron, Lackner Kristóf u. 60. <br /><a href="szervizpont/2">Részletes adatok</a>',47.693788,16.581688],
		['<b>Műszaki állomás</b><br />9500 Celldömölk,  Zalka M. úti garázssor <br /><a href="szervizpont/18">Részletes adatok</a>',47.254563,17.160087],
		['<b>Szervizpont, Műszaki állomás</b><br />9730 Kőszeg, Szombathelyi út 3. <br /><a href="szervizpont/0">Részletes adatok</a>',47.379282,16.558039],
		['<b>Szervizpont, Műszaki állomás</b><br />2049 Diósd, Vadrózsa u. 19. (Ipari park)<br /><a href="szervizpont/12">Részletes adatok</a>',47.416168,18.934443],
		['<b>Műszaki állomás</b><br />2760 Nagykáta, Jászberényi út 1.<br /><a href="szervizpont/13">Részletes adatok</a>',47.417516,19.755175],
		['<b>Műszaki állomás</b><br />5000 Szolnok, Thököly út 48-56. <br /><a href="szervizpont/14">Részletes adatok</a>',47.186982,20.180405],
		['<b>Szervizpont, Műszaki állomás</b><br />6724 Szeged, Kossuth Lajos sgt. 114.<br /><a href="szervizpont/14">Részletes adatok</a>',46.260793,20.13874],
		['<b>Szervizpont, Műszaki állomás</b><br />6800 Hódmezővásárhely, Lévai u. 48.<br /><a href="szervizpont/13">Részletes adatok</a>',46.427604,20.311914],
		['<b>Szervizpont, Műszaki állomás</b><br />6600 Szentes, Villogó u. 20.<br /><a href="szervizpont/15">Részletes adatok</a>',46.648063,20.268585],
		['<b>Szervizpont, Műszaki állomás</b><br />6000 Kecskemét, Izzó u.1.<br /><a href="szervizpont/16">Részletes adatok</a>',46.881146,19.704199],
		['<b>Műszaki állomás</b><br />6300 Kalocsa, Miskei u. 5.<br /><a href="szervizpont/1">Részletes adatok</a>',46.519482,18.989854],
		['<b>Műszaki állomás</b><br />6100 Kiskunfélegyháza, Szegedi út 38.<br /><a href="szervizpont/4">Részletes adatok</a>',46.703374,19.850056],
		['<b>Műszaki állomás</b><br />6060 Tiszakécske, Szolnoki út 79.<br /><a href="szervizpont/0">Részletes adatok</a>',46.941942,20.097492],
		['<b>Szervizpont, Műszaki állomás</b><br />5600 Békéscsaba, Szarvasi út 82.<br /><a href="szervizpont/17">Részletes adatok</a>',46.684448,21.0554],
		['<b>Szervizpont, Műszaki állomás</b><br />4400 Nyíregyháza, Debreceni út 155.<br /><a href="szervizpont/18">Részletes adatok</a>',47.928723,21.718697],
		['<b>Műszaki állomás</b><br />4465 Rakamaz, Szent István u. 148.<br /><a href="szervizpont/9">Részletes adatok</a>',48.122612,21.460566],
		['<b>Műszaki állomás</b><br />4765 Csenger, Ady Endre u. 86.<br /><a href="szervizpont/8">Részletes adatok</a>',47.839066,22.672474],
		['<b>Műszaki állomás</b><br />2660 Balassagyarmat, Mikszáth u. 26.<br /><a href="szervizpont/22">Részletes adatok</a>',48.082426,19.298093],
		['<b>Szervizpont, Műszaki állomás</b><br />3100 Salgótarján, Bartók B. u. 14/a<br /><a href="szervizpont/19">Részletes adatok</a>',48.10178,19.800847],
		['<b>Műszaki állomás</b><br />3200 Gyöngyös, Déli Külhatár út 6.<br /><a href="szervizpont/23">Részletes adatok</a>',47.763627,19.914919],
		['<b>Műszaki állomás</b><br />3300 Eger, Kistályai út 6.<br /><a href="szervizpont/24">Részletes adatok</a>',47.887133,20.397213],
		['<b>Műszaki állomás</b><br />3531 Miskolc, Győri kapu 32.<br /><a href="szervizpont/25">Részletes adatok</a>',48.104068,20.756484],
		['<b>Műszaki állomás</b><br />3600 Ózd, Vasvári u. 110. <br /><a href="szervizpont/21">Részletes adatok</a>',48.218574,20.278772],
		['<b>Műszaki állomás</b><br />5350 Tiszafüred, Fürdő út 21. <br /><a href="szervizpont/17">Részletes adatok</a>',47.624141,20.747656],
		['<b>Műszaki állomás</b><br />7630 Pécs, Hengermalom u. 3. <br /><a href="szervizpont/16">Részletes adatok</a>',46.080619,18.257402],
		['<b>Műszaki állomás</b><br />7100 Szekszárd, Tolnai L. u. 2/a <br /><a href="szervizpont/15">Részletes adatok</a>',46.363543,18.701419],
		['<b>Műszaki állomás</b><br />7400 Kaposvár, Dombóvári u. 6. <br /><a href="szervizpont/12">Részletes adatok</a>',46.360868,17.820391],
		['<b>Szervizpont, Műszaki állomás</b><br />8600 Siófok, Vak Bottyán u. 55.  <br /><a href="szervizpont/6">Részletes adatok</a>',46.889874,18.063006],
		['<b>Szervizpont, Műszaki állomás</b><br />8000 Székesfehérvár, Sárkeresztúri u. 8. <br /><a href="szervizpont/10">Részletes adatok</a>',47.16935,18.42377],
		['<b>Szervizpont, Műszaki állomás</b><br />2400 Dunaújváros, Kenyérgyári út. 7. <br /><a href="szervizpont/11">Részletes adatok</a>',46.9584,18.93302],
		['<b>Szervizpont, Műszaki állomás</b><br />8200 Veszprém, Aradi Vértanúk u. 1. <br /><a href="szervizpont/7">Részletes adatok</a>',47.111063,17.923318],
		['<b>Szervizpont, Műszaki állomás</b><br />8900 Zalaegerszeg, Alsóerdei út 3/a <br /><a href="szervizpont/5">Részletes adatok</a>',46.828459,16.827813],
		['<b>Szervizpont, Műszaki állomás</b><br />8800 Nagykanizsa, Ligeti u. 21. <br /><a href="szervizpont/3">Részletes adatok</a>',46.450555,16.99692],
		['<b>Műszaki állomás</b><br />8960 Lenti, Táncsics u. 17 <br /><a href="szervizpont/20">Részletes adatok</a>',46.618451,16.530633],
		['<b>Szervizpont, Műszaki állomás</b><br />9900 Körmend,  Nap u. 1.<br /><a href="szervizpont/allomas">Részletes adatok</a>',47.015352,16.610703],
		['<b>Műszaki állomás</b><br />9700 Szombathely, Csaba u. 7. <br /><a href="szervizpont/19">Részletes adatok</a>',47.2245,16.64182]
    ];
        
function initialize() {
  	

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 7,
      center: new google.maps.LatLng( 47.44735,19.091018),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
	}
}	
initialize();
