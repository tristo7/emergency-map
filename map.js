var currentPolygon;

		function initMap() {
				var map = new google.maps.Map(document.getElementById('map'), {
				  center: {lat: 33.828640, lng: -85.763048},
				  zoom: 12
				});
				//var infoWindow = new google.maps.InfoWindow({map: map});    was causing a small info window to popup on load.
				
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
					var contentString = 
						'<div id="content">'+
						'<div id="siteNotice">'+
						'</div>'+
						'<h2>Expiration</h2>'+
						'<p>'+expir+''+
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
					currentPolygon = polygon;
								
					// Get the modal
					var modal = document.getElementById('myModal');
					
					// Get the <span> element that closes the modal
					var span = document.getElementsByClassName("close")[0];

					// show the modal
					modal.style.display = "block";
						
					// When the user clicks on <span> (x), close the modal
					span.onclick = function() {
						modal.style.display = "none";
					}

					// When the user clicks anywhere outside of the modal, close it
					window.onclick = function(event) {
						if (event.target == modal) {
							modal.close();
						}
					}
					
					//var expiration = prompt("Please enter the expiration time (YYYY-MM-DD HH-MM-SS)", "2016-10-25 12:00:00");
					//var description = prompt("Please enter a description", "Tornado warning/Road hazard/etc");
				});
		}
		
		function addPoly(){
				var polygon = currentPolygon;
				var verticles = polygon.getPath();
				var latLngArray = polygon.getPath().getArray();
				var expiration = document.getElementById("expiration").value;
				var description = document.getElementById("description").value;
				var type = document.getElementById("type").value;
				
				
				var sendData = {
					latlng: JSON.stringify(latLngArray),
					expires: expiration,
					desc: description
				};
				
				$.ajax({
					url: 'IO.php',
					type: 'POST',
					success: function (data) {
						console.log("Data sent.");
					},
					data: {
						latlng: JSON.stringify(latLngArray),
						expires: expiration,
						desc: description,
						type: type
					}
				});
				//clear out the form.
				document.getElementById('myModal').style.display = "none";
				document.getElementById("polygon_info").reset();
				setTimeout(function(){
					initMap(); //reinitialize map to load the created polygon from database.
				}, 500); 
			}