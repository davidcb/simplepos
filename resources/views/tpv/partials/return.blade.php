<div class="overlay-wrapper make-return">
    <a href="#" class="close-modal">cerrar</a>
    <div class="container">
    	<h2>Devolución</h2>
    	<div class="frame">
    		<form id="return" method="POST" action="{{ route('tpv.devolucion') }}">
    			{{ csrf_field() }}
                <input type="hidden" name="sale" value="{{ $sale->id }}" />
                <table>
                    <thead>
                        <tr>
                            <th style="border-left:none;">Devolver</th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Dto.</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sale->products as $product)
                        <tr>
                            <td style="border-left:none;"><input type="hidden" name="product_id" value="{{ $product->id }}"><input class="input" type="number" name="amount" value="0"></td>
                            <td>{{ $product->name }}</td>
                            <td>{{ number_format($product->pivot->unit_price, 2, ',', '.') }}€</td>
                            <td>{{ $product->pivot->amount }}</td>
                            <td>{{ $product->pivot->discount }}%</td>
                            <td>{{ number_format($product->pivot->unit_price * $product->pivot->amount * (100 - $product->pivot->discount) / 100, 2, ',', '.') }}€</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="footer">Total a devolver: <span>0,00€</span></div>
    			<button type="submit">Devolver</button>
    		</form>
    	</div>
    </div>
</div>

@section('scripts')
@parent

<script>
    $(function() {

        $('.input').on('change blur', function(e) {
            amount = parseInt($(this).parent().parent().find('td:nth-child(4)').html());

            if ($(this).val() > amount) {
                $(this).val(amount);
            } else if ($(this).val() < 0) {
                $(this).val(0);
            }

            $('#return .footer span').html(calculateTotalPrice() + '€');
        });

        $('#return').submit(function(e) {
            e.preventDefault();
            total = parseFloat($('#return .footer span').html());
            products = new Array();
            i = 0;

            $('#return table tbody tr').each(function() {
                id = $(this).find('input[name="product_id"]').val();
                priceTd = $(this).find('td:nth-child(3)');
                discountTd = $(this).find('td:nth-child(5)');
                amountTd = $(this).find('input[name="amount"]');
                price = parseFloat(priceTd.html());
                discount = parseInt(discountTd.html());
                amount = parseInt(amountTd.val());
                products[i] = [id, price, amount, discount];
                i++;
            });

            $.get("{{ route('tpv.devolucion') }}", { sale: '{{ $sale->id }}', total: total, products: products }, function(data) {
                location.replace("{{ route('tpv.home') }}");
            });
        });

        $('.overlay-wrapper.make-return .close-modal').click(function(e) {
            e.preventDefault();
            $('.overlay-wrapper.make-return').hide('fade');
        });

        $('.input').trigger('change');
    });

    calculateRowTotal = function(item) {
        amount = parseInt(item.find('.input').val());
        price = parseFloat(item.find('td:nth-child(3)').html());
        discount = parseInt(item.find('td:nth-child(5)').html());
        total = price * amount * (100 - discount) / 100;
        return total;
    };

    calculateTotalPrice = function() {
        total = 0;
        $('#return table tbody tr').each(function() {
            total += calculateRowTotal($(this));
        });
        return total.toFixed(2);
    };
</script>

@endsection
