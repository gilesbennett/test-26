<html lang="en" class="min-h-full scroll-smooth antialiased js-focus-visible" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col">
@include('includes.navbar')
@yield('content')
@yield('pagination')
</body>
</html>
