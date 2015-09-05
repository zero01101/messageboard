<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>msgboard</title>
    <!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="//<?php echo getenv('APP_HOST') . '/' . getenv('APP_PATH') . '/'?>css/bootstrap.css">
    <link rel="stylesheet" href="//<?php echo getenv('APP_HOST') . '/' . getenv('APP_PATH') . '/'?>css/jquery-ui.css">
    <link rel="stylesheet" href="//<?php echo getenv('APP_HOST') . '/' . getenv('APP_PATH') . '/'?>css/introjs.css">
    <!--<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>-->
    <script src="//<?php echo getenv('APP_HOST') . '/' . getenv('APP_PATH') . '/'?>js/jquery-1.11.3.js"></script>
    <script src="//<?php echo getenv('APP_HOST') . '/' . getenv('APP_PATH') . '/'?>js/jquery-ui.js"></script>
    <script src="//<?php echo getenv('APP_HOST') . '/' . getenv('APP_PATH') . '/'?>js/bootstrap.js"></script>
    <script src="//<?php echo getenv('APP_HOST') . '/' . getenv('APP_PATH') . '/'?>js/intro.js"></script>
</head>
<body>
<div class="container">
    @yield('content')
</div>
@yield('footer')
</body>
</html>

