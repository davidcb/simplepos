@extends('layouts.app')

@section('content')
<form id="form" role="form" method="POST" action="{{ url('/editar-producto') }}">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="id" value="{{ $product->id }}">

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12">
				<div class="form-horizontal">

					<div class="form-group">
						<div class="col-xs-12 col-md-4">
							<label class="control-label">Nombre</label>
							<input type="text" class="form-control" name="name" value="{{ old('name', $product->name) }}">
						</div>
						<div class="col-xs-12 col-md-4">
							<label class="control-label">EAN</label>
							<input type="text" class="form-control" name="ean" value="{{ old('ean', $product->ean) }}">
						</div>
						<div class="col-xs-12 col-md-4">
							<label class="control-label">Precio venta</label>
							<input type="text" class="form-control" name="price" value="{{ old('price', $product->price) }}">
						</div>
						<div class="col-xs-12 col-md-4">
							<label class="control-label">Proveedor</label>
							<select class="form-control" name="provider">
								<option value="">Proveedor</option>
								@foreach ($providers as $provider)
								<option value="{{ $provider->id }}" {{ old('provider', $product->provider_id) == $provider->id ? 'selected' : '' }}>{{ $provider->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-xs-12 col-md-4">
							<label class="control-label">Color</label><br/>
							<input type="text" class="form-control colorpicker" name="color" value="{{ old('color', $product->color) }}">
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

@section('scripts')
@parent

<script src="{{ asset('js/colorpicker.js') }}"></script>
<script>
	$(function() {
		$('.colorpicker').colorpicker({
			format: 'hex',
			color: '{{ old('color', $product->color) }}',
		});
	});
</script>

@endsection
