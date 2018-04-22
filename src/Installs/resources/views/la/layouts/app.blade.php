<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<html lang="en">
	@section('htmlheader')
		@include('la.layouts.partials.htmlheader')
	@show
    
    <body class="{{ LAConfigs::getByKey('skin') }} {{ LAConfigs::getByKey('layout') }} @if(LAConfigs::getByKey('layout') == 'sidebar-mini') sidebar-collapse @endif" bsurl="{{ url('') }}" adminRoute="{{ config('laraadmin.adminRoute') }}">
		@include('la.layouts.partials.mainheader')
		
		
        <section id="main">
            @hasSection('section')
                <ol class="breadcrumb">
                    <li><a href="@yield('section_url')"><i class="fa fa-dashboard"></i> @yield('section')</a></li>
                    @hasSection('sub_section')<li class="active"> @yield('sub_section') </li>@endif
                </ol>
            @endif
            
			@if(LAConfigs::getByKey('layout') != 'layout-top-nav')
				@include('la.layouts.partials.sidebar')
			@endif
		
			<!-- Main content -->
			<section id="content" class=" {{ $no_padding or '' }}">
				@if(!isset($no_header))
					@include('la.layouts.partials.contentheader')
				@endif
				
				<!-- Your Page Content Here -->
				@yield('main-content')
			</section><!-- /.content -->

            @include('la.layouts.partials.delete_confirm_dialog')
        </section>

        

        <footer id="footer">
            Copyright &copy; 2018

            <!-- <ul class="f-menu">
                <li><a href="">Home</a></li>
                <li><a href="">Dashboard</a></li>
                <li><a href="">Reports</a></li>
                <li><a href="">Support</a></li>
                <li><a href="">Contact</a></li>
            </ul> -->
        </footer>

        <!-- Page Loader -->
        <div class="page-loader">
            <div class="preloader pls-blue">
                <svg class="pl-circular" viewBox="25 25 50 50">
                    <circle class="plc-path" cx="50" cy="50" r="20" />
                </svg>

                <p>Please wait...</p>
            </div>
        </div>

        <!-- Older IE warning message -->
        <!--[if lt IE 9]>
            <div class="ie-warning">
                <h1 class="c-white">Warning!!</h1>
                <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
                <div class="iew-container">
                    <ul class="iew-download">
                        <li>
                            <a href="http://www.google.com/chrome/">
                                <img src="img/browsers/chrome.png" alt="">
                                <div>Chrome</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.mozilla.org/en-US/firefox/new/">
                                <img src="img/browsers/firefox.png" alt="">
                                <div>Firefox</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.opera.com">
                                <img src="img/browsers/opera.png" alt="">
                                <div>Opera</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.apple.com/safari/">
                                <img src="img/browsers/safari.png" alt="">
                                <div>Safari</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                                <img src="img/browsers/ie.png" alt="">
                                <div>IE (New)</div>
                            </a>
                        </li>
                    </ul>
                </div>
                <p>Sorry for the inconvenience!</p>
            </div>
        <![endif]-->
		@section('scripts')
			@include('la.layouts.partials.scripts')
		@show
        
    </body>
  </html>
