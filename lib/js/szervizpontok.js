function initialize() {
      map = new GMap2(document.getElementById("map"));
      map.addControl(new GSmallMapControl());
      map.addControl(new GMapTypeControl());
      map.setCenter(new GLatLng(47.083683,19.156723), 7);
                var htmllabel0 = '<b>Szervizpont, Műszaki állomás</b><br />1112 Budapest, Budaörsi út 138.<br /><a href="/ugyfelpontok/muszaki-allomasok/szervizpont-muszaki-allomas-1">Részletes adatok</a>';
        var address = 'Budaörsi út 138., 1112, Budapest, Hungary';
        var marker0 = new GMarker(new GLatLng(47.464414,19.010164));
        map.addOverlay(marker0);
        GEvent.addListener(marker0, "click", function() {
            marker0.openInfoWindowHtml(htmllabel0);
        });
                var htmllabel1 = '<b>Műszaki állomás</b><br />1095 Budapest, Soroksári út 158/a<br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas-2">Részletes adatok</a>';
        var address = 'Soroksári út 158/a, 1095, Budapest, Hungary';
        var marker1 = new GMarker(new GLatLng(47.44735,19.091018));
        map.addOverlay(marker1);
        GEvent.addListener(marker1, "click", function() {
            marker1.openInfoWindowHtml(htmllabel1);
        });
                var htmllabel2 = '<b>Műszaki állomás</b><br />1183 Budapest, Nefelejcs u. 4.<br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas">Részletes adatok</a>';
        var address = 'Nefelejcs u. 4., 1183, Budapest, Hungary';
        var marker2 = new GMarker(new GLatLng(47.454695,19.16821));
        map.addOverlay(marker2);
        GEvent.addListener(marker2, "click", function() {
            marker2.openInfoWindowHtml(htmllabel2);
        });
                var htmllabel3 = '<b>Szervizpont, Műszaki állomás</b><br />1043 Budapest, Berda J. u. 15. <br /><a href="/ugyfelpontok/muszaki-allomasok/szervizpont-muszaki-allomas-4">Részletes adatok</a>';
        var address = 'Berda J. u. 15. , 1043, Budapest, Hungary';
        var marker3 = new GMarker(new GLatLng(47.556291,19.085008));
        map.addOverlay(marker3);
        GEvent.addListener(marker3, "click", function() {
            marker3.openInfoWindowHtml(htmllabel3);
        });
                var htmllabel4 = '<b>Műszaki állomás</b><br />1044 Budapest, Megyeri út 15/a <br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas-5">Részletes adatok</a>';
        var address = 'Megyeri út 15/a , 1044, Budapest, Hungary';
        var marker4 = new GMarker(new GLatLng(47.576196,19.084214));
        map.addOverlay(marker4);
        GEvent.addListener(marker4, "click", function() {
            marker4.openInfoWindowHtml(htmllabel4);
        });
                var htmllabel5 = '<b>Műszaki állomás</b><br />9027 Győr,  Tompa u. 2. <br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas-6">Részletes adatok</a>';
        var address = ' Tompa u. 2. , 9027, Győr, Hungary';
        var marker5 = new GMarker(new GLatLng(47.690511,17.655222));
        map.addOverlay(marker5);
        GEvent.addListener(marker5, "click", function() {
            marker5.openInfoWindowHtml(htmllabel5);
        });
                var htmllabel6 = '<b>Műszaki állomás</b><br />9200 Mosonmagyaróvár, Gabona rkp. 2-6.<br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas-7">Részletes adatok</a>';
        var address = 'Gabona rkp. 2-6., 9200, Mosonmagyaróvár, Hungary';
        var marker6 = new GMarker(new GLatLng(47.844962,17.283382));
        map.addOverlay(marker6);
        GEvent.addListener(marker6, "click", function() {
            marker6.openInfoWindowHtml(htmllabel6);
        });
                var htmllabel7 = '<b>Szervizpont, Műszaki állomás</b><br />2500 Esztergom, Schweidel u. 5.<br /><a href="/ugyfelpontok/muszaki-allomasok/szervizpont-muszaki-allomas-8">Részletes adatok</a>';
        var address = 'Schweidel u. 5., 2500, Esztergom, Hungary';
        var marker7 = new GMarker(new GLatLng(47.775108,18.744132));
        map.addOverlay(marker7);
        GEvent.addListener(marker7, "click", function() {
            marker7.openInfoWindowHtml(htmllabel7);
        });
                var htmllabel8 = '<b>Szervizpont, Műszaki állomás</b><br />2800 Tatabánya, Komáromi u. 68.<br /><a href="/ugyfelpontok/muszaki-allomasok/szervizpont-muszaki-allomas-9">Részletes adatok</a>';
        var address = 'Komáromi u. 68., 2800, Tatabánya, Hungary';
        var marker8 = new GMarker(new GLatLng(47.591998,18.393669));
        map.addOverlay(marker8);
        GEvent.addListener(marker8, "click", function() {
            marker8.openInfoWindowHtml(htmllabel8);
        });
                var htmllabel9 = '<b>Műszaki állomás</b><br />2084 Pilisszentiván, Bánki D. u. 1. <br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas-10">Részletes adatok</a>';
        var address = 'Bánki D. u. 1. , 2084, Pilisszentiván, Hungary';
        var marker9 = new GMarker(new GLatLng(47.606179,18.902942));
        map.addOverlay(marker9);
        GEvent.addListener(marker9, "click", function() {
            marker9.openInfoWindowHtml(htmllabel9);
        });
                var htmllabel10 = '<b>Műszaki állomás</b><br />2310 Szigetszentmiklós, Gyári út 9. kapu<br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas-11">Részletes adatok</a>';
        var address = 'Gyári út 9. kapu, 2310, Szigetszentmiklós, Hungary';
        var marker10 = new GMarker(new GLatLng(47.33795,19.035358));
        map.addOverlay(marker10);
        GEvent.addListener(marker10, "click", function() {
            marker10.openInfoWindowHtml(htmllabel10);
        });
                var htmllabel11 = '<b>Szervizpont, Műszaki állomás</b><br />2049 Diósd, Vadrózsa u. 19. (Ipari park)<br /><a href="/ugyfelpontok/muszaki-allomasok/szervizpont-muszaki-allomas-12">Részletes adatok</a>';
        var address = 'Vadrózsa u. 19. (Ipari park), 2049, Diósd, Hungary';
        var marker11 = new GMarker(new GLatLng(47.416168,18.934443));
        map.addOverlay(marker11);
        GEvent.addListener(marker11, "click", function() {
            marker11.openInfoWindowHtml(htmllabel11);
        });
                var htmllabel12 = '<b>Műszaki állomás</b><br />2760 Nagykáta, Jászberényi út 1.<br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas-13">Részletes adatok</a>';
        var address = 'Jászberényi út 1., 2760, Nagykáta, Hungary';
        var marker12 = new GMarker(new GLatLng(47.417516,19.755175));
        map.addOverlay(marker12);
        GEvent.addListener(marker12, "click", function() {
            marker12.openInfoWindowHtml(htmllabel12);
        });
                var htmllabel13 = '<b>Műszaki állomás</b><br />5000 Szolnok, Thököly út 48-56. <br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas-14">Részletes adatok</a>';
        var address = 'Thököly út 48-56. , 5000, Szolnok, Hungary';
        var marker13 = new GMarker(new GLatLng(47.186982,20.180405));
        map.addOverlay(marker13);
        GEvent.addListener(marker13, "click", function() {
            marker13.openInfoWindowHtml(htmllabel13);
        });
                var htmllabel14 = '<b>Szervizpont, Műszaki állomás</b><br />6724 Szeged, Kossuth Lajos sgt. 114.<br /><a href="/ugyfelpontok/muszaki-allomasok/szervizpont-muszaki-allomas-14">Részletes adatok</a>';
        var address = 'Kossuth Lajos sgt. 114., 6724, Szeged, Hungary';
        var marker14 = new GMarker(new GLatLng(46.260793,20.13874));
        map.addOverlay(marker14);
        GEvent.addListener(marker14, "click", function() {
            marker14.openInfoWindowHtml(htmllabel14);
        });
                var htmllabel15 = '<b>Szervizpont, Műszaki állomás</b><br />6800 Hódmezővásárhely, Lévai u. 48.<br /><a href="/ugyfelpontok/muszaki-allomasok/szervizpont-muszaki-allomas-13">Részletes adatok</a>';
        var address = 'Lévai u. 48., 6800, Hódmezővásárhely, Hungary';
        var marker15 = new GMarker(new GLatLng(46.427604,20.311914));
        map.addOverlay(marker15);
        GEvent.addListener(marker15, "click", function() {
            marker15.openInfoWindowHtml(htmllabel15);
        });
                var htmllabel16 = '<b>Szervizpont, Műszaki állomás</b><br />6600 Szentes, Villogó u. 20.<br /><a href="/ugyfelpontok/muszaki-allomasok/szervizpont-muszaki-allomas-15">Részletes adatok</a>';
        var address = 'Villogó u. 20., 6600, Szentes, Hungary';
        var marker16 = new GMarker(new GLatLng(46.648063,20.268585));
        map.addOverlay(marker16);
        GEvent.addListener(marker16, "click", function() {
            marker16.openInfoWindowHtml(htmllabel16);
        });
                var htmllabel17 = '<b>Szervizpont, Műszaki állomás</b><br />6000 Kecskemét, Izzó u.1.<br /><a href="/ugyfelpontok/muszaki-allomasok/szervizpont-muszaki-allomas-16">Részletes adatok</a>';
        var address = 'Izzó u.1., 6000, Kecskemét, Hungary';
        var marker17 = new GMarker(new GLatLng(46.881146,19.704199));
        map.addOverlay(marker17);
        GEvent.addListener(marker17, "click", function() {
            marker17.openInfoWindowHtml(htmllabel17);
        });
                var htmllabel18 = '<b>Műszaki állomás</b><br />6300 Kalocsa, Miskei u. 5.<br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas-1">Részletes adatok</a>';
        var address = 'Miskei u. 5., 6300, Kalocsa, Hungary';
        var marker18 = new GMarker(new GLatLng(46.519482,18.989854));
        map.addOverlay(marker18);
        GEvent.addListener(marker18, "click", function() {
            marker18.openInfoWindowHtml(htmllabel18);
        });
                var htmllabel19 = '<b>Műszaki állomás</b><br />6100 Kiskunfélegyháza, Szegedi út 38.<br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas-4">Részletes adatok</a>';
        var address = 'Szegedi út 38., 6100, Kiskunfélegyháza, Hungary';
        var marker19 = new GMarker(new GLatLng(46.703374,19.850056));
        map.addOverlay(marker19);
        GEvent.addListener(marker19, "click", function() {
            marker19.openInfoWindowHtml(htmllabel19);
        });
                var htmllabel20 = '<b>Műszaki állomás</b><br />6060 Tiszakécske, Szolnoki út 79.<br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas-0">Részletes adatok</a>';
        var address = 'Szolnoki út 79., 6060, Tiszakécske, Hungary';
        var marker20 = new GMarker(new GLatLng(46.941942,20.097492));
        map.addOverlay(marker20);
        GEvent.addListener(marker20, "click", function() {
            marker20.openInfoWindowHtml(htmllabel20);
        });
                var htmllabel21 = '<b>Szervizpont, Műszaki állomás</b><br />5600 Békéscsaba, Szarvasi út 82.<br /><a href="/ugyfelpontok/muszaki-allomasok/szervizpont-muszaki-allomas-17">Részletes adatok</a>';
        var address = 'Szarvasi út 82., 5600, Békéscsaba, Hungary';
        var marker21 = new GMarker(new GLatLng(46.684448,21.0554));
        map.addOverlay(marker21);
        GEvent.addListener(marker21, "click", function() {
            marker21.openInfoWindowHtml(htmllabel21);
        });
                var htmllabel22 = '<b>Szervizpont, Műszaki állomás</b><br />4400 Nyíregyháza, Debreceni út 155.<br /><a href="/ugyfelpontok/muszaki-allomasok/szervizpont-muszaki-allomas-18">Részletes adatok</a>';
        var address = 'Debreceni út 155., 4400, Nyíregyháza, Hungary';
        var marker22 = new GMarker(new GLatLng(47.928723,21.718697));
        map.addOverlay(marker22);
        GEvent.addListener(marker22, "click", function() {
            marker22.openInfoWindowHtml(htmllabel22);
        });
                var htmllabel23 = '<b>Műszaki állomás</b><br />4465 Rakamaz, Szent István u. 148.<br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas-9">Részletes adatok</a>';
        var address = 'Szent István u. 148., 4465, Rakamaz, Hungary';
        var marker23 = new GMarker(new GLatLng(48.122612,21.460566));
        map.addOverlay(marker23);
        GEvent.addListener(marker23, "click", function() {
            marker23.openInfoWindowHtml(htmllabel23);
        });
                var htmllabel24 = '<b>Műszaki állomás</b><br />4765 Csenger, Ady Endre u. 86.<br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas-8">Részletes adatok</a>';
        var address = 'Ady Endre u. 86., 4765, Csenger, Hungary';
        var marker24 = new GMarker(new GLatLng(47.839066,22.672474));
        map.addOverlay(marker24);
        GEvent.addListener(marker24, "click", function() {
            marker24.openInfoWindowHtml(htmllabel24);
        });
                var htmllabel25 = '<b>Műszaki állomás</b><br />2660 Balassagyarmat, Mikszáth u. 26.<br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas-22">Részletes adatok</a>';
        var address = 'Mikszáth u. 26., 2660, Balassagyarmat, Hungary';
        var marker25 = new GMarker(new GLatLng(48.082426,19.298093));
        map.addOverlay(marker25);
        GEvent.addListener(marker25, "click", function() {
            marker25.openInfoWindowHtml(htmllabel25);
        });
                var htmllabel26 = '<b>Szervizpont, Műszaki állomás</b><br />3100 Salgótarján, Bartók B. u. 14/a<br /><a href="/ugyfelpontok/muszaki-allomasok/szervizpont-muszaki-allomas-19">Részletes adatok</a>';
        var address = 'Bartók B. u. 14/a, 3100, Salgótarján, Hungary';
        var marker26 = new GMarker(new GLatLng(48.10178,19.800847));
        map.addOverlay(marker26);
        GEvent.addListener(marker26, "click", function() {
            marker26.openInfoWindowHtml(htmllabel26);
        });
                var htmllabel27 = '<b>Műszaki állomás</b><br />3200 Gyöngyös, Déli Külhatár út 6.<br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas-23">Részletes adatok</a>';
        var address = 'Déli Külhatár út 6., 3200, Gyöngyös, Hungary';
        var marker27 = new GMarker(new GLatLng(47.763627,19.914919));
        map.addOverlay(marker27);
        GEvent.addListener(marker27, "click", function() {
            marker27.openInfoWindowHtml(htmllabel27);
        });
                var htmllabel28 = '<b>Műszaki állomás</b><br />3300 Eger, Kistályai út 6.<br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas-24">Részletes adatok</a>';
        var address = 'Kistályai út 6., 3300, Eger, Hungary';
        var marker28 = new GMarker(new GLatLng(47.887133,20.397213));
        map.addOverlay(marker28);
        GEvent.addListener(marker28, "click", function() {
            marker28.openInfoWindowHtml(htmllabel28);
        });
                var htmllabel29 = '<b>Műszaki állomás</b><br />3531 Miskolc, Győri kapu 32.<br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas-25">Részletes adatok</a>';
        var address = 'Győri kapu 32., 3531, Miskolc, Hungary';
        var marker29 = new GMarker(new GLatLng(48.104068,20.756484));
        map.addOverlay(marker29);
        GEvent.addListener(marker29, "click", function() {
            marker29.openInfoWindowHtml(htmllabel29);
        });
                var htmllabel30 = '<b>Műszaki állomás</b><br />3600 Ózd, Vasvári u. 110. <br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas-21">Részletes adatok</a>';
        var address = 'Vasvári u. 110. , 3600, Ózd, Hungary';
        var marker30 = new GMarker(new GLatLng(48.218574,20.278772));
        map.addOverlay(marker30);
        GEvent.addListener(marker30, "click", function() {
            marker30.openInfoWindowHtml(htmllabel30);
        });
                var htmllabel31 = '<b>Műszaki állomás</b><br />5350 Tiszafüred, Fürdő út 21. <br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas-17">Részletes adatok</a>';
        var address = 'Fürdő út 21. , 5350, Tiszafüred, Hungary';
        var marker31 = new GMarker(new GLatLng(47.624141,20.747656));
        map.addOverlay(marker31);
        GEvent.addListener(marker31, "click", function() {
            marker31.openInfoWindowHtml(htmllabel31);
        });
                var htmllabel32 = '<b>Műszaki állomás</b><br />7630 Pécs, Hengermalom u. 3. <br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas-16">Részletes adatok</a>';
        var address = 'Hengermalom u. 3. , 7630, Pécs, Hungary';
        var marker32 = new GMarker(new GLatLng(46.080619,18.257402));
        map.addOverlay(marker32);
        GEvent.addListener(marker32, "click", function() {
            marker32.openInfoWindowHtml(htmllabel32);
        });
                var htmllabel33 = '<b>Műszaki állomás</b><br />7100 Szekszárd, Tolnai L. u. 2/a <br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas-15">Részletes adatok</a>';
        var address = 'Tolnai L. u. 2/a , 7100, Szekszárd, Hungary';
        var marker33 = new GMarker(new GLatLng(46.363543,18.701419));
        map.addOverlay(marker33);
        GEvent.addListener(marker33, "click", function() {
            marker33.openInfoWindowHtml(htmllabel33);
        });
                var htmllabel34 = '<b>Műszaki állomás</b><br />7400 Kaposvár, Dombóvári u. 6. <br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas-12">Részletes adatok</a>';
        var address = 'Dombóvári u. 6. , 7400, Kaposvár, Hungary';
        var marker34 = new GMarker(new GLatLng(46.360868,17.820391));
        map.addOverlay(marker34);
        GEvent.addListener(marker34, "click", function() {
            marker34.openInfoWindowHtml(htmllabel34);
        });
                var htmllabel35 = '<b>Szervizpont, Műszaki állomás</b><br />8600 Siófok, Vak Bottyán u. 55.  <br /><a href="/ugyfelpontok/muszaki-allomasok/szervizpont-muszaki-allomas-6">Részletes adatok</a>';
        var address = 'Vak Bottyán u. 55.  , 8600, Siófok, Hungary';
        var marker35 = new GMarker(new GLatLng(46.889874,18.063006));
        map.addOverlay(marker35);
        GEvent.addListener(marker35, "click", function() {
            marker35.openInfoWindowHtml(htmllabel35);
        });
                var htmllabel36 = '<b>Szervizpont, Műszaki állomás</b><br />8000 Székesfehérvár, Sárkeresztúri u. 8. <br /><a href="/ugyfelpontok/muszaki-allomasok/szervizpont-muszaki-allomas-10">Részletes adatok</a>';
        var address = 'Sárkeresztúri u. 8. , 8000, Székesfehérvár, Hungary';
        var marker36 = new GMarker(new GLatLng(47.16935,18.42377));
        map.addOverlay(marker36);
        GEvent.addListener(marker36, "click", function() {
            marker36.openInfoWindowHtml(htmllabel36);
        });
                var htmllabel37 = '<b>Szervizpont, Műszaki állomás</b><br />2400 Dunaújváros, Kenyérgyári út. 7. <br /><a href="/ugyfelpontok/muszaki-allomasok/szervizpont-muszaki-allomas-11">Részletes adatok</a>';
        var address = 'Kenyérgyári út. 7. , 2400, Dunaújváros, Hungary';
        var marker37 = new GMarker(new GLatLng(46.9584,18.93302));
        map.addOverlay(marker37);
        GEvent.addListener(marker37, "click", function() {
            marker37.openInfoWindowHtml(htmllabel37);
        });
                var htmllabel38 = '<b>Szervizpont, Műszaki állomás</b><br />8200 Veszprém, Aradi Vértanúk u. 1. <br /><a href="/ugyfelpontok/muszaki-allomasok/szervizpont-muszaki-allomas-7">Részletes adatok</a>';
        var address = 'Aradi Vértanúk u. 1. , 8200, Veszprém, Hungary';
        var marker38 = new GMarker(new GLatLng(47.111063,17.923318));
        map.addOverlay(marker38);
        GEvent.addListener(marker38, "click", function() {
            marker38.openInfoWindowHtml(htmllabel38);
        });
                var htmllabel39 = '<b>Szervizpont, Műszaki állomás</b><br />8900 Zalaegerszeg, Alsóerdei út 3/a <br /><a href="/ugyfelpontok/muszaki-allomasok/szervizpont-muszaki-allomas-5">Részletes adatok</a>';
        var address = 'Alsóerdei út 3/a , 8900, Zalaegerszeg, Hungary';
        var marker39 = new GMarker(new GLatLng(46.828459,16.827813));
        map.addOverlay(marker39);
        GEvent.addListener(marker39, "click", function() {
            marker39.openInfoWindowHtml(htmllabel39);
        });
                var htmllabel40 = '<b>Szervizpont, Műszaki állomás</b><br />8800 Nagykanizsa, Ligeti u. 21. <br /><a href="/ugyfelpontok/muszaki-allomasok/szervizpont-muszaki-allomas-3">Részletes adatok</a>';
        var address = 'Ligeti u. 21. , 8800, Nagykanizsa, Hungary';
        var marker40 = new GMarker(new GLatLng(46.450555,16.99692));
        map.addOverlay(marker40);
        GEvent.addListener(marker40, "click", function() {
            marker40.openInfoWindowHtml(htmllabel40);
        });
                var htmllabel41 = '<b>Műszaki állomás</b><br />8960 Lenti, Táncsics u. 17 <br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas-20">Részletes adatok</a>';
        var address = 'Táncsics u. 17 , 8960, Lenti, Hungary';
        var marker41 = new GMarker(new GLatLng(46.618451,16.530633));
        map.addOverlay(marker41);
        GEvent.addListener(marker41, "click", function() {
            marker41.openInfoWindowHtml(htmllabel41);
        });
                var htmllabel42 = '<b>Szervizpont, Műszaki állomás</b><br />9900 Körmend,  Nap u. 1.<br /><a href="/ugyfelpontok/muszaki-allomasok/szervizpont-muszaki-allomas">Részletes adatok</a>';
        var address = ' Nap u. 1., 9900, Körmend, Hungary';
        var marker42 = new GMarker(new GLatLng(47.015352,16.610703));
        map.addOverlay(marker42);
        GEvent.addListener(marker42, "click", function() {
            marker42.openInfoWindowHtml(htmllabel42);
        });
                var htmllabel43 = '<b>Műszaki állomás</b><br />9700 Szombathely, Csaba u. 7. <br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas-19">Részletes adatok</a>';
        var address = 'Csaba u. 7. , 9700, Szombathely, Hungary';
        var marker43 = new GMarker(new GLatLng(47.2245,16.64182));
        map.addOverlay(marker43);
        GEvent.addListener(marker43, "click", function() {
            marker43.openInfoWindowHtml(htmllabel43);
        });
                var htmllabel44 = '<b>Szervizpont, Műszaki állomás</b><br />9730 Kőszeg, Szombathelyi út 3. <br /><a href="/ugyfelpontok/muszaki-allomasok/szervizpont-muszaki-allomas-0">Részletes adatok</a>';
        var address = 'Szombathelyi út 3. , 9730, Kőszeg, Hungary';
        var marker44 = new GMarker(new GLatLng(47.379282,16.558039));
        map.addOverlay(marker44);
        GEvent.addListener(marker44, "click", function() {
            marker44.openInfoWindowHtml(htmllabel44);
        });
                var htmllabel45 = '<b>Műszaki állomás</b><br />9500 Celldömölk,  Zalka M. úti garázssor <br /><a href="/ugyfelpontok/muszaki-allomasok/muszaki-allomas-18">Részletes adatok</a>';
        var address = ' Zalka M. úti garázssor , 9500, Celldömölk, Hungary';
        var marker45 = new GMarker(new GLatLng(47.254563,17.160087));
        map.addOverlay(marker45);
        GEvent.addListener(marker45, "click", function() {
            marker45.openInfoWindowHtml(htmllabel45);
        });
                var htmllabel46 = '<b>Szervizpont, Műszaki állomás</b><br />9400 Sopron, Lackner Kristóf u. 60. <br /><a href="/ugyfelpontok/muszaki-allomasok/szervizpont-muszaki-allomas-2">Részletes adatok</a>';
        var address = 'Lackner Kristóf u. 60. , 9400, Sopron, Hungary';
        var marker46 = new GMarker(new GLatLng(47.693788,16.581688));
        map.addOverlay(marker46);
        GEvent.addListener(marker46, "click", function() {
            marker46.openInfoWindowHtml(htmllabel46);
        });
}

function initialize() {
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var myOptions = {
      zoom: 8,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("map_canvas"),
        myOptions);
  }

initialize();
