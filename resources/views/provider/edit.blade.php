@extends('layouts.app')

@section('content')
<form id="form" role="form" method="POST" action="{{ url('/editar-proveedor') }}">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="id" value="{{ $provider->id }}">

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12">
				<div class="form-horizontal">

					<div class="form-group">
						<div class="col-xs-12 col-md-4">
							<label class="control-label">Nombre</label>
							<input type="text" class="form-control" name="name" value="{{ old('name', $provider->name) }}">
						</div>
						<div class="col-xs-12 col-md-4">
							<label class="control-label">Denominación social</label>
							<input type="text" class="form-control" name="business_name" value="{{ old('business_name', $provider->business_name) }}">
						</div>
						<div class="col-xs-12 col-md-4">
							<label class="control-label">CIF</label>
							<input type="text" class="form-control" name="cif" value="{{ old('cif', $provider->cif) }}">
						</div>
					</div>

					<div class="form-group">
						<div class="col-xs-12 col-md-4">
							<label class="control-label">Dirección</label>
							<input type="text" class="form-control" name="address" value="{{ old('address', $provider->address) }}">
						</div>
						<div class="col-xs-12 col-md-4">
							<label class="control-label">Código postal</label>
							<input type="text" class="form-control" name="zipcode" value="{{ old('zipcode', $provider->zipcode) }}">
						</div>
						<div class="col-xs-12 col-md-4">
							<label class="control-label">Municipio</label>
							<input type="text" class="form-control" name="city" value="{{ old('city', $provider->city) }}">
						</div>
					</div>

					<div class="form-group">
						<div class="col-xs-12 col-md-4">
							<label class="control-label">Provincia</label>
							<input type="text" class="form-control" name="province" value="{{ old('province', $provider->province) }}">
						</div>
						<div class="col-xs-12 col-md-4">
							<label class="control-label">Teléfono</label>
							<input type="text" class="form-control" name="telephone" value="{{ old('telephone', $provider->telephone) }}">
						</div>
						<div class="col-xs-12 col-md-4">
							<label class="control-label">Teléfono 2</label>
							<input type="text" class="form-control" name="telephone2" value="{{ old('telephone2', $provider->telephone2) }}">
						</div>
					</div>

					<div class="form-group">
						<div class="col-xs-12 col-md-4">
							<label class="control-label">Fax</label>
							<input type="text" class="form-control" name="fax" value="{{ old('fax', $provider->fax) }}">
						</div>
						<div class="col-xs-12 col-md-4">
							<label class="control-label">Email</label>
							<input type="text" class="form-control" name="email" value="{{ old('email', $provider->email) }}">
						</div>
						<div class="col-xs-12 col-md-4">
							<label class="control-label">IBAN</label>
							<input type="text" class="form-control" name="iban" value="{{ old('iban', $provider->iban) }}">
						</div>
					</div>

					<div class="form-group">
						<div class="col-xs-12 col-md-4">
							<label class="control-label">Responsable</label>
							<input type="text" class="form-control" name="contact" value="{{ old('contact', $provider->contact) }}">
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
