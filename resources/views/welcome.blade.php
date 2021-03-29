<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Places Searchbox</title>
    <style type="text/css">
        html, body {  height: 100%; margin: 0; padding: 0; }
	#map { height: 100%; }
	.controls { margin-top: 10px; border: 1px solid transparent; border-radius: 2px 0 0 2px;
		box-sizing: border-box; -moz-box-sizing: border-box; height: 32px; outline: none;
		box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
	}
	#source { background-color: #EBECFC; font-family: Roboto; font-size: 15px; font-weight: 300;
		margin-left: 12px; padding: 0 11px 0 13px;  text-overflow: ellipsis;  width: 300px; border: 3px solid #462066;
	}
	#destination{ background-color: #EBECFC; font-family: Roboto; font-size: 15px; font-weight: 300;
		margin-left: 20px; padding: 0 11px 0 13px; text-overflow: ellipsis; width: 300px; border: 3px solid #462066;
	}
	#directionclick{ background-color: #462066; font-family: Roboto; font-size: 15px; color: #fff;
		font-weight: 300; margin-left: 10px; margin-top: 10px; padding: 4px; text-overflow: ellipsis; width: 100px;
	}
	#stepInfo{ background-color: #fff; font-family: Roboto; font-size: 15px;
		font-weight: 300; margin-left: 10px; margin-top: 10px;
		text-overflow: ellipsis; width: 300px; position: absolute; top: 7px;
	}
	.routesegment {
		background: #462066 none repeat scroll 0 0;  border-radius: 5px 5px 0 0; color: #fff;
		display: inline-block;  font-size: 15px; font-weight: bold; height: 23px;
		padding: 6px; width: 290px;
	}
	#source:focus { border-color: #462066; }
	.routeinfo { height: 400px; overflow: auto; padding: 5px; font-size: 13px; }
    </style>
  </head>
  <body>
    <input id="source" class="controls" type="text" placeholder="Search location">
    <input id="destination" class="controls" type="text" placeholder="Enter Destination">
    <div id="icon"><input type="button" name="search" value="search" id="directionclick"/></div>
    <div id="stepInfo" style="display: none;"></div>
    <div id="map"></div>
    <script>
    function initiatlizemap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 20.5937, lng: 78.9629},
          zoom: 7,
          mapTypeId: 'roadmap'
        });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('source');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        var inputDes = document.getElementById('destination');
        var searchDesBox = new google.maps.places.SearchBox(inputDes);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(inputDes);

        var searchIcon = document.getElementById('icon');
        var searchIconBox = new google.maps.places.SearchBox(searchIcon);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(searchIcon);

        var stepInfo = document.getElementById('stepInfo');
        var searchIconBox = new google.maps.places.SearchBox(stepInfo);
        map.controls[google.maps.ControlPosition.LEFT_CENTER].push(stepInfo);

        var places = searchBox.getPlaces();
        var placesDes = searchDesBox.getPlaces();
        var markers = [];

        var pointA = new google.maps.LatLng(28.5584, 77.2029),
        pointB = new google.maps.LatLng(28.6546, 77.2309),
        myOptions = {
          zoom: 7,
          center: pointA
        },
        // Instantiate a directions service.
        directionsService = new google.maps.DirectionsService,
        directionsDisplay = new google.maps.DirectionsRenderer({
          map: map
        });
        var control = document.getElementById('directionclick');
        google.maps.event.addDomListener(control, 'click', function() {
            getMarker(directionsService, directionsDisplay, map);
        });
        google.maps.event.addDomListener(control, 'keyup', function(e) {
            if (e.keyCode == 13) {
             getMarker(directionsService, directionsDisplay, map);
            }
        });
    }
	function getMarker(directionsService, directionsDisplay, map){
		calculateAndDisplayRoute(directionsService, directionsDisplay, map);
	}
	function calculateAndDisplayRoute(directionsService, directionsDisplay, map) {
		var startPoint = document.getElementById('source').value;
		var endPoint = document.getElementById('destination').value;
		directionsService.route({
		  origin: startPoint,
		  destination: endPoint,
		  travelMode: google.maps.TravelMode.DRIVING
		}, function(response, status) {
		  if (status == google.maps.DirectionsStatus.OK) {
			directionsDisplay.setDirections(response);
			showSteps(response, map);
		  } else {
			window.alert('Directions request failed due to ' + status);
		  }
		});
	}
	function showSteps(directionResult, map) {
		var markerArray = [];
		var myRoute = directionResult.routes[0].legs[0];
		document.getElementById("stepInfo").style.display = "block";
		var text = '<div class="routesegment" ><div style="width: 80%; float:left;">Route Segment</div>';
		text += '<div class="closeroute"><a onclick="closeroute()" style="color:#8dd4ff;">X</a></div></div>';
		text += '<div class="routeinfo"><div class="routedirections"><b>Duration:</b> '+myRoute.duration.text + ','
		text += '    <b>Distance:</b> ' + myRoute.distance.text+'<br/>';
		for (var i = 0; i < myRoute.steps.length; i++) {
		  var marker = markerArray[i] = markerArray[i] || new google.maps.Marker;
		  marker.setMap(map);
		  marker.setPosition(myRoute.steps[i].start_location);
		  text += myRoute.steps[i].instructions+'<br/>';
		}
		text += '</div></div>';
		document.getElementById('stepInfo').innerHTML = text;
	}
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initiatlizemap"
         async defer>
  </script>
  </body>
</html>
