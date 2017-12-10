@extends('layouts.app')

@section('content')
<form id="form" role="form" method="POST" action="{{ url('/editar-pedido') }}">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="id" value="{{ $order->id }}">

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12">
				<div class="form-horizontal">

					<div class="form-group">
						<div class="col-xs-12 col-md-4">
							<label class="control-label">Nº pedido</label>
							<input type="text" class="form-control" name="order_number" value="{{ old('order_number', $order->order_number) }}">
						</div>
						<div class="col-xs-12 col-md-4">
							<label class="control-label">Fecha pedido</label>
							<input type="text" class="form-control datepicker" name="order_date" value="{{ old('order_date', $order->orderDateReadable()) }}">
						</div>
						<div class="col-xs-12 col-md-4">
							<label class="control-label">Proveedor</label>
							<select class="form-control" name="provider">
								<option value=""></option>
								@foreach ($providers as $provider)
								<option value="{{ $provider->id }}" {{ old('provider', $order->provider_id) == $provider->id ? 'selected' : '' }}>{{ $provider->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-xs-12 col-md-4">
							<label class="control-label">Marca</label><br/>
							<input type="checkbox" name="mark" value="1" {{ old('mark', $order->mark) ? 'checked' : '' }} />
						</div>
					</div>

					@include('partials.related', ['products' => $order->products, 'inputs' => [['label' => 'Cantidad', 'field' => 'quantities', 'pivot_field' => 'amount']], 'elementId' => $order->id, 'elementField' => 'order_id'])

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
