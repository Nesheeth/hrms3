<!DOCTYPE html>
<html>

<!-- Mirrored from steelcoders.com/modern/admin1/404.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 21 Dec 2017 18:35:45 GMT -->
<head>

	<!-- Title -->
	<title>HRMS | Reset Password</title>

	<meta content="width=device-width, initial-scale=1" name="viewport"/>
	<meta charset="UTF-8">
	<meta name="description" content="Admin Dashboard Template" />
	<meta name="keywords" content="admin,dashboard" />
	<meta name="author" content="Steelcoders" />

	<!-- Styles -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
	{{Html::style("assets/plugins/pace-master/themes/blue/pace-theme-flash.css")}}
	{{Html::style("assets/plugins/uniform/css/uniform.default.min.css")}}
	{{Html::style("assets/plugins/bootstrap/css/bootstrap.min.css")}}
	{{Html::style("assets/plugins/fontawesome/css/font-awesome.css")}}
	{{Html::style("assets/plugins/line-icons/simple-line-icons.css")}}	
	{{Html::style("assets/plugins/offcanvasmenueffects/css/menu_cornerbox.css")}}	
	{{Html::style("assets/plugins/waves/waves.min.css")}}	
	{{Html::style("assets/plugins/switchery/switchery.min.css")}}
	{{Html::style("assets/plugins/3d-bold-navigation/css/style.css")}}	

	<!-- Theme Styles -->
	{{Html::style("assets/css/modern.min.css")}}
	{{Html::style("assets/css/themes/green.css")}}
	{{Html::style("assets/css/custom.css")}}

	{{ Html::script("assets/plugins/3d-bold-navigation/js/modernizr.js") }}
	{{ Html::script("assets/plugins/offcanvasmenueffects/js/snap.svg-min.js") }}

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        {{ Html::script("https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js") }}
        {{ Html::script("https://oss.maxcdn.com/respond/1.4.2/respond.min.js") }}
    <![endif]-->

</head>
<body class="page-login">
	<main class="page-content">
		<div class="page-inner">
			<div id="main-wrapper">
				<div class="row">
					<div class="col-md-3 center">
						<div class="login-box">
							@if (session('error'))
							<div class="alert alert-danger">
								{{ session('error') }}
							</div>
							@endif

							@if (session('success'))
							<div class="alert alert-success">
								{{ session('success') }}
							</div>
							@endif
							<a href="{{URL('/')}}" class="logo-name text-lg text-center">HRMS</a>
							<p class="text-center m-t-md">Set new Password</p>
							<form class="m-t-md" action="{{URL('/reset-password')}}" method="post">
								{{ csrf_field() }}
								<div class="form-group">
									<input type="password" name="new_password"  class="form-control" placeholder="New Password">
									@if ($errors->has('new_password'))
									<span class="label label-danger">{{ $errors->first('new_password') }}</span>
									@endif
								</div>
								<div class="form-group">
									<input type="password" name="confirm_password"  class="form-control" placeholder="Confirm Password">
									@if ($errors->has('confirm_password'))
									<span class="label label-danger">{{ $errors->first('confirm_password') }}</span>
									@endif
								</div>
								<button type="submit" class="btn btn-success btn-block">Reset</button>
							</form>
							
							<p class="text-center m-t-xs text-sm">{{date('Y')}} &copy; Coding Brains Software Solution Pvt Ltd.</p>
						</div>
					</div>
				</div><!-- Row -->
			</div><!-- Main Wrapper -->
		</div><!-- Page Inner -->
	</main><!-- Page Content -->

	<!-- Javascripts -->
	{{ Html::script("assets/plugins/jquery/jquery-2.1.4.min.js") }}
	{{ Html::script("assets/plugins/jquery-ui/jquery-ui.min.js") }}
	{{ Html::script("assets/plugins/pace-master/pace.min.js") }}
	{{ Html::script("assets/plugins/jquery-blockui/jquery.blockui.js") }}
	{{ Html::script("assets/plugins/bootstrap/js/bootstrap.min.js") }}
	{{ Html::script("assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js") }}
	{{ Html::script("assets/plugins/switchery/switchery.min.js") }}
	{{ Html::script("assets/plugins/uniform/jquery.uniform.min.js") }}
	{{ Html::script("assets/plugins/offcanvasmenueffects/js/classie.js") }}
	{{ Html::script("assets/plugins/waves/waves.min.js") }}
	{{ Html::script("assets/js/modern.min.js") }}

</body>

<!-- Mirrored from steelcoders.com/modern/admin1/404.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 21 Dec 2017 18:35:45 GMT -->
</html>