@if (isset($openCash))
<div class="overlay-wrapper moves">
    <a href="#" class="close-modal">cerrar</a>
    <div class="container">
    	<h2>Movimientos de efectivo</h2>
    	<div class="frame">
    		<form method="POST" action="{{ route('tpv.movimiento-efectivo') }}">
    			{{ csrf_field() }}
                <input type="hidden" name="cash" value="{{ $openCash->id }}" />
    			<div class="concept">
                    <label for="concept">Concepto:</label>
                    <input type="text" id="concept" name="concept" value="{{ old('concept') }}">
                </div>
                <div class="inputs">
                    <label for="income">Ingreso:</label>
    				<input type="text" id="income" name="income" value="{{ old('income') }}" placeholder="€">
    				<input type="text" id="withdrawal" name="withdrawal" value="{{ old('withdrawal') }}" placeholder="€">
                    <label for="withdrawal">Retirada:</label>
                </div>
    			<div class="notes">
    				<label for="notes">Observaciones:</label>
    				<textarea id="notes" name="notes">{{ old('notes') }}</textarea>
    			</div>
    			<button type="submit" class="my_button submit">Aceptar</button>
    		</form>
    	</div>
    </div>
</div>
@endif

@section('scripts')
@parent

<script>
    $(function() {
        $('.overlay-wrapper.moves .close-modal').click(function(e) {
            e.preventDefault();
            $('.overlay-wrapper.moves').hide('fade');
        });
    });
</script>

@endsection
