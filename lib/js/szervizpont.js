/* Térkép init */
function initialize() {
  	var content = $("#szervizpont-data").html();
  	var lat = $("body").data("lat");
  	var lng = $("body").data("lng");

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10, 
      center: new google.maps.LatLng(lat,lng),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
	console.log(map);
    var infowindow = new google.maps.InfoWindow({
		content : content
	});

    var marker = new google.maps.Marker({
        	position: new google.maps.LatLng(lat,lng),
        	map: map
    });

	google.maps.event.addListener(marker, 'click', function(){
	  infowindow.setContent(content);
	  infowindow.open(map, marker);
	});
	
	infowindow.open(map,marker);
}	


initialize();