<!doctype html>
<html lang="en">
<head>
    @include('includes.MetaData')
    @include('includes.Stylesheets')
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltips and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login-body <?php
if (isset($_controller)) {
    echo $_controller;
    echo isset($_action) ? ' ' . $_controller . '-' . $_action . ' ' : '';
}
?>">
@yield('NavBar')
@yield('Sidebar')
@yield('content')
@yield('Footer')
@include('includes.Scripts')
</body>
</html>
