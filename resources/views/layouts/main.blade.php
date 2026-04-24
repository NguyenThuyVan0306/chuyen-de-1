<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLB</title>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @php
        $route = request()->route()?->getName();
    @endphp

    @if(in_array($route, ['login', 'register']))
        <div class="auth-page">
            <div class="auth-wrapper">
                <div class="brand">Club.io</div>

                <div class="auth-card">
                    @if(session('success'))
                        <div class="alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert-error">{{ session('error') }}</div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    @else
        @yield('content')
    @endif
</body>
</html>