<head>
    <meta charset="UTF-8">
    <title>@hasSection('htmlheader_title')@yield('htmlheader_title') - @endif{{ LAConfigs::getByKey('sitename') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Bootstrap 3.3.4 -->
    <!-- <link href="{{ asset('la-assets/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    
    <link href="{{ asset('la-assets/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" /> -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- <link href="{{ asset('la-assets/css/ionicons.min.css') }}" rel="stylesheet" type="text/css" /> -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    
    <!-- Theme style -->
    <!-- <link href="{{ asset('la-assets/css/AdminLTE.css') }}" rel="stylesheet" type="text/css" /> -->
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <!-- <link href="{{ asset('la-assets/css/skins/'.LAConfigs::getByKey('skin').'.css') }}" rel="stylesheet" type="text/css" /> -->
    <!-- iCheck -->
    <!-- <link href="{{ asset('la-assets/plugins/iCheck/square/blue.css') }}" rel="stylesheet" type="text/css" /> -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>King Admin</title>

        <!-- Vendor CSS -->
        <link href="{{ asset('material-assets/vendors/bower_components/fullcalendar/dist/fullcalendar.min.css') }} " rel="stylesheet">
        <link href="{{ asset('material-assets/vendors/bower_components/animate.css/animate.min.css') }} " rel="stylesheet">
        <link href="{{ asset('material-assets/vendors/bower_components/sweetalert2/dist/sweetalert2.min.css') }} " rel="stylesheet">
        <link href="{{ asset('material-assets/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css') }} " rel="stylesheet">
        <link href="{{ asset('material-assets/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') }} " rel="stylesheet">
        <link href="{{ asset('material-assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }} " rel="stylesheet">
        
        <!-- CSS -->
        <link href="{{ asset('material-assets/css/app_1.min.css') }}" rel="stylesheet">
        <link href="{{ asset('material-assets/css/app_2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('material-assets/css/customize.css') }}" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&amp;subset=latin-ext" rel="stylesheet">
    
    
    @stack('styles')
    
</head>
