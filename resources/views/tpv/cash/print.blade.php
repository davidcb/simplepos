<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>{{ $cash->updatedAtReadable() }}</title>
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
				<p>CIERRE DE CAJA</p>
                <p class="small">{{ $cash->updatedAtReadable() }} - {{ $cash->updatedAtReadable('H:i:s') }}</p>
            </div>
            <table class="products">
                <thead>
                    <tr>
                        <th>CONCEPTO</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
					<tr>
						<td>Saldo inicial</td>
						<td>{{ number_format($cash->opening_amount, 2, ',', '.') }}€</td>
					</tr>
                    <tr>
                        <td>Ventas efectivo</td>
                        <td>{{ number_format($cash->cashAmount(), 2, ',', '.') }}€</td>
                    </tr>
                    <tr>
                        <td>Ventas tarjeta</td>
                        <td>{{ number_format($cash->cardAmount(), 2, ',', '.') }}€</td>
                    </tr>
                    <tr>
                        <td>Ventas totales</td>
                        <td>{{ number_format($cash->totalAmount(), 2, ',', '.') }}€</td>
                    </tr>
					<tr>
						<td>Saldo final</td>
						<td>{{ number_format($cash->closing_amount, 2, ',', '.') }}€</td>
					</tr>
					<tr>
						<td>Fondo de caja</td>
						<td>{{ number_format($cash->fund, 2, ',', '.') }}€</td>
					</tr>
					<tr>
						<td>Sobre</td>
						<td>{{ number_format($cash->envelope, 2, ',', '.') }}€</td>
					</tr>
                </tbody>
            </table>
			@if ($cash->opening_notes)
            <div class="payment_method">Observaciones apertura: {{ $cash->opening_notes }}</div>
			@endif
			@if ($cash->closing_notes)
            <div class="payment_method">Observaciones cierre: {{ $cash->closing_notes }}</div>
			@endif
			@if ($cash->salesman)
            <div class="payment_method">Empleado cierre: <strong>{{ $cash->salesman->name }}</strong></div>
			@endif
        </div>

        <script>
			window.print();
			window.onfocus=function(){ window.close();}
        </script>
	</body>
</html>
