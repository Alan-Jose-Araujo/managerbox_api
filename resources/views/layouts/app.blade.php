<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ManagerBox')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://code.jqueryui.com/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        @yield('content')
    </div>
</body>
</html>
