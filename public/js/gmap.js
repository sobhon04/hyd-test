function initiatlizemap() {
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: 17.385044, lng: 78.486671},
      zoom: 7,
      mapTypeId: 'roadmap'
    });

    // Create the search box and link it to the UI element.
    var input = document.getElementById('source');
    var searchBox = new google.maps.places.SearchBox(input);
    //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    var inputDes = document.getElementById('destination');
    var searchDesBox = new google.maps.places.SearchBox(inputDes);
    //map.controls[google.maps.ControlPosition.TOP_LEFT].push(inputDes);

    var searchIcon = document.getElementById('icon');
    var searchIconBox = new google.maps.places.SearchBox(searchIcon);
    //map.controls[google.maps.ControlPosition.TOP_LEFT].push(searchIcon);

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
