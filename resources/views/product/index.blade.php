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
				<form id="form" action="{{ url('/productos') }}" method="get">
					<div class="actions">
						<a href="{{ url('/nuevo-producto') }}">Añadir producto</a><span>/</span>
						<a class="delete_selected" href="{{ url('/eliminar-productos') }}" onclick="return confirm('¿Está seguro de que desea eliminar los productos seleccionados?');">Eliminar seleccionados</a>
					</div>
					<div class="table-responsive">
						<table id="example2" class="table table-bordered table-hover table-striped" aria-describedby="example2_info">
							<thead>
								<tr class="header">
									<th class="checkbox2"><input type="checkbox" id="selectAll" name="selectAll" value="1" /></th>
									<th>Nombre <a href="{{ Request::fullUrlWithQuery(['orderby' => 'name', 'sort' => 'ASC']) }}" class="asc">Ascendente</a><a href="{{ Request::fullUrlWithQuery(['orderby' => 'name', 'sort' => 'DESC']) }}" class="desc">Descendente</a></th>
									<th>Precio venta <a href="{{ Request::fullUrlWithQuery(['orderby' => 'price', 'sort' => 'ASC']) }}" class="asc">Ascendente</a><a href="{{ Request::fullUrlWithQuery(['orderby' => 'price', 'sort' => 'DESC']) }}" class="desc">Descendente</a></th>
									<th>Precio origen <a href="{{ Request::fullUrlWithQuery(['orderby' => 'origin_price', 'sort' => 'ASC']) }}" class="asc">Ascendente</a><a href="{{ Request::fullUrlWithQuery(['orderby' => 'origin_price', 'sort' => 'DESC']) }}" class="desc">Descendente</a></th>
									<th>Precio aduanas <a href="{{ Request::fullUrlWithQuery(['orderby' => 'customs_price', 'sort' => 'ASC']) }}" class="asc">Ascendente</a><a href="{{ Request::fullUrlWithQuery(['orderby' => 'customs_price', 'sort' => 'DESC']) }}" class="desc">Descendente</a></th>
									<th>Precio hotel <a href="{{ Request::fullUrlWithQuery(['orderby' => 'hotel_price', 'sort' => 'ASC']) }}" class="asc">Ascendente</a><a href="{{ Request::fullUrlWithQuery(['orderby' => 'hotel_price', 'sort' => 'DESC']) }}" class="desc">Descendente</a></th>
									<th>Impuesto % <a href="{{ Request::fullUrlWithQuery(['orderby' => 'tax', 'sort' => 'ASC']) }}" class="asc">Ascendente</a><a href="{{ Request::fullUrlWithQuery(['orderby' => 'tax', 'sort' => 'DESC']) }}" class="desc">Descendente</a></th>
									<th>Activo <a href="{{ Request::fullUrlWithQuery(['orderby' => 'active', 'sort' => 'ASC']) }}" class="asc">Ascendente</a><a href="{{ Request::fullUrlWithQuery(['orderby' => 'active', 'sort' => 'DESC']) }}" class="desc">Descendente</a></th>
									<th>Acciones</th>
								</tr>
								<tr class="filter">
									<th></th>
									<th>
										<input type="text" name="filter_name" placeholder="Buscar por nombre" value="{{ Request::get('filter_name') }}" />
									</th>
									<th>
										<input type="text" class="half" name="filter_min_price" placeholder="Mín" value="{{ Request::get('filter_min_price') }}" />
										<input type="text" class="half" name="filter_max_price" placeholder="Máx" value="{{ Request::get('filter_max_price') }}" />
									</th>
									<th>
										<input type="text" class="half" name="filter_min_origin_price" placeholder="Mín" value="{{ Request::get('filter_min_origin_price') }}" />
										<input type="text" class="half" name="filter_max_origin_price" placeholder="Máx" value="{{ Request::get('filter_max_origin_price') }}" />
									</th>
									<th>
										<input type="text" class="half" name="filter_min_customs_price" placeholder="Mín" value="{{ Request::get('filter_min_customs_price') }}" />
										<input type="text" class="half" name="filter_max_customs_price" placeholder="Máx" value="{{ Request::get('filter_max_customs_price') }}" />
									</th>
									<th>
										<input type="text" class="half" name="filter_min_hotel_price" placeholder="Mín" value="{{ Request::get('filter_min_hotel_price') }}" />
										<input type="text" class="half" name="filter_max_hotel_price" placeholder="Máx" value="{{ Request::get('filter_max_hotel_price') }}" />
									</th>
									<th>
										<input type="text" class="half" name="filter_min_tax" placeholder="Mín" value="{{ Request::get('filter_min_tax') }}" />
										<input type="text" class="half" name="filter_max_tax" placeholder="Máx" value="{{ Request::get('filter_max_tax') }}" />
									</th>
									<th>
										<select name="filter_active">
											<option value=""></option>
											<option value="1" {{ Request::get('filter_active') == 1 ? 'selected' : '' }}>Sí</option>
											<option value="2" {{ Request::get('filter_active') == 2 ? 'selected' : '' }}>No</option>
										</select>
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
								@foreach ($products as $product)
								<tr class="{{ ++$i % 2 == 0 ? 'odd' : 'even' }}">
									<td class="checkbox2"><input type="checkbox" name="selected[]" value="{{ $product->id }}" class="check" /></td>
									<td>{{ $product->name }}</td>
									<td>{{ $product->price }}€</td>
									<td>{{ $product->origin_price }}€</td>
									<td>{{ $product->customs_price }}€</td>
									<td>{{ $product->hotel_price }}€</td>
									<td>{{ $product->tax }}%</td>
									<td>{{ $product->active == 1 ? 'Sí' : 'No' }}</td>
									<td>
										<a class="moveUp" href="/subir-producto/{{ $product->id }}">subir</a>
										<a class="moveDown" href="/bajar-producto/{{ $product->id }}">bajar</a>
										<a class="edit" href="/editar-producto/{{ $product->id }}">editar</a>
										<a class="delete" href="/eliminar-producto/{{ $product->id }}" onclick="return confirm('¿Está seguro de que desea eliminar este producto?');">eliminar</a>
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
					alert('No se pudo eliminar algún producto por estar asociado a presupuestos, albaranes, facturas, pedidos o movimientos');
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
