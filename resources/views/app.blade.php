<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

        @viteReactRefresh
        @vite(['resources/js/app.tsx'])
    </head>
    <body>
        <div id="app"></div>

        <script>
            window.__APP_DATA__ = {{ \Illuminate\Support\Js::from($appData ?? []) }};
        </script>
    </body>
</html>
