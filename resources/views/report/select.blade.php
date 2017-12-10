@php
    $months = ['', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
@endphp

@extends('layouts.app')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="form-horizontal">
				<form id="form" action="" method="post">
					<div class="form-group">
						<div class="col-xs-12 col-md-3">
							<label class="control-label">Mes:</label>
							<select name="month" class="form-control">
		                        @for ($i = 1; $i <= 12; $i++)
		                        <option {{ old('month') == $i ? 'selected' : '' }} value="{{ $i }}">{{ $months[$i] }}</option>
		                        @endfor
		                    </select>
						</div>
						<div class="col-xs-12 col-md-3">
							<label class="control-label">Año:</label>
							<select name="year" class="form-control">
								@for ($i = date('Y'); $i >= 2014; $i--)
		                        <option {{ old('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
		                        @endfor
		                    </select>
						</div>
					</div>
					<div class="form-group">
						@if (isset($partial))
						<div class="col-xs-12 col-md-3">
							<label class="control-label">Tipo de exportación:</label>
							<select name="partial" class="form-control">
								<option value="0" {{ old('partial') == 0 ? 'selected' : '' }}>Exportar todas</option>
			                    <option value="1" {{ old('partial') == 1 ? 'selected' : '' }}>Exportar para encargado/a</option>
		                    </select>
						</div>
						@endif
						@if (!isset($agencies))
						<div class="col-xs-12 col-md-3">
							<label class="control-label">Isla:</label>
							<select name="island" class="form-control">
								<option value="">Seleccionar...</option>
		                        <option value="1" {{ old('island') == 1 ? 'selected' : '' }}>Gran Canaria</option>
		                        <option value="2" {{ old('island') == 2 ? 'selected' : '' }}>Fuerteventura</option>
		                        <option value="3" {{ old('island') == 3 ? 'selected' : '' }}>La Gomera</option>
		                    </select>
						</div>
						@endif
						@if (isset($estates))
						<div class="col-xs-12 col-md-3">
							<label class="control-label">Finca:</label>
							<select name="estate" class="form-control">
								<option value="">Seleccionar...</option>
								@foreach ($estates as $estate)
								<option value="{{ $estate->id }}" {{ old('estate') == $estate->id ? 'selected' : '' }}>{{ $estate->name }}</option>
								@endforeach
		                    </select>
						</div>
						@endif
						@if (isset($agencies))
						<div class="col-xs-12 col-md-3">
							<label class="control-label">Agencia:</label>
							<select name="agency" class="form-control">
								<option value="">Seleccionar...</option>
								@foreach ($agencies as $agency)
								<option value="{{ $agency->id }}" {{ old('agency') == $agency->id ? 'selected' : '' }}>{{ $agency->name }}</option>
								@endforeach
		                    </select>
						</div>
						@endif
					</div>
					<div class="form-group">
						<div class="col-xs-12 col-md-3">
							<button type="submit" class="my_button">Exportar</button>
						</div>
					</div>
					{{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
