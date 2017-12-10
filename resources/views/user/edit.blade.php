@extends('layouts.app')

@section('content')
<form id="form" role="form" method="POST" action="{{ url('/editar-usuario') }}">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="id" value="{{ $user->id }}">

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12">
				<div class="form-horizontal">

					<div class="form-group">
						<div class="col-xs-12 col-md-4">
							<label class="control-label">Nombre</label>
							<input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}">
						</div>
						<div class="col-xs-12 col-md-4">
							<label class="control-label">Email</label>
							<input type="text" class="form-control" name="email" value="{{ old('email', $user->email) }}">
						</div>
						<div class="col-xs-12 col-md-4">
							<label class="control-label">Contraseña</label>
							<input type="password" class="form-control" name="password">
						</div>
					</div>

					<div class="form-group">
						<div class="col-xs-12 col-md-4">
							<label class="control-label">Repetir contraseña</label>
							<input type="password" class="form-control" name="password_confirmation">
						</div>
						<div class="col-xs-12 col-md-4">
							<label class="control-label">Tipo de usuario</label>
							<select class="form-control" name="role">
								<option value="1" {{ old('role', $user->role) == 1 ? 'selected' : '' }}>Vendedor</option>
								<option value="2" {{ old('role', $user->role) == 2 ? 'selected' : '' }}>Administrador</option>
							</select>
						</div>
					</div>

					<div class="form-group buttons">
						<div class="col-md-12">
							<a href="{{ URL::previous() }}" class="cancel_button">Cancelar</a>
							<button type="submit" class="my_button submit">Guardar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

@endsection
