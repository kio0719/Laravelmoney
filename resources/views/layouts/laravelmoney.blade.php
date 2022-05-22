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
        html{font-size:100%;
        }
        body{font-family:"Yu Gothic Medium","游ゴシック Medium",YuGothic,"游ゴシック体","ヒラギノ角ゴ Pro W3",sans-serif;
        line-height: 1.7;
    color:#432}
        a{text-decoration: none;}
        img{
            max-width: 100%;
        }
    header{
        background-color:#0bd;
        height:130px;
        margin-bottom:40px
    }
    form{
       margin:0 auto;
    }
    footer{
        background-color:#432;
        text-align:center;
        padding:26px 0;
    }
    footer p{
        color:#fff;
        font-size:0.875rem
    }
    .sub-title{
        font-family: 'Alegreya', serif;
    }
    .wrapper{
        max-width:1100px;
        margin:0 auto;
        padding :0 4%;
    }
    .title{
        padding-top:30px;
        text-align: center;
        font-family: 'Alegreya', serif;
    }
    .errorMessage{
        color:red;
    }
    table{
        border:solid #432 1px;
        border-collapse: collapse;
        margin:5rem;
    }
    td,th{ 
        border:solid #432 1px;
     padding:0.5rem 1rem;
    }
    </style>
</head>
<body>
<header>
    <div class="wrapper">
    <h1 class="title">LaravelMoney</h1>
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