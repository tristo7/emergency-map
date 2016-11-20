function initMap() {
	var map = new google.maps.Map(document.getElementById('map'), {
		center: {lat: 33.828640, lng: -85.763048},
		zoom: 12
	});
	
	$.getJSON("IO.php", function(result){
		$.each(result, function(i, field){
			var paths = [];
			var tempPoly = new google.maps.Polygon({
				paths:JSON.parse(field.latLngArray),
				fillColor: "#" + field.Color,
				fillOpacity: 0.35,
				strokeWeight: 1,
				strokeColor: '#ff0000'
			});
			
			
			tempPoly.setMap(map);
			addInfoWindow(tempPoly,field.expiration,field.description,field.type);
		});
	});
	
	function addInfoWindow(polygon, expir, desc, typ){
			var options = {
				weekday: "long", year: "numeric", month: "short",
				day: "numeric", hour: "2-digit", minute: "2-digit"
			};
			var contentString = 
				'<div id="content">'+
					'<h2>Expiration</h2>'+
						'<p>'+new Date(expir).toLocaleTimeString("en-us", options)+
					'<h2>Description</h2>'+
						'<p>'+desc+''+
					'<h2>Type</h2>'+
						'<p>'+typ+''+
				'</div>';
				
			var info = new google.maps.InfoWindow({
				content: contentString
			});
			
			//generate infowindow when user clicks on the polygon.
			google.maps.event.addListener(polygon, 'click', function(event){
				info.setPosition(event.latLng);
				info.open(map);
			});
	}
}