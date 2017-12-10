@extends('layouts.app')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<ul class="list">
				<li class="header">Importar datos</li>
	            <li><a href="/importar/agencias">Importar agencias</a></li>
	    		<li><a href="/importar/albaranes">Importar albaranes</a></li>
	    		<li><a href="/importar/almacenes">Importar almacenes</a></li>
	    		<li><a href="/importar/clientes">Importar clientes</a></li>
	    		<li><a href="/importar/compras">Importar compras</a></li>
	    		<li><a href="/importar/facturas">Importar facturas</a></li>
	    		<li><a href="/importar/fincas">Importar fincas</a></li>
	    		<li><a href="/importar/guias">Importar guías</a></li>
	    		<li><a href="/importar/movimientos">Importar movimientos</a></li>
	    		<li><a href="/importar/pagos">Importar pagos</a></li>
	    		<li><a href="/importar/pedidos">Importar pedidos</a></li>
				<li><a href="/importar/presupuestos">Importar presupuestos</a></li>
				<li><a href="/importar/proveedores">Importar proveedores</a></li>
	    		<li><a href="/importar/vendedores">Importar vendedores</a></li>
				<li><a href="/importar/vendedores_finca">Importar vendedores-fincas</a></li>
				<li><a href="/importar/visitas">Importar visitas</a></li>
			</ul>
		</div>
	</div>
</div>

@endsection
