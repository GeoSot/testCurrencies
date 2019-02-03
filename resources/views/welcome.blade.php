<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">

    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Currencies</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{mix('css/app.css')}}"/>

</head>
<body class=" d-flex flex-column justify-content-center  align-items-center ">
<main id="app" class="container">

    <h1 class="h2 text-muted text-center py-2 mb-4 border-bottom">Currencies</h1>
    <div class="h5 text-muted text-center">Please Insert The Coin you want to Calculate and the amount</div>
    <currency-select-boxes :currencies='@json($currencies)'
                           :available-exchanges='@json($availableExchanges)' :action="'{{route('currencies.calculate')}}'"></currency-select-boxes>
</main>

<script src="{{mix('js/app.js')}}"></script>
</body>
</html>


