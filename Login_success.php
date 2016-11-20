<?php
	session_name("login");
	session_start();
	if(!isset($_SESSION['username'])){
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
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgrYOrdmh3-jkJHk9ibXBrfQIeFAUPhak&libraries=drawing&callback=initMap"></script>
		</head>
	<body>
		<h1>Emergency Management Map</h1>
		<div id="map">
			<script type="text/javascript" src="map.js"></script>
		</div>
		
		
		<!-- The Modal -->
		<div id="myModal" class="modal">
		    <!-- Modal content -->
		    <div class="modal-content">
				<div class="modal-header">
					<span class="close">×</span>
					<h2>Polygon Information</h2>
				</div>
				<div class="modal-body">
					<form name="polygon_info" method="get" accept-charset="utf-8" id="polygon_info" novalidate>
				  		<ul>
						    <li><label>Expiration</label>
						    <input type="datetime-local" name="expiration" placeholder="" id="expiration" required></li>
						    <li><label>Description</label>
						    <input type="text" name="description" placeholder="Additional Information" id="description"></li>
							<li><label for="type">Type</label>
							    <select name="type" id="type">
									<script type="text/javascript">
										//dynammically build the type list.
										var select = document.getElementById('type');
										$.getJSON("types.php", function(result){
											$.each(result, function(i, field){
												var option = document.createElement('option');
												option.text = option.value = field.TypeName;
												select.add(option);
											});
										});
									</script>
								</select></li>
						    <li><button onClick="addPoly()">Finish</button></li>
				  		</ul>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>