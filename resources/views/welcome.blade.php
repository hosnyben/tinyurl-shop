<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
		<title>{{ config('app.name') }}</title>
		<meta charset="UTF-8" />
    </head>
    <body>
        <div id="app"></div>
        @vite(['resources/js/main.js'])
	</body>
</html>
