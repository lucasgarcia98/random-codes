<!DOCTYPE html>
<html>

<head>
    <title>Custom Markers</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <!-- jsFiddle will insert css and js -->
    <style>
        /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
        #map {
            height: 100%;
        }

        /* Optional: Makes the sample page fill the window. */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

    </style>
</head>

<body>
    <div id="map"></div>

    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg&callback=initMap&v=weekly"
        async></script>
    <script>
        function initMap() {
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 2.2,
                center: {
                    lat: 31.7311865,
                    lng: -11.6463504
                },
            });

            setMarkers(map);
        }

        function setMarkers(map) {
            const image = {
                url: "https://copag.com.br/images/pin_cartamundi.svg",
                size: new google.maps.Size(50, 50),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(23, 45),
            };
            const shape = {
                coords: [1, 1, 1, 20, 18, 20, 18, 1],
                type: "poly",
            };
            $.ajax({
                // Rota que volta as informações do back.
                // $locais = DB::table('mapa')->get();
                // return response()->json(["locais" => $locais]);
                url: "{{ route('Ajax.Busca.Mapa') }}",
                method: 'GET',
                success: function(response) {
                    let locais = response.locais;
                    locais.forEach(function(local) {
                        new google.maps.Marker({
                            position: {
                                lat: parseFloat(local.latitude),
                                lng: parseFloat(local.longitude)
                            },
                            map,
                            icon: image,
                            shape: shape,
                            title: local.local,
                        });
                    })
                },
                error: function(errorResponse) {
                    toastr["error"](JSON.stringify(errorResponse));
                }
            })
        }
    </script>
</body>

</html>
