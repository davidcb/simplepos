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
            <div class="login">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('tpv.password.email') }}">
                    {{ csrf_field() }}
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Correo electrónico" required autofocus>
                    <button type="submit" class="btn btn-primary">Enviar enlace</button>
                </form>
            </div>
		</div>

		<script src="/js/tpv.js"></script>

		@include('sweet::alert')
	</body>
</html>
