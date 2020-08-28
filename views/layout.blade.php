<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="docsearch:version" content="{{ $currentVersion }}">
    <title>{{ isset($title) ? $title . ' - ' : null }}{{ $config->title ?? 'Docs' }}</title>

    <style>
        :root {
            @foreach($theme as $var => $value)
            --{{ $var }}: {{ $value }};
            @endforeach
        }
    </style>

    <x-styles/>
    <link rel="stylesheet" href="/docdress/css/app.css?t={{ time() }}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/turbolinks/5.2.0/turbolinks.js"></script>
    <script src="/docdress/js/app.js"></script>

</head>
<body>
    
    @yield('content')

    <x-script>
        function ready(f){/in/.test(document.readyState)?setTimeout('ready('+f+')',9):f()}

        ready(function() {
            Prism.highlightAll()
        });
    </x-script>
    
    <x-scripts/>
    
</body>
</html>