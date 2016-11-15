var currentPolygon;

function initMap() {
		var map = new google.maps.Map(document.getElementById('map'), {
		  center: {lat: 33.828640, lng: -85.763048},
		  zoom: 12
		});
		
		//load current polygons
		var results = $.getJSON("IO.php", function(result){
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
		
		var drawingManager = new google.maps.drawing.DrawingManager({
			polygonOptions: {
				fillColor: '#ff9980',
				fillOpacity: 0.35,
				strokeWeight: 1,
				strokeColor: '#ff0000'
			},
			drawingMode: google.maps.drawing.OverlayType.NULL,
			drawingControl: true,
			drawingControlOptions: {
				position: google.maps.ControlPosition.TOP_CENTER,
				drawingModes: ['polygon']
			}
			
		});
		drawingManager.setMap(map);
			
		google.maps.event.addListener(drawingManager, 'polygoncomplete', function(polygon) {
			//show modal
			currentPolygon = polygon;
			var modal = document.getElementById('myModal');
			var span = document.getElementsByClassName("close")[0];
			
			modal.style.display = "block";
			span.onclick = function() {
				modal.style.display = "none";
			}
			
			window.onclick = function(event) {
				if (event.target == modal) {
					modal.close();
				}
			}
		});
}

function addPoly(){
		var verticles = currentPolygon.getPath();
		var latLngArray = currentPolygon.getPath().getArray();
		
		//Get data from Modal form.
		var expiration = document.getElementById("expiration").value;
		var description = document.getElementById("description").value;
		var typ = document.getElementById("type").value;
		
		console.log(expiration);
		console.log(description);
		console.log(typ);
		
		//post data for IO.php.
		$.ajax({
			url: 'IO.php',
			type: 'POST',
			success: function (data) {
				console.log("Data sent:" + data);
			},
			fail: function () {
				console.log("Data NOT sent:");
			},
			data: {
				latlng: JSON.stringify(latLngArray),
				expires: expiration,
				desc: description,
				type: typ
			}
		});
		
		//Clear out the form.
		document.getElementById('myModal').style.display = "none";
		document.getElementById("polygon_info").reset();
		initMap(); //reinitialize map to load the created polygon from database.
	}