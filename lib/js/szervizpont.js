function initialize() {
	
	/*php-nak kéne ideadni vagy magában az oldalba belerakni a body-nak monnyuk data-lat stb-vel*/  	
  	var content = $("#content h1").html();
  	var lat = $("body").data("lat");
  	var lng = $("body").data("lng");
  	
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10, 
      center: new google.maps.LatLng(lat,lng),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker = new google.maps.Marker({
        	position: new google.maps.LatLng(lat,lng),
        	map: map
        	});

	google.maps.event.addListener(marker, 'click', function(){
	  infowindow.setContent(content);
	  infowindow.open(map, marker);
	});
}	


initialize();