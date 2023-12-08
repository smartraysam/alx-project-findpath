<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>FindPath</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite('resources/css/app.css')
    <style>
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
        <a onclick="goBack()" class="text-lg"> <i class="fa fa-arrow-left"></i></a>
    </div>
    <div class="items-top justify-center min-h-screen">
        <div class="text-center">
            <div id="map"></div>
        </div>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>


    <script>
        let map;
        let markersArray = [];
        let polyline = null;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: 7.376736,
                    lng: 3.939786
                },
                zoom: 8
            });
            // map onclick listener 
            map.addListener('click', function(e) {
                //console.log(e);
                addMarker(e.latLng);
                drawPolyline();
            });
        }

        // define function to add marker at given lat & lng
        function addMarker(latLng) {
            let marker = new google.maps.Marker({
                map: map,
                position: latLng,
                draggable: true
            });

            map.setCenter(marker);
            map.setZoom(12);

            // add listener to redraw the polyline when markers position change
            marker.addListener('position_changed', function() {
                drawPolyline();
            });

            //store the marker object drawn in global array
            markersArray.push(marker);
        }

        // define function to draw polyline that connect markers' position
        function drawPolyline() {
            let markersPositionArray = [];
            // obtain latlng of all markers on map
            markersArray.forEach(function(e) {
                markersPositionArray.push(e.getPosition());
            });

            // check if there is already polyline drawn on map
            // remove the polyline from map before we draw new one
            if (polyline !== null) {
                polyline.setMap(null);
            }

            // draw new polyline at markers' position
            polyline = new google.maps.Polyline({
                map: map,
                path: markersPositionArray,
                strokeOpacity: 0.4
            });
        }
    </script>

    <script async defe
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHpSFafpkDUWTgk0tWXZXqTAISMOHoCEs&callback=initMap" r>
    </script>
</body>

</html>
