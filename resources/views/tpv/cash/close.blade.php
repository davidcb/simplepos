@extends('layouts.tpv')

@section('content')

<div class="container cash">
	<h2>Cerrar caja</h2>
	<div class="frame">
		<form method="POST" action="{{ route('tpv.cerrar-caja') }}">
			{{ csrf_field() }}
			<div class="cash-amount">Saldo inicial: <span>{{ number_format($cash->opening_amount, 2, ',', '.') }}</span>€</div>
			<div class="current">Saldo actual: <input type="text" name="closing_amount" value="{{ old('closing_amount', $cash->currentAmount()) }}" placeholder="€"></div>
			<div class="cash-amount">Ventas efectivo: <span>{{ number_format($cash->cashAmount(), 2, ',', '.') }}</span>€</div>
			<div class="current">Fondo caja: <input type="text" name="fund" value="{{ old('fund') }}" placeholder="€"></div>
			<div class="cash-amount">Ventas tarjeta: <span>{{ number_format($cash->cardAmount(), 2, ',', '.') }}</span>€</div>
			<div class="current">Sobre: <input type="text" name="envelope" value="{{ old('envelope') }}" placeholder="€"></div>
			<div class="cash-amount">Saldo caja: <span>{{ number_format($cash->currentAmount(), 2, ',', '.') }}</span>€</div>
			<div class="diff">Desfase: <span></span></div>
			<div class="notes">
				<label for="notes">Observaciones:</label>
				<textarea id="notes" name="notes">{{ old('notes') }}</textarea>
			</div>
			<button type="submit" class="my_button submit">Cerrar caja</button>
		</form>
	</div>
</div>

@endsection

@section('scripts')
@parent

<script>
    $(function() {
		$('input[name="closing_amount"]').change(function() {
			$diff = parseFloat($(this).val().replace(',', '.')) - parseFloat($('.cash-amount span').html());
			$('.diff span').html($diff.toString().replace('.', ',') + '€');
		});

		$('input[name="closing_amount"]').trigger('change');

		$('form').submit(function(e) {
			e.preventDefault();
			$.post("{{ route('tpv.cerrar-caja') }}", { _token: '{{ csrf_token() }}', closing_amount: $('input[name="closing_amount"]').val(), fund: $('input[name="fund"]').val(), envelope: $('input[name="envelope"]').val(), salesman: $('input[name="salesman"]').val(), notes: $('input[name="notes"]').val() }, function(id) {
				window.open("/imprimir-cierre/" + id, "_blank");
				location.reload();
			});
		});
    });
</script>

@endsection
