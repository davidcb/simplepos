<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Pedido nº {{ $order->order_number }}</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'>
		<link rel="shortcut icon" type="image/x-icon" href="/img/favicon.png" />
		<!-- Theme style -->
		<link href="/css/app.css" rel="stylesheet" type="text/css" />
	</head>
	<body>

        <div class="invoice-box">
            <table cellpadding="0" cellspacing="0">
                <tr class="top">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td class="title">
                                    <img src="/img/logo.png" style="width:100%; max-width:300px;">
                                </td>

                                <td>
                                    Nº pedido: {{ $order->order_number }}<br>
                                    Fecha: {{ $order->orderDateReadable() }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr class="information">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td>
									<strong>PEDIDO</strong><br/>
                                    Datos de la empresa
                                </td>

                                <td>
                                    {{ $order->provider->name }}<br>
                                    {{ $order->provider->cif }}<br>
                                    {{ $order->provider->email }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- <tr class="heading">
                    <td>
                        Payment Method
                    </td>

                    <td>
                        Check #
                    </td>
                </tr>

                <tr class="details">
                    <td>
                        Check
                    </td>

                    <td>
                        1000
                    </td>
                </tr> -->

                <tr class="heading">
                    <td>Producto</td>
                    <td>Cantidad</td>
                </tr>

                @php
                    $total = 0;
                @endphp

                @foreach ($order->products as $product)

                <tr class="item">
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->pivot->amount }}</td>
                </tr>

                @php
                    $total += $product->pivot->amount;
                @endphp

                @endforeach

                <tr class="total">
                    <td>Total:</td>
                    <td>{{ $total }}€</td>
                </tr>
            </table>
        </div>

        <script>
            window.print();
        </script>

    </body>
</html>
