<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ABBC Report System</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
    html, body {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Nunito', sans-serif;
        font-weight: 200;
        height: 100vh;
        margin: 0;
    }

    .full-height {
        height: 100vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }

    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
        /* height: 50px; */
        padding: 10px;
        background-color: #000;
        color: #fff !important;
        border-radius: 5px;
    }
    .top-right a{

        color: #ffffff !important;
    }

    .content {
        text-align: center;
    }

    .title {
        font-size: 50px;
    }

    .links > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }

    .m-b-md {
        margin-bottom: 30px;
    }

    .tnc {
        margin-right: 25px;
    }
        .bck-img{
            position: absolute;
            top: 0px;
            width: 100%;
            height: 100%;
            object-fit: cover;
            overflow: hidden;
        }
    .btm-br{
        position: fixed;
        display: block;
        width: 100%;
        bottom: 0px;
        left: 0px;
        padding-top: 40px;
        /* margin: auto; */
        padding: auto;
        height: 70px;
        background-color: rgba(255, 255, 255, 0.72);

    }

    </style>
</head>
<body>

<img class="bck-img" src="asset/img/bck.png" >
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
        <div class="top-right links">
            @auth
            <a href="{{ url('/home') }}">Home</a>
            @else
            <a href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
            <!-- <a href="{{ route('register') }}">Register</a> -->
            @endif
            @endauth
        </div>
        @endif

        <div class="content">
          <img src="asset/img/abbc.png" height="200px">
          <div class="title m-b-md">
           TNC IT GROUP <br>MANAGEMENT SYSTEM

        </div>

            <hr>
            <div style="padding-top: 30px" class="btm-br">
        <img src="asset/img/tnc.svg" height="30px" class="tnc"> &nbsp
        <img src="asset/img/adn_logo.png" height="30px">
        <img src="asset/img/logo.png" height="30px">
            </div>






    </div>
</div>
</body>
</html>
