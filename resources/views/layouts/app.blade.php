<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Posty</title>
</head>

<body class="bg-gray-200">
    <nav class="p-6 bg-white flex justify-between mb-2">
        <ul class="flex items-center">
            <li>
                <a href="/" class="p-3">Home</a>
            </li>
            <li>
                <a href="{{ route('dashboard') }}" class="p-3">Dashboard</a>
            </li>
            <li>
                <a href="#" class="p-3">Post</a>
            </li>
        </ul>

        <ul class="flex items-center">
            {{-- @if (auth()->user())
                <li>
                    <a href="#" class="p-3">My name</a>
                </li>
                <li>
                    <a href="#" class="p-3">Logout</a>
                </li>
            @else
                <li>
                    <a href="#" class="p-3">Login</a>
                </li>
                <li>
                    <a href="{{ route('register') }}" class="p-3">Register</a>
                </li>
            @endif --}}

            {{-- same functionality but with the auth directive --}}
            @auth
                <li>
                    <a href="#" class="p-3">My name</a>
                </li>
                <li>
                    {{-- The reason for using this a form and button instead of an <a> tag, is to avoid csrf attacks, stopping users from accessing their accounts. --}}
                    <form action="{{ route('logout') }}" method="POST" class="inline p-3">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </li>
            @endauth

            @guest
                <li>
                    <a href="{{ route('login') }}" class="p-3">Login</a>
                </li>
                <li>
                    <a href="{{ route('register') }}" class="p-3">Register</a>
                </li>
            @endguest
        </ul>
    </nav>
    @yield('content')
</body>

</html>
