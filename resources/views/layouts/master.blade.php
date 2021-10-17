<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="Social Media">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Social Media</title>

    <!--Google font-->
    <link href="../../../external.html?link=https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" type="text/css" href="{{url('css/fontawesome.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('css/fontawesome/css/all.css')}}">


    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="{{url('css/bootstrap.css')}}">

    <!-- Theme css -->
    <link rel="stylesheet" type="text/css" href="{{url('css/style.css')}}" media="screen" id="color">

    <script>
        var app_url = "{{url('/')}}"
    </script>
</head>

<body>

@yield('content')

<!-- latest jquery-->
<script src="{{url('js/jquery-3.3.1.min.js')}}"></script>

<!-- popper js-->
<script src="{{url('js/popper.min.js')}}"></script>

<!-- Bootstrap js-->
<script src="{{url('js/bootstrap.js')}}"></script>

@yield('after-scripts')
</body>



</html>

