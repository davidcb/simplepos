<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>{{ $sale->number() }}</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'>
		<link rel="shortcut icon" type="image/x-icon" href="/img/favicon.png" />
		<link href="https://fonts.googleapis.com/css?family=Source+Code+Pro:400,600" rel="stylesheet">
		<link href="/css/tpv.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
        <div class="print-ticket">
            <header>
                <h1><img src="{{ asset('img/logo.png') }}" /></h1>
				<p>Datos de la empresa</p>
            </header>
            <div class="info">
				<p>FACTURA SIMPLIFICADA</p>
                <p>Ticket nº: {{ $sale->number() }}</p>
				@if ($sale->sale)
                <p class="small">Ticket orig.: {{ $sale->sale->number() }}</p>
				@endif
                <p class="small">{{ $sale->updatedAtReadable() }} - {{ $sale->updatedAtReadable('H:i:s') }}</p>
            </div>
            <table class="products">
                <thead>
                    <tr>
                        <th>ARTÍCULO</th>
                        <th>PVP</th>
                        <th>CANT</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sale->products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ number_format($product->pivot->unit_price, 2, ',', '.') }}</td>
                        <td>{{ $product->pivot->amount }}</td>
                        <td>{{ number_format($product->pivot->unit_price * $product->pivot->amount * (100 - $product->pivot->discount) / 100, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="total">Total: <strong>{{ number_format($sale->total, 2, ',', '.') }}€</strong></div>
            <div class="payment_method">Forma de pago: <strong>{{ $sale->paymentMethodReadable() }}</strong></div>
			@if ($sale->payment_method == 1)
            <div class="payment_method">Entregado: <strong>{{ number_format($sale->paid_amount, 2, ',', '.') }}€</strong></div>
            <div class="payment_method">Cambio: <strong>{{ $sale->change(true) }}€</strong></div>
			@endif
			<div class="payment_method">Comerciante minorista</div>
			<div class="payment_method">Exento IGIC - Tax free</div>
			@if ($sale->salesman)
            <div class="payment_method">Le atendió: <strong>{{ $sale->salesman->name }}</strong></div>
			@endif
        </div>

        <script>
			window.print();
			window.onfocus=function(){ window.close();}
        </script>
	</body>
</html>
