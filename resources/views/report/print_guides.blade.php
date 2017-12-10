@php
    $months = ['', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
@endphp
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Relación de comisiones guías - {{ $months[$month] }} {{ $year }}</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'>
		<link rel="shortcut icon" type="image/x-icon" href="/img/favicon.png" />
		<link href="css/reports.css" rel="stylesheet" type="text/css" />
	</head>
	<body class="skin-red fixed">

		<div class="container-fluid report report-guides">
			<div class="row">
				<div class="col-xs-12">
		            <div class="table-responsive">
		                <table class="table table-bordered table-hover">
		                    <thead>
		                        <tr class="title">
		                            <th colspan="3">Relación de comisiones guías {{ $islandText }}</th>
		                            <th>{{ $months[$month] }} {{ $year }}</th>
		                        </tr>
		                        <tr class="header">
		                            <th class="text-left">Agencia</th>
		                            <th class="text-left">Guía</th>
		                            <th class="text-left">Finca</th>
		                            <th class="text-right">Comisiones</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                        @foreach ($guides as $guide)
		                        @php
		                            $i = 0;
		                        @endphp
		                        @foreach ($guide->activeEstates($month, $year) as $estate)
		                        @if ($i++ == 0)
		                        <tr class="even">
		                            <td class="text-left">{{ $guide->agency ? $guide->agency->name : '' }}</td>
		                            <td class="text-left">{{ $guide->name }}</td>
		                            <td class="text-left">{{ $estate->name }}</td>
		                            <td class="text-right">{{ number_format($guide->commission($month, $year, $estate), 2, ',', '.') }}€</td>
		                        </tr>
		                        @else
		                        <tr class="even">
		                            <td></td>
		                            <td></td>
		                            <td class="text-left">{{ $estate->name }}</td>
		                            <td class="text-right">{{ number_format($guide->commission($month, $year, $estate), 2, ',', '.') }}€</td>
		                        </tr>
		                        @endif
		                        @endforeach
		                        <tr class="odd">
		                            <td></td>
		                            <td></td>
		                            <td></td>
		                            <td class="text-right">{{ number_format($guide->totalCommission($month, $year), 2, ',', '.') }}€</td>
		                        </tr>
		                        @endforeach
		                    </tbody>
		                    <tfoot>
		                        <tr>
		                            <td></td>
		                            <td></td>
		                            <td></td>
		                            <td class="text-right">{{ number_format($estate->totalAgencyCommissions($month, $year), 2, ',', '.') }}€</td>
		                        </tr>
		                    </tfoot>
		                </table>
		            </div>
				</div>
		    </div>
		</div>
	</body>
</html>
