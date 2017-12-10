<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>SimplePOS Management</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'>
		<link rel="shortcut icon" type="image/x-icon" href="/img/favicon.png" />
		<!-- Theme style -->
		<link href="/css/app.css" rel="stylesheet" type="text/css" />
	</head>
	<body class="skin-red fixed">
		<div class="wrapper">
			<header class="main-header">
				<!-- Logo -->
				<a href="/" class="logo"><img src="/img/logo.png" alt="SimplePOS" /></a>
				<!-- Header Navbar: style can be found in header.less -->
				<nav class="navbar navbar-static-top" role="navigation">
					<!-- Sidebar toggle button-->
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
						<span class="sr-only">Toggle navigation</span>
					</a>
					{!! Breadcrumbs::render() !!}
				</nav>
			</header>

			<!-- Left side column. contains the logo and sidebar -->
			<aside class="main-sidebar">
				<!-- sidebar: style can be found in sidebar.less -->
				<section class="sidebar">
					@include('partials.sidebar_menu')
				</section>
				<!-- /.sidebar -->
			</aside>

			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<!-- <section class="content-header">
					{!! Breadcrumbs::render() !!}
				</section> -->

				<!-- Main content -->
				<section class="content">
					@yield('content')
				</section><!-- /.content -->
			</div><!-- /.content-wrapper -->

		</div><!-- ./wrapper -->

		<!-- CKEditor JS -->
		<script src="/ckeditor/ckeditor.js"></script>
		<!-- App JS -->
		<script src="/js/app.js"></script>
		<!-- jQuery UI -->
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

		@include('sweet::alert')

		@yield('scripts')
	</body>
</html>
