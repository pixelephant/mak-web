	var locations = [
		['<b>Travel iroda 1.</b><br />1132 Budapest, Visegrádi u. 17.<br /><a href="szervizpont/1">Részletes adatok</a>', 47.514245,19.055338],
		['<b>Travel iroda 2.</b><br />1024 Budapest, Rómer Flóris u. 8.<br /><a href="szervizpont/2">Részletes adatok</a>', 47.513625,19.034375],
		['<b>Travel iroda 3.</b><br />1119 Budapest, Etele út 69. /a<br /><a href="szervizpont/3">Részletes adatok</a>', 47.464738,19.025553],
		['<b>Travel iroda 4.</b><br />6722 Szeged, Bartók Béla tér 6.<br /><a href="szervizpont/4">Részletes adatok</a>', 47.556291,19.085008],
		['<b>Travel iroda 5.</b><br />5600 Békéscsaba, Szarvasi út 82.<br /><a href="szervizpont/5">Részletes adatok</a>', 46.684448,21.0554],
		['<b>Travel iroda 6.</b><br />4400 Nyíregyháza, Dózsa Gy. u. 9. fsz. 2.<br /><a href="szervizpont/6">Részletes adatok</a>',47.690511,17.655222],
		['<b>Travel iroda 7.</b><br />4024 Debrecen, Simonffy u. 4. Halköz üzletház 29/1<br /><a href="szervizpont/7">Részletes adatok</a>',47.529667,21.625178],
		['<b>Travel iroda 8.</b><br />3530 Miskolc, Győri kapu 32.<br /><a href="szervizpont/8">Részletes adatok</a>',48.104068,20.756484],
		['<b>Travel iroda 9.</b><br />3300 Eger, Jókai u. 5.<br /><a href="szervizpont/9">Részletes adatok</a>',47.901043,20.377041],
		['<b>Travel iroda 10.</b><br />7624 Pécs, Ferencesek u. 22.<br /><a href="szervizpont/10">Részletes adatok</a>',46.075506,18.225138],
		['<b>Travel iroda 11.</b><br />8000 Székesfehérvár, József A. u. 2/a.<br /><a href="szervizpont/11">Részletes adatok</a>',47.19300,18.414900],
		['<b>Travel iroda 12.</b><br />8900 Zalaegerszeg, Alsóerdei u. 3/a<br /><a href="szervizpont/2">Részletes adatok</a>',46.828459,16.827813],
		['<b>Travel iroda 13.</b><br />9027 Győr, Tompa u. 2.<br /><a href="szervizpont/18">Részletes adatok</a>',47.69054,17.655845],
		['<b>Travel iroda 14.</b><br />1043 Budapest, Berda József u. 15.<br /><a href="szervizpont/0">Részletes adatok</a>',47.556291,19.085008],
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
