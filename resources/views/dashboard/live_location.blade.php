@php
    $title = 'Live Location';
    $settings = \App\Models\Settings::first();
@endphp
@section('title') {{$title}} @endsection
@extends('layout')
@section('main-content')
    <div class="row mb-3 justify-content-between">
        <div class="col-6">
            <div class="float-start">
                <div class="card radius-10 shadow border-0 border-start">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="col">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-outline-primary">Online <span class="badge bg-success" id="online">0</span> </button>
                                    <button type="button" class="btn btn-outline-primary">Offline <span class="badge bg-danger" id="offline">0</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-2 align-self-center align-items-end ">
             {{--   <div class="form-control">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i class="bi bi-search"></i></button>
                    </div>
                </div>--}}
            <a class="btn btn-outline-primary" href="{{route('liveLocation')}}"><i class="bi bi-arrow-clockwise"></i> Refresh</a>
        </div>
    </div>

    <div class="card shadow">
        <div id="map" class="gmaps p-0 shadow" style="height:80vh">
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}&callback=initMap&v=weekly"
            async defer>
    </script>

    <script>
        var directionsDisplay,
            directionsService,
            map;
        var ltlng = [];
        var infoWindows = [];
        var marker;
        function initMap() {
            var latitide = '{{$settings->center_latitude}}';
            var longitude = '{{ $settings->center_longitude }}';
            var center = new google.maps.LatLng(latitide, longitude);

         /*   var myStyles =[
                {
                    featureType: "poi",
                    elementType: "labels",
                    stylers: [
                        { visibility: "off" }
                    ]
                }
            ];*/
            var mapOptions = {
                zoom: parseInt('{{$settings->map_zoom_level}}'),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                center: center,
                scrollWheel: true,
                gestureHandling: 'greedy',
                streetViewControl: false,
               /* styles: myStyles*/
            };

            var iconBase = window.location.origin + "/img/map/";

            const icons = {
                green: {
                    icon: iconBase + "green_circle.png",
                },
                red: {
                    icon: iconBase + "red_circle.png",
                },
                info: {
                    icon: iconBase + "info-i_maps.png",
                },
            };

            var infoWindow;
            map = new google.maps.Map(document.getElementById('map'), mapOptions);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url : "{{route('liveLocationAjax')}}",
                type : 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    var active = 0,
                        offline = 0;

                    for (let i = 0; i < response.length; i++) {

                        var user = response[i];

                        var markerIcon;

                        if (user.status === 'online') {

                            markerIcon = {
                                url: iconBase + "green_circle.png",
                                // url: "http://maps.google.com/mapfiles/ms/icons/yellow-dot.png",
                                scaledSize: new google.maps.Size(32, 32),
                                labelOrigin: new google.maps.Point(20, -10)
                            };
                            active++;
                        }  else {
                            markerIcon = {
                                url: iconBase + "red_circle.png",
                                // url: "http://maps.google.com/mapfiles/ms/icons/yellow-dot.png",
                                scaledSize: new google.maps.Size(32, 32),
                                labelOrigin: new google.maps.Point(20, -10)
                            };
                            offline++;
                        }


                        marker = new google.maps.Marker({
                            position: new google.maps.LatLng(user.latitude, user.longitude),
                            icon: markerIcon,
                            map: map,
                            label: {
                                text: user.name,
                                color: '#1F1C1C',
                                fontWeight: "bold",
                                fontSize: "16px",
                                className: "card p-1"
                            },
                            draggable: false,
                        });

                        infoWindow = new google.maps.InfoWindow({
                            maxWidth: 200
                        });

                        var content = user.updatedAt;
                        google.maps.event.addListener(marker, 'click', (function (marker, content, infoWindow) {
                            return function () {
                                infoWindow.setContent(`Last Update: ${content}`);
                                infoWindow.open(map, marker);
                            };
                        })(marker, content, infoWindow));

                        ltlng.push(new google.maps.LatLng(user.latitude, user.longitude));
                    }

                    $('#online').text(active);
                    $('#offline').text(offline);
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }


    </script>
@endsection
