@php
    use App\Models\Settings;
    $settings = Settings::first();
@endphp
<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title> {{ $settings->app_name }} - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('faviconnew.ico') }}">
    <meta name="theme-color" content="#ffffff">
    <script src="{{ asset('vendors/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('vendors/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link href="{{ asset('vendors/simplebar/simplebar.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="{{ asset('assets/css/theme-rtl.min.css') }}" type="text/css" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('assets/css/theme.min.css') }}" type="text/css" rel="stylesheet" id="style-default">
    <link href="{{ asset('assets/css/user-rtl.min.css') }}" type="text/css" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('assets/css/user.min.css') }}" type="text/css" rel="stylesheet" id="user-style-default">
    <link href="{{ asset('assets/css/style.css') }}" type="text/css" rel="stylesheet">
    <style>
        .chosen-container.chosen-container-single {
            width: 100% !important;
        }

        .card {
            padding: 15px;
            /* JUST TO LOOK COOL */
            border: 1px solid #eee;
            /* JUST TO LOOK COOL */
            box-shadow: rgba(0, 0, 0, 0.06) 0px 2px 4px;
            transition: all .3s ease-in-out;
        }

        .card:hover {
            box-shadow: rgba(0, 0, 0, 0.15) 0px 15px 35px;
            transform: translate3d(0px, -1px, 0px);
        }
    </style>
    @yield('styles')


    <script>
        var phoenixIsRTL = window.config.config.phoenixIsRTL;
        if (phoenixIsRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script>
    <link href="{{ asset('vendors/leaflet/leaflet.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/leaflet.markercluster/MarkerCluster.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/leaflet.markercluster/MarkerCluster.Default.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" rel="stylesheet">


    <style>
        .loader {
            width: 12px;
            aspect-ratio: 1;
            border-radius: 50%;
            background: #000;
            clip-path: inset(-220%);
            animation: l28 2s infinite linear;
        }

        @keyframes l28 {
            0% {
                box-shadow: 0 0 0 0, 40px 0, -40px 0, 0 40px, 0 -40px
            }

            10% {
                box-shadow: 0 0 0 0, 12px 0, -40px 0, 0 40px, 0 -40px
            }

            20% {
                box-shadow: 0 0 0 4px, 0px 0, -40px 0, 0 40px, 0 -40px
            }

            30% {
                box-shadow: 0 0 0 4px, 0px 0, -12px 0, 0 40px, 0 -40px
            }

            40% {
                box-shadow: 0 0 0 8px, 0px 0, 0px 0, 0 40px, 0 -40px
            }

            50% {
                box-shadow: 0 0 0 8px, 0px 0, 0px 0, 0 12px, 0 -40px
            }

            60% {
                box-shadow: 0 0 0 12px, 0px 0, 0px 0, 0 0px, 0 -40px
            }

            70% {
                box-shadow: 0 0 0 12px, 0px 0, 0px 0, 0 0px, 0 -12px
            }

            80% {
                box-shadow: 0 0 0 16px, 0px 0, 0px 0, 0 0px, 0 0px
            }

            90%,
            100% {
                box-shadow: 0 0 0 0, 40px 0, -40px 0, 0 40px, 0 -40px
            }
        }

        /* Center loader on the screen */
        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(255, 255, 255, 0.8);
            /* Semi-transparent background */
            z-index: 9999;
            /* Ensure it appears above all other content */
            visibility: hidden;
            /* Initially hidden */
            opacity: 0;
            transition: opacity 0.3s, visibility 0.3s;
        }

        /* Show loader */
        .loader-container.active {
            visibility: visible;
            opacity: 1;
        }

        table.dataTable {
            width: 100% !important;
        }

        .dataTables_scrollHeadInner {
            width: 100% !important;

        }

        .error {
            color: red !important;
        }
    </style>


</head>

<body>


    <div class="loader-container">
        <div class="loader"></div>
    </div>




    <main class="main" id="top" style="display: none;">
        @include('sidebar_new')
        @include('top_nav')
        <div class="content fs--1">
            @yield('main-content')

            @include('footer')
        </div>
        @if ($settings->is_ai_chat_enabled)
            @include('fab')
        @endif

    </main>


    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="{{ asset('vendors/popper/popper.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{ asset('vendors/is/is.min.js') }}"></script>
    <script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="{{ asset('vendors/list.js/list.min.js') }}"></script>
    <script src="{{ asset('vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('vendors/dayjs/dayjs.min.js') }}"></script>
    <script src="{{ asset('assets/js/phoenix.js') }}"></script>
    <script src="{{ asset('vendors/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('vendors/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('vendors/leaflet.markercluster/leaflet.markercluster.js') }}"></script>
    <script src="{{ asset('vendors/leaflet.tilelayer.colorfilter/leaflet-tilelayer-colorfilter.min.js') }}"></script>

    <script src="{{ asset('vendors/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>

    <script>
        // Show the loader
        function showLoader() {
            const loaderContainer = document.querySelector('.loader-container');
            loaderContainer.classList.add('active');
        }

        function hideLoader() {
            const loaderContainer = document.querySelector('.loader-container');
            const topSection = document.querySelector('#top');

            loaderContainer.classList.remove('active');
            topSection.style.display = 'block'; // Show the #top section
        }

        // Example usage: Show the loader for 3 seconds
        document.addEventListener('DOMContentLoaded', () => {
            showLoader();
            setTimeout(hideLoader, 3000); // Hide after 3 seconds
        });
    </script>


    <script>
        $(document).ready(function() {
            // $.noConflict();
            var table = $('#datatable').DataTable({
                autoWidth: false,
                lengthChange: true,
                responsive: true,
                scrollX: true,
                order: [
                    [0, 'desc']
                ],
                /*buttons: ["copy", "csv", "excel", "pdf", "print"]*/
            });

            /* table.buttons().container()
                 .appendTo('#datatable_wrapper .col-md-6:eq(0)');*/

        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        setInterval(function() {
            console.log('checktarget');
            $.ajax({
                url: "{{ route('admin.checktarget') }}",
                success: function(response) {
                    if (response.success === true) {
                        console.log(response.message); // display message in console
                        // Optionally show it in the UI
                    }
                }
            });
        }, 30000); // 30,000 milliseconds = 30 seconds
    </script>


    @yield('scripts')
    @include('toaster')
</body>

</html>
