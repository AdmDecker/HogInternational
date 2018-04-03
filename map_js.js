var geocoder;
var map;
var addresses;
var results;
var dist;
var markersArray = [];
var bounds;
var directionsDisplay;
var directionsService;
var pl1;
var pl2;
var mr1;
var mr2;
var rs;
var rt;

function initialize() {
	geocoder = new google.maps.Geocoder();
	directionsDisplay = new google.maps.DirectionsRenderer();
	bounds = new google.maps.LatLngBounds();
	directionsService = new google.maps.DirectionsService();

	var b = new google.maps.LatLng(0, 0);
	var a = {
		zoom: 1,
		center: b,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		scrollwheel: false,
		scaleControl: true,
		overviewMapControl: true,
		overviewMapControlOptions: {
			opened: true
		}
	};
	map = new google.maps.Map(document.getElementById("map"), a);
	mr1 = new google.maps.Marker({
		map: map,
		position: b,
		draggable: true,
		animation: google.maps.Animation.DROP
	});
	mr2 = new google.maps.Marker({
		map: map,
		position: b,
		draggable: true,
		animation: google.maps.Animation.DROP
	});
	google.maps.event.addListener(mr1, 'dragend', function() {
		distancell(mr1.getPosition(), mr2.getPosition());
	});
	google.maps.event.addListener(mr2, 'dragend', function() {
		distancell(mr1.getPosition(), mr2.getPosition());
	});

	if (document.getElementById("distancefrom").value !== "") {
		fdistance();
	}
}

function fdistance() {
	address1 = document.getElementById("distancefrom").value;
	address2 = document.getElementById("distanceto").value;
	if (document.getElementById("driving").checked) {
		calculateDistances(address1, address2)
	} else {
		if (document.getElementById("air").checked) {
			distance(address1, address2)
		}
	}

	// document.getElementById('distanceinfo').scrollIntoView();
}

function distance(b, a) {
	if (!geocoder) {
		return "Error, no geocoder"
	}
	rstdd();
	addresses = null;
	results = null;
	addresses = new Array(2);
	addresses[0] = b;
	addresses[1] = a;
	results = new Array(2);
	results[0] = new Array(2);
	results[1] = new Array(2);
	results[0][0] = 0;
	results[0][1] = 0;
	results[1][0] = 0;
	results[1][1] = 0.87;
	geocoded(1)
}

function rstdd() {
	if (directionsDisplay != null) {
		directionsDisplay.setMap(null);
		directionsDisplay = null;
	}
}

function calculateDistances(c, b) {
	try {
		if (undefined === pl1) {
			distance(address1, address2);
		} else {
			pl1.setMap(null);
			pl2.setMap(null);
		}

		if (directionsDisplay == null) {
			directionsDisplay = new google.maps.DirectionsRenderer();
			directionsDisplay.setMap(map);
			directionsDisplay.setOptions({
				suppressMarkers: true
			});
		}
		var a = new google.maps.DistanceMatrixService();

		rs = c;
		rt = b;
		a.getDistanceMatrix({
			origins: [c],
			destinations: [b],
			travelMode: google.maps.TravelMode.DRIVING,
			unitSystem: google.maps.UnitSystem.METRIC,
			avoidHighways: false,
			avoidTolls: false
		}, callback);
	} catch (err) {
		return false;
	}
}

function callback(c, b) {
	if (b != google.maps.DistanceMatrixStatus.OK) {
		{
			return false;
		}
	} else {
		var h = c.originAddresses;
		var a = c.destinationAddresses;
		for (var f = 0; f < h.length; f++) {
			var e = c.rows[f].elements;
			for (var d = 0; d < e.length; d++) {
				var g = 0.621371192 * parseInt(e[d].distance.value) / 1000;
				document.getElementById("totaldistancemiles").value = g.toFixed(2) + " miles";
				document.getElementById("totaldistancekm").value = (g / 0.621371192).toFixed(2) + " km";
				document.getElementById("totaldistancenamiles").value = (g * 0.868976242).toFixed(2) + " nmi";
			}
		}
		calcRoute()
	}
}

function calcRoute() {
	var b = {
		origin: rs,
		destination: rt,
		travelMode: google.maps.DirectionsTravelMode.DRIVING
	};
	directionsService.route(b, function(e, d) {
		if (d == google.maps.DirectionsStatus.OK) {
			directionsDisplay.setDirections(e);
			var myRoute = e.routes[0].legs[0];
			mr1.setPosition(myRoute.steps[0].start_point);
			mr2.setPosition(myRoute.steps[myRoute.steps.length - 1].start_point);
		}
	})
}

function geocoded(a) {
	geocoder.geocode({
		address: addresses[a]
	}, function(d, c) {
		if (c == google.maps.GeocoderStatus.OK) {
			results[a][0] = parseFloat(d[0].geometry.location.lat());
			results[a][1] = parseFloat(d[0].geometry.location.lng());
			a--;
			if (a >= 0) {
				geocoded(a)
			} else {
				var b = new google.maps.LatLng(results[0][0], results[0][1]);
				var f = new google.maps.LatLng(results[1][0], results[1][1]);
				dist = google.maps.geometry.spherical.computeDistanceBetween(b, f) / 1000;
				var e = 0.621371192 * dist;
				document.getElementById("totaldistancemiles").value = e.toFixed(2) + " miles";
				document.getElementById("totaldistancekm").value = dist.toFixed(2) + " km";
				document.getElementById("totaldistancenamiles").value = (e * 0.868976242).toFixed(2) + " nmi";
				showMap(b, f)
			}
		}
	})
}

function distancell(b, f) {
	pl1.setMap(null);
	pl2.setMap(null);
	rstdd();
	rs = b;
	rt = f;
	if (document.getElementById("driving").checked) {
		calculateDistances(b, f);
	} else {
		if (document.getElementById("air").checked) {
			dist = google.maps.geometry.spherical.computeDistanceBetween(b, f) / 1000;
			var e = 0.621371192 * dist;
			document.getElementById("totaldistancemiles").value = e.toFixed(2) + " miles";
			document.getElementById("totaldistancekm").value = dist.toFixed(2) + " km";
			document.getElementById("totaldistancenamiles").value = (e * 0.868976242).toFixed(2) + " nmi";
			var i = [b, f];

			pl1 = new google.maps.Polyline({
				path: i,
				strokeColor: "#FF0000",
				strokeOpacity: 0.5,
				geodesic: true,
				strokeWeight: 4
			});
			pl1.setMap(map);
			pl2 = new google.maps.Polyline({
				path: i,
				strokeColor: "#000000",
				strokeOpacity: 0.5,
				strokeWeight: 4
			});
			pl2.setMap(map);
			var j;
			j = new google.maps.LatLngBounds();
			j.extend(b);
			j.extend(f);
			map.fitBounds(j);
		}
	}

}

function showMap(f, e) {
	latlng = new google.maps.LatLng((f.lat() + e.lat()) / 2, (f.lng() + e.lng()) / 2);
	faddress1 = document.getElementById("distancefrom").value;
	faddress2 = document.getElementById("distanceto").value;
	var i = [f, e];
	if (undefined !== pl1) {
		pl1.setMap(null);
	}
	if (undefined !== pl2) {
		pl2.setMap(null);
	}
	pl1 = new google.maps.Polyline({
		path: i,
		strokeColor: "#FF0000",
		strokeOpacity: 0.5,
		geodesic: true,
		strokeWeight: 4
	});
	pl1.setMap(map);
	pl2 = new google.maps.Polyline({
		path: i,
		strokeColor: "#000000",
		strokeOpacity: 0.5,
		strokeWeight: 4
	});
	pl2.setMap(map);
	mr1.setPosition(f);
	var j;
	j = new google.maps.LatLngBounds();
	j.extend(f);
	j.extend(e);
	map.fitBounds(j);
	var b = new google.maps.InfoWindow();
	b.setContent(faddress1);
	google.maps.event.addListener(mr1, "click", function() {
		b.open(map, mr1)
	});
	mr2.setPosition(e);
	var d = new google.maps.InfoWindow();
	d.setContent(faddress2);
	google.maps.event.addListener(mr2, "click", function() {
		d.open(map, mr2)
	})
}
(function() {
	/*
var gcse = document.createElement('script');
gcse.type = 'text/javascript';
gcse.async = true;
gcse.src = 'https://www.google.com/coop/cse/brand?form=cse-search-box&amp;lang=en';
var s = document.getElementsByTagName('script')[0];
s.parentNode.insertBefore(gcse, s);
*/
})();