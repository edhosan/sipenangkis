<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name='base_url' id='base_url' value="{{ url('/') }}">
  <title>SIPENANGKIS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ asset('bower_components/AdminLTE/bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('bower_components/AdminLTE/dist/css/AdminLTE.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('bower_components/AdminLTE/dist/css/skins/_all-skins.min.css') }}">
  <link rel="stylesheet" href="{{ asset('bower_components/toastr/toastr.min.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body id="app" class="@{{ body_class }}">
<script src="{{ elixir('js/app.js') }}" ></script>
<!-- jQuery 2.2.3 -->
<script src="{{ asset('bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('bower_components/AdminLTE/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('bower_components/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('bower_components/AdminLTE/plugins/fastclick/fastclick.js') }}"></script>
<script src="{{ asset('bower_components/AdminLTE/dist/js/app.min.js') }}"></script>
<script src="{{ asset('bower_components/toastr/toastr.min.js') }}"></script>
</body>
</html>
