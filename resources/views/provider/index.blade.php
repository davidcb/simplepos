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
				<form id="form" action="{{ url('/proveedores') }}" method="get">
					<div class="actions">
						<a href="{{ url('/nuevo-proveedor') }}">Añadir proveedor</a><span>/</span>
						<a class="delete_selected" href="{{ url('/eliminar-proveedores') }}" onclick="return confirm('¿Está seguro de que desea eliminar los proveedores seleccionados?');">Eliminar seleccionados</a>
					</div>
					<div class="table-responsive">
						<table id="example2" class="table table-bordered table-hover table-striped" aria-describedby="example2_info">
							<thead>
								<tr class="header">
									<th class="checkbox2"><input type="checkbox" id="selectAll" name="selectAll" value="1" /></th>
									<th>Nombre <a href="{{ Request::fullUrlWithQuery(['orderby' => 'name', 'sort' => 'ASC']) }}" class="asc">Ascendente</a><a href="{{ Request::fullUrlWithQuery(['orderby' => 'name', 'sort' => 'DESC']) }}" class="desc">Descendente</a></th>
									<th>Denominación social <a href="{{ Request::fullUrlWithQuery(['orderby' => 'business_name', 'sort' => 'ASC']) }}" class="asc">Ascendente</a><a href="{{ Request::fullUrlWithQuery(['orderby' => 'business_name', 'sort' => 'DESC']) }}" class="desc">Descendente</a></th>
									<th>CIF <a href="{{ Request::fullUrlWithQuery(['orderby' => 'cif', 'sort' => 'ASC']) }}" class="asc">Ascendente</a><a href="{{ Request::fullUrlWithQuery(['orderby' => 'cif', 'sort' => 'DESC']) }}" class="desc">Descendente</a></th>
									<th>Teléfono <a href="{{ Request::fullUrlWithQuery(['orderby' => 'telephone', 'sort' => 'ASC']) }}" class="asc">Ascendente</a><a href="{{ Request::fullUrlWithQuery(['orderby' => 'telephone', 'sort' => 'DESC']) }}" class="desc">Descendente</a></th>
									<th>Email <a href="{{ Request::fullUrlWithQuery(['orderby' => 'email', 'sort' => 'ASC']) }}" class="asc">Ascendente</a><a href="{{ Request::fullUrlWithQuery(['orderby' => 'email', 'sort' => 'DESC']) }}" class="desc">Descendente</a></th>
									<th>Acciones</th>
								</tr>
								<tr class="filter">
									<th></th>
									<th>
										<input type="text" name="filter_name" placeholder="Buscar por nombre" value="{{ Request::get('filter_name') }}" />
									</th>
									<th>
										<input type="text" name="filter_business_name" placeholder="Buscar por denominación social" value="{{ Request::get('filter_business_name') }}" />
									</th>
									<th>
										<input type="text" name="filter_cif" placeholder="Buscar por CIF" value="{{ Request::get('filter_cif') }}" />
									</th>
									<th></th>
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
								@foreach ($providers as $provider)
								<tr class="{{ ++$i % 2 == 0 ? 'odd' : 'even' }}">
									<td class="checkbox2"><input type="checkbox" name="selected[]" value="{{ $provider->id }}" class="check" /></td>
									<td>{{ $provider->name }}</td>
									<td>{{ $provider->business_name }}</td>
									<td>{{ $provider->cif }}</td>
									<td>{{ $provider->telephone }}</td>
									<td>{{ $provider->email }}</td>
									<td>
										<a class="edit" href="/editar-proveedor/{{ $provider->id }}">editar</a>
										<a class="delete" href="/eliminar-proveedor/{{ $provider->id }}" onclick="return confirm('¿Está seguro de que desea eliminar este proveedor?');">eliminar</a>
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
					alert('No se pudo eliminar algún proveedor por estar asociado a pedidos, pagos, compras o productos');
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
