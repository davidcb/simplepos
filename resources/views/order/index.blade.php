@extends('layouts.app')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div id="example2_wrapper" class="dataTables_wrapper form-inline" role="grid">
				<div class="row">
					<div class="col-xs-6"></div>
					<div class="col-xs-6"></div>
				</div>
				<form id="form" action="{{ url('/pedidos') }}" method="get">
					<div class="actions">
						<a href="{{ url('/nuevo-pedido') }}">Añadir pedido</a><span>/</span>
						<a class="delete_selected" href="{{ url('/eliminar-pedidos') }}" onclick="return confirm('¿Está seguro de que desea eliminar los pedidos seleccionados?');">Eliminar seleccionados</a>
					</div>
					<div class="table-responsive">
						<table id="example2" class="table table-bordered table-hover table-striped" aria-describedby="example2_info">
							<thead>
								<tr class="header">
									<th class="checkbox2"><input type="checkbox" id="selectAll" name="selectAll" value="1" /></th>
									<th>Nº pedido <a href="{{ Request::fullUrlWithQuery(['orderby' => 'order_number', 'sort' => 'ASC']) }}" class="asc">Ascendente</a><a href="{{ Request::fullUrlWithQuery(['orderby' => 'order_number', 'sort' => 'DESC']) }}" class="desc">Descendente</a></th>
									<th>Fecha pedido <a href="{{ Request::fullUrlWithQuery(['orderby' => 'order_date', 'sort' => 'ASC']) }}" class="asc">Ascendente</a><a href="{{ Request::fullUrlWithQuery(['orderby' => 'order_date', 'sort' => 'DESC']) }}" class="desc">Descendente</a></th>
									<th>Proveedor <a href="{{ Request::fullUrlWithQuery(['orderby' => 'provider_id', 'sort' => 'ASC']) }}" class="asc">Ascendente</a><a href="{{ Request::fullUrlWithQuery(['orderby' => 'provider_id', 'sort' => 'DESC']) }}" class="desc">Descendente</a></th>
									<th>Marca <a href="{{ Request::fullUrlWithQuery(['orderby' => 'mark', 'sort' => 'ASC']) }}" class="asc">Ascendente</a><a href="{{ Request::fullUrlWithQuery(['orderby' => 'mark', 'sort' => 'DESC']) }}" class="desc">Descendente</a></th>
									<th>Acciones</th>
								</tr>
								<tr class="filter">
									<th></th>
									<th>
										<input type="text" name="filter_order_number" placeholder="Buscar por número" value="{{ Request::get('filter_order_number') }}" />
									</th>
									<th>
										<input type="text" class="half datepicker" name="filter_min_order_date" placeholder="Mín" value="{{ Request::get('filter_min_order_date') }}" />
										<input type="text" class="half datepicker" name="filter_max_order_date" placeholder="Máx" value="{{ Request::get('filter_max_order_date') }}" />
									</th>
									<th>
										<select name="filter_provider">
											<option value=""></option>
											@foreach ($providers as $provider)
											<option value="{{ $provider->id }}" {{ Request::get('filter_provider') == $provider->id ? 'selected' : '' }}>{{ $provider->name }}</option>
											@endforeach
										</select>
									</th>
									<th></th>
									<th>
										<input type="hidden" name="page" value="{{ Request::get('page') }}" />
										<input type="hidden" name="orderby" value="{{ Request::get('orderby') }}" />
										<input type="hidden" name="sort" value="{{ Request::get('sort') }}" />
										<button type="submit" class="apply">Aplicar</button>
										<button type="reset" class="reset">Reiniciar</button>
									</th>
								</tr>
							</thead>

							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php $i = 0; ?>
								@foreach ($orders as $order)
								<tr class="{{ ++$i % 2 == 0 ? 'odd' : 'even' }}">
									<td class="checkbox2"><input type="checkbox" name="selected[]" value="{{ $order->id }}" class="check" /></td>
									<td>{{ $order->order_number }}</td>
									<td>{{ $order->orderDateReadable() }}</td>
									<td>{{ $order->provider->name }}</td>
									<td>{{ $order->mark ? 'Sí' : 'No' }}</td>
									<td>
										<a class="print" href="/imprimir-pedido/{{ $order->id }}" target="_blank">imprimir</a>
										<a class="edit" href="/editar-pedido/{{ $order->id }}">editar</a>
										<a class="delete" href="/eliminar-pedido/{{ $order->id }}" onclick="return confirm('¿Está seguro de que desea eliminar este pedido?');">eliminar</a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</form>

				<div class="row">
					<div class="paginator">
						{!! $pagination->render() !!}
					</div>
				</div>
			</div>
		</div><!-- /.col -->
	</div>
</div>

@endsection

@section('scripts')
@parent

<script>
	$(function() {
		$('.delete_selected').click(function(e) {
			e.preventDefault();
			var selected = new Array();
			var trs = new Array();
			$('.checkbox2 input:checked').each(function() {
				selected.push($(this).val());
				trs.push($(this).parent().parent());
			});
			$.post($(this).attr('href'), {selected: selected, _token: '{{ csrf_token() }}'}, function() {
				trs.each(function() {
					$(this).remove();
				});
			});
		});

		$('.reset').click(function(e) {
			e.preventDefault();
			window.location.replace($('#form').attr('action'));
		});
	});
</script>

@endsection
