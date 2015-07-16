<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="keyword" content="">
        <title>An Error Occurred</title>
<?php $assetPrefix = config('app.adminThemeLoc'); ?>
        <link href="{{{ $assetPrefix }}}/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{{ $assetPrefix }}}/css/bootstrap-reset.css" rel="stylesheet">
        <link href="{{{ $assetPrefix }}}/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="{{{ $assetPrefix }}}/css/style.css" rel="stylesheet">
        <link href="{{{ $assetPrefix }}}/css/style-responsive.css" rel="stylesheet" />

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
  <body class="body-404">
      @yield('content')
  </body>
</html>
