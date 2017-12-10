@extends('layouts.app')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<ul class="list">
				<li class="header">Seleccionar informe a generar:</li>
				<li><a href="/comisiones-personal">Comisiones del personal</a></li>
	    		<li><a href="/comisiones-agencias">Comisiones de todas las agencias</a></li>
	    		<li><a href="/comisiones-guias">Comisiones de todos los guías</a></li>
	    		<li><a href="/comisiones-agencia">Comisiones de una agencia</a></li>
			</ul>
		</div>
	</div>
</div>

@endsection
