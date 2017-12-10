@extends('layouts.tpv')

@section('content')

<div class="container sales">
	<div class="frame">
		<form method="GET" action="{{ route('tpv.ventas') }}">
            {{ csrf_field() }}
            <header>
            	<h2>Ventas</h2>
                <div class="search">
                    <input type="text" name="term" placeholder="Buscar..." value="{{ old('term') }}">
                    <button type="submit">Buscar</button>
                </div>
            </header>
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Nº</th>
                        <th>Fecha</th>
                        <th>Agencia</th>
                        <th>Guía</th>
                        <th>Empleado</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
					@foreach ($sales as $sale)
                    <tr>
                        <td><a class="view" href="{{ route('tpv.venta', [$sale->id]) }}">ver</a></td>
                        <td>{{ $sale->number() }}</td>
                        <td>{{ $sale->createdAtReadable() }}<br/>{{ $sale->createdAtReadable('H:i:s') }}</td>
                        <td>{{ $sale->visit ? $sale->visit->agency ? $sale->visit->agency->name : '' : '' }}</td>
                        <td>{{ $sale->visit ? $sale->visit->guide ? $sale->visit->guide->name : '' : '' }}</td>
                        <td>{{ $sale->salesman ? $sale->salesman->name : '' }}</td>
                        <td>{{ number_format($sale->total, 2, ',', '.') }}€</td>
                    </tr>
					@endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">Devoluciones: {{ number_format($returns, 2, ',', '.') }}€</td>
                        <td colspan="3">Saldo total: {{ number_format($total, 2, ',', '.') }}€</td>
                    </tr>
                </tfoot>
            </table>
		</form>
	</div>
</div>

<!-- <div class="buttons">
    <a href="#" class="export">Exportar a Excel</a>
    <a href="#" class="print">Imprimir listado</a>
</div> -->

@endsection

@section('scripts')
@parent

<script>
    $(function() {
		$('.export').click(function(e) {
			e.preventDefault();
		});

		$('.print').click(function(e) {
			e.preventDefault();
		});
    });
</script>

@endsection
