@extends('layouts.tpv')

@section('content')

<div class="container cash">
	<h2>Abrir caja</h2>
	<div class="frame">
		<form method="POST" action="{{ route('tpv.abrir-caja') }}">
			{{ csrf_field() }}
			<div class="cash-amount">Saldo caja: <span>{{ isset($lastCash) ? number_format($lastCash->fund, 2, ',', '.') : '0,00' }}</span>€</div>
			<div class="current">Saldo actual: <input type="text" name="opening_amount" value="{{ old('opening_amount', isset($lastCash) ? $lastCash->fund : '') }}" placeholder="€"></div>
			<div class="diff">Desfase: <span></span></div>
			<!-- <div class="radio-buttons">
				<input type="radio" id="according_1" name="according" value="1" {{ old('according') == 1 ? 'selected' : '' }} /><label for="according_1">Conforme</label>
				<input type="radio" id="according_0" name="according" value="0" {{ old('according') == 0 ? 'selected' : '' }} /><label for="according_0">No conforme</label>
			</div> -->
			<div class="notes">
				<label for="notes">Observaciones:</label>
				<textarea id="notes" name="notes">{{ old('notes') }}</textarea>
			</div>
			<button type="submit" class="my_button submit">Abrir caja</button>
		</form>
	</div>
</div>

@endsection

@section('scripts')
@parent

<script>
    $(function() {
		$('input[name="opening_amount"]').change(function() {
			$amount = $(this).val() ? $(this).val() : 0;
			$diff = parseFloat($amount.replace(',', '.')) - parseFloat($('.cash-amount span').html());
			$('.diff span').html($diff.toString().replace('.', ',') + '€');
		});

		$('input[name="opening_amount"]').trigger('change');
    });
</script>

@endsection
