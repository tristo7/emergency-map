<?php
session_name("login");
session_start();
if(empty('username')){
	debug_to_console("session not set!");
	header("location:EmergencyAreaAdmin.html");
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>EM Map</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="EmergencyArea.css">
	<script src="jquery-3.1.1.min.js"></script>
  </head>
  <body>
		<h1>Emergency Management Map</h1>
		<div id="map"></div>
		<!-- The Modal -->
		<div id="myModal" class="modal">
		    <!-- Modal content -->
		    <div class="modal-content">
				<div class="modal-header">
					<span class="close">×</span>
					<h2>Polygon Information</h2>
				</div>
				<div class="modal-body">
					<form name="polygon_info" method="get" accept-charset="utf-8" id="polygon_info">
			  		<ul>
					    <li><label for="expiration">Expiration</label>
					    <input type="datetime-local" name="expiration" placeholder="" id="expiration" required></li>
					    <li><label for="description">Description</label>
					    <input type="text" name="description" placeholder="Additional Information" id="description"required></li>
						<li><label for="type">Type</label>
						    <select name="type" id="type">
								<option value="tornado">Tornado</option>
								<option value="fire">Fire</option>
								<option value="road_hazard">Road Hazard</option>
								<option value="snow_storm">Snow Storm</option>
								<option value="chemical_spill">Chemical Spill</option>
								<option value="flooding">Flooding</option>
								<option value="hurricane">Hurricane</option>
								<option value="other">Other</option>
							</select></li>
					    <li><input type="button" value="Finish" onclick="addPoly()"></li>
			  		</ul>
			</form>
				</div>
				<div class="modal-footer">
					<h3>Polygon Information</h3>
				</div>
			</div>
		</div>
	<script type="text/javascript" src="map.js"></script>
	
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgrYOrdmh3-jkJHk9ibXBrfQIeFAUPhak&libraries=drawing&callback=initMap"></script>
  </body>
</html>