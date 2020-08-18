<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fjuse</title>

    <x-styles/>
    <link rel="stylesheet" href="/docdress/css/app.css?t={{ time() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
</head>
<body>
    
    @yield('content')

    <x-script>
        function ready(f){/in/.test(document.readyState)?setTimeout('ready('+f+')',9):f()}
    </x-script>

    <script src="/docdress/js/app.js"></script>
    <x-scripts/>
    
</body>
</html>