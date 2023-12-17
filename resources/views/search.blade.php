<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('assets/logo.svg') }}">
    <title>FindPath</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.map.key') }}&libraries=places&callback=initMap">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/css/app.css')
    <style>
        /* Customize the splash screen styles here */
        .splash-screen {
            background-color: #f1efef92;
            font-size: 24px;
        }

        .animate-bounce {
            animation: bounce 1s infinite;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-20px);
            }

            60% {
                transform: translateY(-10px);
            }
        }

        @keyframes dot-animation {
            0% {
                opacity: 0;
            }

            25% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            75% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }

        .dot {
            display: inline-block;
            animation: dot-animation 1.5s infinite;
        }

        @keyframes loading {
            from {
                width: 0%;
            }

            to {
                width: 100%;
            }
        }

        .loading-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 20px;
        }

        .loading-text {
            margin-bottom: 10px;
            font-size: 16px;
            font-weight: bold;
        }

        .loading-bar {
            width: 100%;
            height: 10px;
            background-color: #ccc;
            border-radius: 5px;
            overflow: hidden;
        }

        .loading-bar-inner {
            width: 0%;
            height: 100%;
            background-color: rgb(59 130 246);
            animation: loading 1s linear infinite;
        }

        @keyframes dot-animation {
            0% {
                opacity: 0;
            }

            25% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            75% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }

        .dot {
            display: inline-block;
            animation: dot-animation 1.5s infinite;
        }

        .navbar {
            background-color: #3490dc;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }

        #map {
            height: 100%;
            width: 100%;
            position: absolute !important;
        }

        /* Customize any other styles as needed */
    </style>
</head>

<body class="antialiased">
    <div class="navbar">
        <a onclick="goBack()" class="text-lg"> <i class="fa fa-arrow-left"></i> <span class="routename"></span></a>
    </div>
    <div class="items-top justify-center min-h-screen splash-screen">
        <!-- Your splash screen content goes here -->
        <div class="text-center searchview pt-4">
            <div class="mb-8">
                {{-- <span>From</span> --}}
                <input id="from" type="text" placeholder="Where are you? ie Toll gate"
                    class="w-72 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-500"
                    style="font-size: 1.1rem; padding-left: 30px; margin-right:-30px" required>
              
            </div>
            <div class="mb-8">
                {{-- <span>To</span> --}}
                <input id="to" type="text" placeholder="Where are you going? ie Apata"
                    class="w-72 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-500"
                    style="font-size: 1.1rem;  padding-left: 30px; margin-right:-30px" required>
            
            </div>

            <button id="ok-button" class="bg-blue-500 text-white px-4 py-2 rounded-md"
                style="font-size: 1.1rem; width:250px">Route Me</button>

            <div class="loading-container" style="margin-top:150px; display:none">
                <span class="loading-text">Loading<span class="dot">.</span><span class="dot">.</span><span
                        class="dot">.</span></span>
                <div class="loading-bar">
                    <div class="loading-bar-inner"></div>
                </div>
            </div>
            <div class="noroute" style="margin-top:150px; display:none">
                <span class="loading-text">Location route not found</span>
            </div>

        </div>

        <div class="text-center mapview">
            <div id="map"></div>
        </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        let map;
        let marker;
        let markers = [];
        $(".mapview").hide();
        let isDuplicate = false;

        function initMap() {
            // Initialize the map
            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: 0,
                    lng: 0
                },
                zoom: 14,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                disableDefaultUI: true,
            });

            // Try HTML5 geolocation to get the user's current location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        var lat = position.coords.latitude;
                        var lng = position.coords.longitude;
                        const userLocation = {
                            lat: lat,
                            lng: lng
                        };


                        var newMarker = {
                            "name": 'Current Location',
                            "latitude": lat.toString(),
                            "longitude": lng.toString(),
                            "description": 'Your current location',
                        }
                        // Insert the new marker at the beginning of the markers array
                        if (markers.length > 0) {
                            isDuplicate = markers.some(marker => marker.latitude === lat.toString() && marker
                                .longitude === lng
                                .toString());
                        }
                        if (!isDuplicate) {
                            markers.unshift(newMarker);
                        }

                        // Set the map center to the user's location
                        map.setCenter(userLocation);

                        // Add a marker for the user's location
                        marker = new google.maps.Marker({
                            position: userLocation,
                            map: map,
                            title: 'Your Location'
                        });
                    },
                    () => {
                        console.error('Error: The Geolocation service failed.');
                    }
                );

            } else {
                console.error('Error: Your browser doesn\'t support geolocation.');
            }

            // Add click event listener to the button
            document.getElementById('ok-button').addEventListener('click', addMarker);

            updateLocation();

            // Set up a setInterval to call the geolocation function every 10 seconds
            setInterval(updateLocation, 10000);
        }

        function updateLocation() {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    console.log("Current location: " + position.coords.latitude + ", " + position.coords
                        .longitude);
                    if (markers.length > 1) {
                        var lastmker = markers[markers.length - 1];
                        if (lat == lastmker.latitude && lng == lastmker.longitude) {
                            var myLatlng = new google.maps.LatLng(lat, lng);
                            var infoWindow = new google.maps.InfoWindow();
                            var marker = new google.maps.Marker({
                                position: myLatlng,
                                map: map
                            });

                            infoWindow.setContent("You'r here at your destination");
                            infoWindow.open(map, marker);

                            Swal.fire({
                                title: 'You have arrived at your destination',
                                text: "Do you want to end your journey?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3490dc',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, end journey!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire(
                                        'Journey ended!',
                                        'You have successfully ended your journey.',
                                        'success'
                                    )
                                    $('.searchview').show();
                                    $('.mapview').hide();
                                    $('.routename').html("");
                                    $('.noroute').hide();
                                }
                            })

                        }
                    }
                },
                () => {
                    console.error('Error: The Geolocation service failed.');
                }
            );

        }

        function addMarker() {
            // Check if a marker already exists, and remove it
            $('.loading-container').show(); /* Show the loading bar and text using jQuery */
            var from = $('#from').val();
            var to = $('#to').val();

            $.ajax({
                url: `api/landmarks/${from}/${to}`,
                type: 'GET',
                contentType: 'application/json',
                success: function(response) {
                    console.log(response);
                    $('.loading-container').hide();
                    if (response.status === 400) {
                        $('.noroute').show();
                        $('.mapview').hide();
                        return;
                    }
                    $('.searchview').hide();
                    $('.mapview').show();
                    $('.routename').html("Route from " + from + " to " + to);
                    let = data = response.data;
                    data.forEach((location) => {
                        markers.push(location);
                    });


                    var infoWindow = new google.maps.InfoWindow();
                    var lat_lng = new Array();
                    var latlngbounds = new google.maps.LatLngBounds();

                    for (i = (markers.length) - 1; i >= 0; i--) {
                        var data = markers[i]
                        var myLatlng = new google.maps.LatLng(data.latitude, data.longitude);
                        lat_lng.push(myLatlng);
                        var marker = new google.maps.Marker({
                            position: myLatlng,
                            map: map,
                            title: data.name
                        });
                        infoWindow.setContent("You'r here at" + "<br>" + data.name);
                        infoWindow.open(map, marker);
                        // console.log(i)

                        latlngbounds.extend(marker.position);
                        (function(marker, data) {
                            google.maps.event.addListener(marker, "click", function(e) {
                                infoWindow.setContent(data.tFare + "<br>" + data.description);
                                infoWindow.open(map, marker);
                            });
                        })(marker, data);
                    }
                    map.setCenter(latlngbounds.getCenter());
                    map.fitBounds(latlngbounds);

                    //***********ROUTING****************//
                    //Initialize the Direction Service
                    var service = new google.maps.DirectionsService();
                    for (var i = 0; i < lat_lng.length; i++) {
                        if ((i + 1) < lat_lng.length) {
                            var src = lat_lng[i];
                            var des = lat_lng[i + 1];
                            // path.push(src);

                            service.route({
                                origin: src,
                                destination: des,
                                travelMode: google.maps.DirectionsTravelMode.WALKING
                            }, function(result, status) {
                                if (status == google.maps.DirectionsStatus.OK) {

                                    //Initialize the Path Array
                                    var path = new google.maps.MVCArray();
                                    //Set the Path Stroke Color
                                    var poly = new google.maps.Polyline({
                                        map: map,
                                        strokeColor: '#4986E7'
                                    });
                                    poly.setPath(path);
                                    for (var i = 0, len = result.routes[0].overview_path.length; i <
                                        len; i++) {
                                        path.push(result.routes[0].overview_path[i]);
                                    }
                                }
                            });
                        }
                    }


                },
                error: function(error) {
                    console.error('There was a problem with the AJAX request:', error);
                    $('.noroute').hide();
                }
            });
        }

        function goBack() {
            $('.searchview').show();
            $('.mapview').hide();
            $('.routename').html("");
            $('.noroute').hide();
        }
    </script>

</body>

</html>
