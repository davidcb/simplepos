<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>SimplePOS</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'>
		<link rel="shortcut icon" type="image/x-icon" href="/img/favicon.png" />
		<link href="/css/tpv.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div class="content-wrapper">
			@include('tpv.partials.header')
			@yield('content')
		</div>

		@include('tpv.partials.moves')

		<script src="/js/tpv.js"></script>

		@include('sweet::alert')

		@yield('scripts')
	</body>
</html>
