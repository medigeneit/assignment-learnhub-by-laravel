<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LearnHub')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header class="app-bar">
        @section('header')
            <a href="{{ route('courses.index') }}" class="app-bar-title">LearnHub</a>
        @show
    </header>

    <main class="container">
        @yield('content')
    </main>
</body>
</html>
