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
                <form class="form-horizontal" role="form" method="POST" action="{{ route('tpv.login') }}">
                    {{ csrf_field() }}
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Correo electrónico" required autofocus>
                    <input id="password" type="password" class="form-control" name="password" placeholder="Contraseña" required>
                    <a class="btn btn-link" href="{{ route('tpv.password.request') }}">¿Olvidaste tu contraseña?</a>
                    <button type="submit" class="btn btn-primary">Acceder</button>
                </form>
            </div>
		</div>

		<script src="/js/tpv.js"></script>

		@include('sweet::alert')
	</body>
</html>
