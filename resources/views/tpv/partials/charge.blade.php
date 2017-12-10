<div class="overlay-wrapper charge-sale">
    <a href="#" class="close-modal">cerrar</a>
    <div class="container">
    	<h2>Cobrar</h2>
    	<div class="frame">
    		<form id="charge" method="GET" action="{{ route('tpv.guardar-venta') }}">
    			{{ csrf_field() }}
                @if ($sale)
                <input type="hidden" name="sale" value="{{ $sale->id }}" />
                @endif
                <div class="total">Importe total: <span>0,00€</span></div>
                <p>Método de pago</p>
                <div class="radio-buttons">
    				<input type="radio" id="payment_method_1" name="payment_method" value="1" /><label for="payment_method_1">Efectivo</label>
    				<input type="radio" id="payment_method_2" name="payment_method" value="2" /><label for="payment_method_2">Tarjeta</label>
    			</div>
                <div class="amount">Pago: <input type="text" name="paid_amount" placeholder="€"></div>
                <div class="diff">Cambio: <span>0,00</span>€</div>
    			<button type="submit">Cobrar</button>
    		</form>
    	</div>
    </div>
</div>

@section('scripts')
@parent

<script>
    $(function() {
        $('.overlay-wrapper.charge-sale .close-modal').click(function(e) {
            e.preventDefault();
            $('.overlay-wrapper.charge-sale').hide('fade');
        });

        $('.overlay-wrapper.charge-sale #charge').submit(function(e) {
            e.preventDefault();
            total = parseFloat($('.total_price').html());
            products = new Array();
            i = 0;
            $('.item').each(function() {
                id = $(this).attr('data-id');
                priceTd = $(this).find('div:nth-child(3)');
                discountTd = $(this).find('div:nth-child(4)');
                amountTd = $(this).find('div:nth-child(5)');
                price = parseFloat(priceTd.html());
                discount = parseInt(discountTd.html());
                amount = parseInt(amountTd.html());
                products[i] = [id, price, amount, discount];
                i++;
            });
            $.get("{{ route('tpv.guardar-venta') }}", { total: total, products: products, paid_amount: $('input[name="paid_amount"]').val(), payment_method: $('input[name="payment_method"]:checked').val(), sale: '{{ isset($sale) ? $sale->id : '' }}' }, function(id) {
                window.open("/imprimir-venta/" + id, "_blank");
                location.reload();
            });
        });

        $('.overlay-wrapper.charge-sale input[type="radio"]').change(function() {
            if ($(this).is(':checked')) {
                if ($(this).val() == 1) {
                    $('.overlay-wrapper.charge-sale .amount, .overlay-wrapper.charge-sale .diff').show();
                } else {
                    $('.overlay-wrapper.charge-sale .amount, .overlay-wrapper.charge-sale .diff').hide();
                }
            }
        });

        $('.overlay-wrapper.charge-sale .amount input').on('change keydown keyup', function() {
            diff = parseFloat($(this).val()) - parseFloat($('.total_price').html());
            $('.overlay-wrapper.charge-sale .diff span').html(diff.toFixed(2));
        });

        $('.overlay-wrapper.charge-sale input[type="radio"]').trigger('change');
    });
</script>

@endsection
