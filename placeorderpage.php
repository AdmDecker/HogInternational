<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="description" content="rides-r-us bus system">
    <meta name="author" content="Justin Hoogestraat">
    <script src="map_js.js"></script>
    <script src="common.js"></script>


    <script type="text/javascript">

    	var FLAT_RATE = 4;
    	var PRICE_PER_MILE = .10;

    	var markers = [];
    	var map;
    	var marker;
    	var fromMarker;
    	var whereToAutocomplete;
    	var whereFromAutocomplete;

    	var directionsService;
    	var directionsDisplay;
    	var plottabble = false;
    	var date = new Date();
    	var travelTime = 0;
    	var distTravelled = 0;
    	var price = 0;



    	// resets bounds to markers
    	function resetBounds() {

		    var bounds = new google.maps.LatLngBounds();

		    for (var i=0; i<markers.length; i++) {
		        if(markers[i].getVisible()) {


		            bounds.extend( markers[i].getPosition() );

		        }
		    }

		    // small bounds
	        if (bounds.getNorthEast().equals(bounds.getSouthWest())) {
	        	// maek points first to prevent warping
	        	let p1 = new google.maps.LatLng(bounds.getNorthEast().lat() + 0.01, bounds.getNorthEast().lng() + 0.01);
	        	let p2 = new google.maps.LatLng(bounds.getNorthEast().lat() - 0.01, bounds.getNorthEast().lng() - 0.01);
		       bounds.extend(p1);
		       bounds.extend(p2);
		    }

		    // set directions if possible

		    if (marker.getVisible() && fromMarker.getVisible())
		    {
		    	var request = {
		    		origin: fromMarker.getPosition(),
		    		destination: marker.getPosition(),
		    		travelMode: 'DRIVING',
		    		unitSystem: google.maps.UnitSystem.IMPERIAL
		    	};

		    	directionsService.route(request, function(result, status) {
		    		if (status == 'OK')
		    		{
		    			plottabble = true;
		    			directionsDisplay.setMap(map);
		    			directionsDisplay.setOptions( { suppressMarkers: true } );
		    			directionsDisplay.setDirections(result);

		    		}
		    		else
		    		{
		    			document.getElementById("arrivalInfo").innerHTML = "Not plottable";
		    			document.getElementById("distanceInfo").innerHTML = "";
		    			plottabble = false;
		    			directionsDisplay.setMap(null);
		    		}

		    	});
		    }
		    else
		    {
		    	directionsDisplay.setMap(null);

		    }

		    map.fitBounds(bounds);

		}

		function updateTimeEstimate()
		{
			var tmpDate = new Date(date.getTime());

			if (plottabble)
			{
			  tmpDate.setSeconds(tmpDate.getSeconds()+travelTime);
			  document.getElementById('distanceInfo').innerHTML = "Travel Distance: " + distTravelled * 0.621371 + ' mi';
			  document.getElementById('arrivalInfo').innerHTML = "ETA: " + tmpDate.toString();
			  price = FLAT_RATE + distTravelled * 0.621371 *PRICE_PER_MILE;
			  document.getElementById('amountDue').innerHTML = "Amount Due: $" + price.toFixed(2);
			}
			else
			{
				document.getElementById('distanceInfo').innerHTML = "";
				document.getElementById('amountDue').innerHTML = "";
				document.getElementById('arrivalInfo').innerHTML = "";
			}


		}

		function onDateChange()
		{
			var input = document.getElementById("whenDate").value;
		    var dateEntered = new Date(input);

		    date.setMonth(dateEntered.getMonth());
		    date.setDate(dateEntered.getDate()+1);
		    date.setFullYear(dateEntered.getFullYear());

		    console.log(date); //e.g. Fri Nov 13 2015 00:00:00 GMT+0000 (GMT Standard Time)
		    updateTimeEstimate();
		}

		function onTimeChange()
		{
			var input = document.getElementById("whenTime").value;
		    var time = input.match(/(\d+)(:(\d\d))?\s*(p?)/i);
		    if (time == null) return;
		    var hours = parseInt(time[1],10);    
		    if (hours == 12 && !time[4]) {
		          hours = 0;
		    }
		    else {
		        hours += (hours < 12 && time[4])? 12 : 0;
		    }   
		    date.setHours(hours);
		    date.setMinutes(parseInt(time[3],10) || 0);
		    date.setSeconds(0, 0); 
		    console.log(input); //e.g. 2015-11-13
		    console.log(date); //e.g. Fri Nov 13 2015 00:00:00 GMT+0000 (GMT Standard Time)
		    updateTimeEstimate();
		}

    	function initMap()
    	{
			var options = {
			  componentRestrictions: {country: 'us'}
			};


			whereToAutocomplete = new google.maps.places.Autocomplete(document.getElementById('whereto'), options);
			whereFromAutocomplete = new google.maps.places.Autocomplete(document.getElementById('wherefrom'), options);


			directionsService = new google.maps.DirectionsService();
  			directionsDisplay = new google.maps.DirectionsRenderer();

  					    			

			  directionsDisplay.addListener('directions_changed', function() {
			  	  var result = directionsDisplay.getDirections();
		          var total = 0;
				  var myroute = result.routes[0];
				  travelTime = 0;

				  for (var i = 0; i < myroute.legs.length; i++) {
				  	travelTime += myroute.legs[i].duration.value;
				    total += myroute.legs[i].distance.value;
				  }
				  total = total / 1000;

				  distTravelled = total;


				 
				  updateTimeEstimate();


			  });



    		var uluru = {lat: 43.855, lng: -96.744};
    		map = new google.maps.Map(document.getElementById('map'), {
	          zoom: 8,
	          center: uluru
	        });
	        marker = new google.maps.Marker({
	        	visible: false,
	          map: map,
	          animation: google.maps.Animation.DROP,
	          icon: 'http://maps.google.com/mapfiles/kml/paddle/B.png'

	        });

	        directionsDisplay.setMap(map);



			fromMarker = new google.maps.Marker({
				visible: false,
	            position: new google.maps.LatLng(0,0), 
	            animation: google.maps.Animation.DROP,
	            map: map,
	            icon: 'http://maps.google.com/mapfiles/kml/paddle/A.png'
	        });

	        markers = [marker, fromMarker];



	        // setup autocomplet elistener
		    whereToAutocomplete.addListener('place_changed', function() {
	          marker.setVisible(false);
	          var place = whereToAutocomplete.getPlace();
	          if (!place.geometry) {
	            // User entered the name of a Place that was not suggested and
	            // pressed the Enter key, or the Place Details request failed.
	            window.alert("No details available for input: '" + place.name + "'");
	            return;
	          }

	          // If the place has a geometry, then present it on a map.
	          if (place.geometry.viewport) {
	            map.fitBounds(place.geometry.viewport);
	          } else {
	            map.setCenter(place.geometry.location);
	            map.setZoom(17);  // Why 17? Because it looks good.
	          }
	          marker.setPosition(place.geometry.location);
	          marker.setVisible(true);
	          resetBounds();

	          var address = '';
	          if (place.address_components) {
	            address = [
	              (place.address_components[0] && place.address_components[0].short_name || ''),
	              (place.address_components[1] && place.address_components[1].short_name || ''),
	              (place.address_components[2] && place.address_components[2].short_name || '')
	            ].join(' ');
	          }

	        });

	        // setup autocomplet elistener
		    whereFromAutocomplete.addListener('place_changed', function() {
	          fromMarker.setVisible(false);
	          var place = whereFromAutocomplete.getPlace();
	          if (!place.geometry) {
	            // User entered the name of a Place that was not suggested and
	            // pressed the Enter key, or the Place Details request failed.
	            window.alert("No details available for input: '" + place.name + "'");
	            return;
	          }

	          // If the place has a geometry, then present it on a map.
	          if (place.geometry.viewport) {
	            map.fitBounds(place.geometry.viewport);
	          } else {
	            map.setCenter(place.geometry.location);
	            map.setZoom(17);  // Why 17? Because it looks good.
	          }
	          fromMarker.setPosition(place.geometry.location);
	          fromMarker.setVisible(true);
	          resetBounds();


	          var address = '';
	          if (place.address_components) {
	            address = [
	              (place.address_components[0] && place.address_components[0].short_name || ''),
	              (place.address_components[1] && place.address_components[1].short_name || ''),
	              (place.address_components[2] && place.address_components[2].short_name || '')
	            ].join(' ');
	          }

	        });
    	}
    	document.addEventListener("DOMContentLoaded", function(){
    		document.getElementById("whenDate").addEventListener("change", function() {
    			onDateChange();

			});

			// initalise when date
			let curDate = new Date();

			curDate.setHours(curDate.getHours() + 1);

			document.getElementById("whenDate").valueAsDate = curDate;

			onDateChange();
			onTimeChange();



			document.getElementById("whenTime").addEventListener("change", function() {
				onTimeChange();
			});
		});


        
        function stateChange()
        {
            let response = xmlhttp.responseText;
            
            if (!(xmlhttp.readyState==4) && !(xmlhttp.status==200))
                return;
                
            document.getElementById("error").nodeValue = xmlhttp.responseText;
            if(response.includes("success"))
            {
                window.location = "placeorderSuccess.php";
            }
            else
            {
                document.getElementById("error").innerHTML = response;
            }
        }
        
        function submitForm(reason)
        {
			let action = "/placeorder.php";

            // Sanitize
            var whereToPlace = whereToAutocomplete.getPlace();

            if (!whereToPlace || !whereToPlace.geometry)
            {
            	window.alert("Please validate 'where to' field by using a reccomendation.");
            	return;
            }

            var whereFromPlace = whereFromAutocomplete.getPlace();

            if (!whereFromPlace || !whereFromPlace.geometry)
            {
            	window.alert("Please validate 'where from' field by using a reccomendation.");
            	return;
            }

            if (!plottabble)
            {
            	window.alert("Path is unplottable.");
            	return;
            }

            var numOfPeople = document.getElementById("noofpeople").value;

            if (!numOfPeople || numOfPeople < 1)
            {
            	window.alert("Specify number of people");
            	return;
            }

			//verify credit card is checked
			let paymentType = document.querySelector('input[name="card"]:checked').value;
			if (paymentType == null)
			{
				window.alert("Please select a credit card");
				return;
			}

			if (!date || date < new Date())
			{
				window.alert(" specify a time in the future.");
				return;
			}

            xmlhttp = new XMLHttpRequest();
            
            xmlhttp.open("POST", action, true);
            xmlhttp.setRequestHeader("Content-type", "application/json;charset=UTF-8");
            
            xmlhttp.onreadystatechange = stateChange;
            
			var myObj =
			{
				whereto: whereToPlace.name,
				wherefrom: whereFromPlace.name,
				when: date.toString(),
				travelTime: travelTime,
				noofpeople: numOfPeople,
				price: price,
				distance: distTravelled,
				handicap: document.getElementById("handicap").checked,
				paymentType: paymentType
			};
            var myJSON = JSON.stringify(myObj);


            HogLog.d(myJSON);

            // callback for request
            xmlhttp.onreadystatechange = function (event) {
            	if (this.readyState == 4)
            	{
            		if (this.status == 200)
            		{
            			// okay
            		    window.location="/cmain.php";
            		}
            		else
            		{
            			window.alert("Order request failed. Code: " + this.statusText);
            		}
            	}
            };

			xmlhttp.send(myObj);
        }
        
        
        function oncreateorder()
        {
            submitForm();
            document.getElementById("error").innerHTML = "Creating Order ......";
        }
    </script>
    <link rel="stylesheet" href="w3.css"> 

	<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <header class="main-header">
      <ul class="nav-list">
        <?php 
        	require 'Nav.php';

        	echo Nav::getNavHtml();
        ?>

        <li class="rides-r-us"><a href="index.php"><b>Rides R' Us™</b></a></li>
      </ul>
      <hr width="100%">
    </header>
    <section>
	     <form>
	     	<div class="w3 row">


	     		<div class="w3-half w3-container">
				    <input class="w3-input" type="text" name="whereto" id="whereto" autocomplete="off" placeholder="Where to?"	/>
				    <input class="w3-input" type="text" name="wherefrom" id="wherefrom" autocomplete="off" placeholder="Where from?" />
				    
				    <input   class="w3-input" type="date"  name="Date" id="whenDate"/>
				    <input   class="w3-input" type="time" value="12:00"  name="Time" id="whenTime"/>
					<input class="w3-input" type="number" name="noofpeople" id="noofpeople" placeholder="How many people?" />

					<p/><p/>

					<label>Handicap?: </label>
					<input style="" type="checkbox" name="handicap" id="handicap" value="1" />
					<br/><br/>

					<label id="amountDue">Amount Due: </p>

					<p>Payment Option: </p>
					<form>
						  <input type="radio" name="card" value="Visa" checked="checked"> Visa ending in 0121<br>
						  <input type="radio" name="card" value="Mastercard"> Mastercard ending in 1203<br>
					</form> 		
	     		</div>

	     		<div class="w3-rest w3-container">

	     			<div class="alert alert-info" style="width:100%; border:2px solid black; text-align:center;">
					<div id="map" style="width:100%; height:25em;"></div>
					</div>
					
					<p id="distanceInfo"></p>
					<p id="arrivalInfo"></p>

		
	     		</div>

	     	</div>


			<br /><br />
		    <div id="error"></div>
		</form>

       <hr width="100%">
       <input class="w3-button w3-blue" type="button" value="Create Order" onclick="oncreateorder()"/>
       <hr width="100%">




    </section>


    <footer>
      <center>Copyright ©2018 Brookings Area Transit Authority</center>
      <center>Usage of this site constitues acceptance of our</center>
      
       <center> <a href="terms.html">Terms of Service</a>
        and our
      <a href="privacy.html">Privacy Policy</a></center>
    </footer>
  </body>
<body>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCLPoefHbYJCIvyhqpsj13man604bMmhto&callback=initMap&libraries=places">
</script>


</html>