<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title>Omnya Center</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="aassets/img/logo.svg" rel="icon">
    <link href="{{ asset('site/assets/img/logo.svg') }}" rel="apple-touch-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" id="app-style"
        rel="stylesheet" type="text/css" />

    <!-- Template Main CSS File -->
    <link href="{{ asset('site/assets/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <div>
            <router-view></router-view>
        </div>
    </div>

    <!-- Template Main JS File -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('site/assets/js/main.js') }}"></script>

</body>

</html>
