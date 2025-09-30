<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        [x-cloak] {
            display: none;
        }

        .nav-left img {
            filter: invert(100%);
        }

        .nav-left>li:hover img {
            filter: none;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @assets
    @yield('head')
</head>

<body class="bg-stone-100">
    <div>
        @livewire('app-layout')
    </div>
</body>
<script>
    document.addEventListener('navigateTo', () => {
        // Limpia la URL
        const cleanURL = window.location.origin + window.location.pathname;
        history.replaceState(null, '', cleanURL);
        // Reinicia la paginación en el componente Livewire
        Livewire.dispatch('resetPagination');
    });

    document.addEventListener('cleanURL', () => {
        // Limpia la URL
        const cleanURL = window.location.origin + window.location.pathname;
        history.replaceState(null, '', cleanURL);
        Livewire.dispatch('resetPagination');
    });
</script>

</html>
