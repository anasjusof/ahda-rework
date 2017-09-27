<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <Script>window.laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};</script>    

        <style>

            .bg-1 {
                background-image:url("image/head2.jpg");
                margin-bottom: 0;
                min-height: 100%;
                background-repeat: no-repeat;
                background-position: center;
                background-size: cover;
                background-attachment: fixed;

            }
            .bg-2 {
                background-color:#3399ff;
                background-attachment: fixed;

            }

            .box {


                color: #000;
                font-family: "Inconsolata",sans-serif;
                font-size: 18px;
                line-height: 27px;
                padding-bottom: 8px;
                padding-left: 16px;
                padding-right: 16px;
                padding-top: 8px;
                text-align: center;


            }

            .w3-padding {
                padding: 8px 16px !important;
            }
            .w3-center {
                text-align: center !important;
            }
            .w3-card, .w3-card-2 {
                box-shadow: 0px 2px 5px 0px rgba(0, 0, 0, 0.16), 0px 2px 10px 0px rgba(0, 0, 0, 0.12);
            }
            .w3-container, .w3-panel {
                padding: 0.01em 16px;
            }
            .w3-padding-48 {
                padding-top: 48px !important;
                padding-bottom: 48px !important;
            }
            .w3-container, .w3-panel {
                padding: 0.01em 16px;
            }

        </style>
    </head>
    <body>


        @if (Session::has('success'))

        <div class="alert alert-success" role="alert">
            <strong>Success:</strong> {{ Session::get('success') }}
        </div>

        @endif

        @if (Session::has('saved'))

        <div class="alert alert-success" role="alert">
            <strong>Success:</strong> {{ Session::get('saved') }}
        </div>

        @endif

        @yield('content')
        
    </div>

    <footer class="col-md-12 bg-2"><p class="text-center" style="color:#000000; "> Copyright Ahdashuhadah - All Right Reserved </p></footer>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
      $( function() {
         $( "#datepicker" ).datepicker({dateFormat:'yy/mm/dd'});
         $( "#datepicker2" ).datepicker({dateFormat:'yy/mm/dd'});
         $( "#datepicker3" ).datepicker({dateFormat:'yy/mm/dd'});
         $( "#datepicker4" ).datepicker({dateFormat:'yy/mm/dd'});
         $( "#datepicker5" ).datepicker({dateFormat:'yy/mm/dd'});
         $( "#datepicker6" ).datepicker({dateFormat:'yy/mm/dd'});
    } );
  </script>
</body>
</html>

