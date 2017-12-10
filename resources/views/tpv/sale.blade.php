@extends('layouts.tpv')

@section('content')

<div class="container sale">
    <div class="products">
        <div class="header">
            <h2>{{ $sale->number() }}</h2>
            @if ($sale->paid)
            <h3 class="ok">COBRADO - {{ $sale->createdAtReadable() }} - {{ $sale->createdAtReadable('H:i:s') }}</h3>
            @else
            <h3 class="nok">PENDIENTE - {{ $sale->createdAtReadable() }} - {{ $sale->createdAtReadable('H:i:s') }}</h3>
            @endif
        </div>
        <div class="body">
            <table>
                <thead>
                    <tr>
                        <th style="border-left:none;">Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Dto.</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sale->products as $product)
                        @if ($product->pivot->amount)
                        <tr>
                            <td style="border-left:none;">{{ $product->name }}</td>
                            <td>{{ number_format($product->pivot->unit_price, 2, ',', '.') }}€</td>
                            <td>{{ $product->pivot->amount }}</td>
                            <td>{{ $product->pivot->discount }}%</td>
                            <td>{{ number_format($product->pivot->unit_price * $product->pivot->amount * (100 - $product->pivot->discount) / 100, 2, ',', '.') }}€</td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="footer">Total: <span>{{ number_format($sale->total, 2, ',', '.') }}€</span></div>
    </div>
    <div class="details">
        <div class="total">
            <p>Total pagado:</p>
            <p>{{ $sale->paid ? number_format($sale->total, 2, ',', '.') : '0,00' }}€</p>
        </div>
        <div class="payment-method">
            <p>Forma de pago:</p>
            <p>{{ $sale->payment_method ? $sale->paymentMethodReadable() : '-' }}</p>
        </div>
        <div class="sale-buttons">
            @if ($sale->paid)
            <a class="print" href="#">Imprimir</a>
            @if ($sale->total > 0)
            <a class="return" href="#">Devolución</a>
            @endif
            @else
            <a class="recover" href="#">Recuperar</a>
            <a class="cancel" href="#">Cancelar</a>
            @endif
        </div>
    </div>
</div>

@include('tpv.partials.return')

@endsection

@section('scripts')
@parent

<script>
    $(function() {
        $('.print').click(function(e) {
            e.preventDefault();
            window.open("{{ route('tpv.imprimir-venta', $sale->id) }}", "_blank");
        });

        $('.return').click(function(e) {
            e.preventDefault();
            $('.overlay-wrapper.make-return').show('fade');
        });

        $('.recover').click(function(e) {
            e.preventDefault();
            $.get("{{ route('tpv.recuperar-venta', $sale->id) }}", {}, function(data) {
                location.replace("{{ route('tpv.home') }}");
            });
        });

        $('.cancel').click(function(e) {
            e.preventDefault();
            $.get("{{ route('tpv.cancelar-venta', $sale->id) }}", {}, function(data) {
                location.replace("{{ route('tpv.home') }}");
            });
        });
    });
</script>

@endsection
