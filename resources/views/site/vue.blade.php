<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>window.Laravel = { csrfToken: '{{ csrf_token() }}' }</script>

    <title>Laravel API & Vue search component</title>

    <link rel="stylesheet" href="{{ asset('src/css/bootstrap.min.css')}}" >
    <link rel="stylesheet" href="{{ asset('css/jon_style.css') }}">

    <!-- jQuery -->
    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous">
    </script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

</head>
<body>
<div id="app">
    <navbar></navbar>
    <div class="container">
        <properties></properties>
    </div>
</div>

<script src="{{ asset('src/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('src/fontawesome/js/all.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>