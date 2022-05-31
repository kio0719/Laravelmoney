<!DOCTYPE html>
<html lang="japanese">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!--Font  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Alegreya&display=swap" rel="stylesheet">

<style>
img{
    width:25%;
}
</style>

</head>
<body>
<header class="py-4">
    <div class="container text-center">
    <h1 class="h1"><a href="{{route('user.profile')}}"><img class="mw-100" src="{{ asset('images/logo.png')}}" alt="laravelmoney">LaravelMoney</a></h1>
    </div>
</header>
@include('components.nav')

<main>
@yield('content')
</main>


<footer>
    <div class="wrapper">
        <p><small>&copy; 2022 IO</small></p>
    </div>
</footer>
<script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>