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
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Correo electrónico" required autofocus>
                    <input id="password" type="password" class="form-control" name="password" placeholder="Nueva contraseña" required>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirmar nueva contraseña" required>
                    <button type="submit" class="btn btn-primary">Restablecer</button>
                </form>
            </div>
		</div>

		<script src="/js/tpv.js"></script>

		@include('sweet::alert')
	</body>
</html>
