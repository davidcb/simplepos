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
				<form id="form" action="{{ url('/usuarios') }}" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="actions">
						<a href="{{ url('/nuevo-usuario') }}">Añadir usuario</a><span>/</span>
						<a class="delete_selected" href="{{ url('/eliminar-usuarios') }}" onclick="return confirm('¿Está seguro de que desea eliminar los usuarios seleccionados?');">Eliminar seleccionados</a>
					</div>
					<div class="table-responsive">
						<table id="example2" class="table table-bordered table-hover table-striped" aria-describedby="example2_info">
							<thead>
								<tr class="header">
									<th class="checkbox2"><input type="checkbox" id="selectAll" name="selectAll" value="1" /></th>
									<th>Nombre <a href="{{ Request::fullUrlWithQuery(['orderby' => 'name', 'sort' => 'ASC']) }}" class="asc">Ascendente</a><a href="{{ Request::fullUrlWithQuery(['orderby' => 'name', 'sort' => 'DESC']) }}" class="desc">Descendente</a></th>
									<th>Email <a href="{{ Request::fullUrlWithQuery(['orderby' => 'email', 'sort' => 'ASC']) }}" class="asc">Ascendente</a><a href="{{ Request::fullUrlWithQuery(['orderby' => 'email', 'sort' => 'DESC']) }}" class="desc">Descendente</a></th>
									<th>Tipo <a href="{{ Request::fullUrlWithQuery(['orderby' => 'role', 'sort' => 'ASC']) }}" class="asc">Ascendente</a><a href="{{ Request::fullUrlWithQuery(['orderby' => 'role', 'sort' => 'DESC']) }}" class="desc">Descendente</a></th>
									<th>Acciones</th>
								</tr>
								<tr class="filter">
									<th></th>
									<th>
										<input type="text" name="filter_name" placeholder="Buscar por nombre" value="{{ Request::get('filter_name') }}" />
									</th>
									<th>
										<input type="text" name="filter_email" placeholder="Buscar por email" value="{{ Request::get('filter_email') }}" />
									</th>
									<th>
										<select name="filter_role">
											<option value=""></option>
											<option value="1" {{ Request::get('filter_role') == 1 ? 'selected' : '' }}>Vendedor</option>
											<option value="2" {{ Request::get('filter_role') == 2 ? 'selected' : '' }}>Administrador</option>
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
								@foreach ($users as $user)
								<tr class="{{ ++$i % 2 == 0 ? 'odd' : 'even' }}">
									<td class="checkbox2"><input type="checkbox" name="selected[]" value="{{ $user->id }}" class="check" /></td>
									<td>{{ $user->name }}</td>
									<td>{{ $user->email }}</td>
									<td>{{ $user->role == 1 ? 'Vendedor' : 'Administrador' }}</td>
									<td>
										<a class="edit" href="/editar-usuario/{{ $user->id }}">editar</a>
										<a class="delete" href="/eliminar-usuario/{{ $user->id }}" onclick="return confirm('¿Está seguro de que desea eliminar este usuario?');">eliminar</a>
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
