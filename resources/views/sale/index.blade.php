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
				<form id="form" action="{{ url('/ventas') }}" method="get">
					<div class="actions">
						<!-- <a class="delete_selected" href="{{ url('/eliminar-ventas') }}" onclick="return confirm('¿Está seguro de que desea eliminar el personal seleccionado?');">Eliminar seleccionados</a> -->
					</div>
					<div class="table-responsive">
						<table id="example2" class="table table-bordered table-hover table-striped" aria-describedby="example2_info">
							<thead>
								<tr class="header">
									<th class="checkbox2"><input type="checkbox" id="selectAll" name="selectAll" value="1" /></th>
									<th>Nº ticket</th>
									<th>Total <a href="{{ Request::fullUrlWithQuery(['orderby' => 'total', 'sort' => 'ASC']) }}" class="asc">Ascendente</a><a href="{{ Request::fullUrlWithQuery(['orderby' => 'total', 'sort' => 'DESC']) }}" class="desc">Descendente</a></th>
									<th>Forma de pago <a href="{{ Request::fullUrlWithQuery(['orderby' => 'payment_method', 'sort' => 'ASC']) }}" class="asc">Ascendente</a><a href="{{ Request::fullUrlWithQuery(['orderby' => 'payment_method', 'sort' => 'DESC']) }}" class="desc">Descendente</a></th>
									<th>Fecha <a href="{{ Request::fullUrlWithQuery(['orderby' => 'updated_at', 'sort' => 'ASC']) }}" class="asc">Ascendente</a><a href="{{ Request::fullUrlWithQuery(['orderby' => 'updated_at', 'sort' => 'DESC']) }}" class="desc">Descendente</a></th>
									<th>Acciones</th>
								</tr>
								<tr class="filter">
									<th></th>
    								<th></th>
									<th>
										<input type="text" class="half" name="filter_min_total" placeholder="Mín" value="{{ Request::get('filter_min_total') }}" />
										<input type="text" class="half" name="filter_max_total" placeholder="Máx" value="{{ Request::get('filter_max_total') }}" />
									</th>
									<th>
										<select name="filter_payment_method">
											<option value=""></option>
											<option value="1" {{ Request::get('filter_payment_method') == 1 ? 'selected' : '' }}>Efectivo</option>
											<option value="2" {{ Request::get('filter_payment_method') == 2 ? 'selected' : '' }}>Tarjeta</option>
										</select>
									</th>
									<th>
										<input type="text" class="half datepicker" name="filter_min_updated_at" placeholder="Mín" value="{{ Request::get('filter_min_updated_at') }}" />
										<input type="text" class="half datepicker" name="filter_max_updated_at" placeholder="Máx" value="{{ Request::get('filter_max_updated_at') }}" />
									</th>
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
								@foreach ($sales as $sale)
								<tr class="{{ ++$i % 2 == 0 ? 'odd' : 'even' }}">
									<td class="checkbox2"><input type="checkbox" name="selected[]" value="{{ $sale->id }}" class="check" /></td>
									<td>{{ $sale->number() }}</td>
									<td>{{ $sale->total }}€</td>
									<td>{{ $sale->paymentMethodReadable() }}</td>
									<td>{{ $sale->updatedAtReadable() }} - {{ $sale->updatedAtReadable('H:i:s') }}</td>
									<td>
										<a class="export" href="/exportar-venta/{{ $sale->id }}">exportar pdf</a>
										<!-- <a class="edit" href="/editar-venta/{{ $sale->id }}">editar</a>
										<a class="delete" href="/eliminar-venta/{{ $sale->id }}" onclick="return confirm('¿Está seguro de que desea eliminar esta venta?');">eliminar</a> -->
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
			$.post($(this).attr('href'), {selected: selected, _token: '{{ csrf_token() }}'}, function(data) {
				$.each(trs, function(key, value) {
					id = $(this).find('.checkbox2 input').val();
					if (data.indexOf(id) < 0) {
						value.remove();
					}
				});
				if (data != 'ok') {
					alert('No se pudo eliminar algún personal por estar asociado a visitas');
				}
			});
		});

		$('.reset').click(function(e) {
			e.preventDefault();
			window.location.replace($('#form').attr('action'));
		});
	});
</script>

@endsection
