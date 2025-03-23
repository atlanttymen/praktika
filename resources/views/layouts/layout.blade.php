<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>To do List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <!-- <link rel="stylesheet" href="resources\css\app.css"> -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="notifications">
        @if ($errors->any())
        <div class="alert alert-danger" id="error-alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success" id="success-alert">
            {{ session('success') }}
        </div>
    @endif
    </div>
    @if (session('error'))
        <div class="alert alert-danger" id="error-alert">
            {{ session('error') }}
        </div>
    @endif
    </div>

    @if (Auth::user())
    <div class="user">
        <i class="fa-solid fa-user" style="color: #000000;"></i> {{ Auth::user()->name }}
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" class="btnnav" style="color: #ff0000">Logout</button>
        </form>
    </div>
    @else
    <div class="auth">
        <button onclick="window.location='{{route('login')}}'" class="btnnav ">
            <i class="fa-solid fa-right-to-bracket" style="color: #000000;"></i>
            <span>Авторизация</span>
        </button>
        <button onclick="window.location='{{route('register')}}'" class="btnnav ">
            <i class="fa-solid fa-id-card" style="color: #000000;"></i>
            <span>Регистрация</span>
        </button>
    </div>
    
    @endif

    @yield('content')
    </div>

    <div class="preloader">
        <div class="loader"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    {{--
    <script src="resources\js\app.js"></script> --}}
</body>

</html>
