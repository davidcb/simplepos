@php
    $months = ['', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
@endphp
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Relación de comisiones {{ $agency->name }} - {{ $months[$month] }} {{ $year }}</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'>
		<link rel="shortcut icon" type="image/x-icon" href="/img/favicon.png" />
		<link href="css/reports.css" rel="stylesheet" type="text/css" />
	</head>
	<body class="skin-red fixed">

        <div class="container-fluid report report-agency">
        	<div class="row">
        		<div class="col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="title">
                                    <th colspan="6">{{ $agency->name }}</th>
                                </tr>
                                <tr class="header">
                                    <th class="text-left">Fecha</th>
                                    <th class="text-left">Guía</th>
                                    <th class="text-right">Pax</th>
                                    <th class="text-right">Venta</th>
                                    <th class="text-right">Comisión</th>
                                    <th class="text-right">Media por pax</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalPax = 0;
                                    $totalSales = 0;
                                    $totalCommission = 0;
                                    $lastDate = 0;
                                @endphp
                                @foreach ($agency->monthVisits($month, $year, $estate) as $visit)
                                @if ($visit->visit_date != $lastDate)
                                <tr>
                                    <td class="text-left">{{ $visit->visitDateReadable() }}</td>
                                    <td class="text-left">{{ $visit->guide ? $visit->guide->name : '' }}</td>
                                    <td class="text-right">{{ $visit->pax }}</td>
                                    <td class="text-right">{{ number_format($visit->fixedSales(), 2, ',', '.') }}€</td>
                                    <td class="text-right">{{ number_format($visit->fixedAgencyCommission(), 2, ',', '.') }}€</td>
                                    <td class="text-right">{{ number_format($visit->fixedAverage(), 2, ',', '.') }}€</td>
                                </tr>
                                @else
                                <tr>
                                    <td></td>
                                    <td class="text-left">{{ $visit->guide ? $visit->guide->name : '' }}</td>
                                    <td class="text-right">{{ $visit->pax }}</td>
                                    <td class="text-right">{{ number_format($visit->fixedSales(), 2, ',', '.') }}€</td>
                                    <td class="text-right">{{ number_format($visit->fixedAgencyCommission(), 2, ',', '.') }}€</td>
                                    <td class="text-right">{{ number_format($visit->fixedAverage(), 2, ',', '.') }}€</td>
                                </tr>
                                @endif
                                @php
                                    $totalPax += $visit->pax;
                                    $totalSales += $visit->fixedSales();
                                    $totalCommission += $visit->fixedAgencyCommission();
                                    $lastDate = $visit->visit_date;
                                @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-left" style="font-weight:400;">Grupos: {{ sizeof($agency->monthVisits($month, $year, $estate)) }}</td>
                                    <td class="text-left" style="font-weight:400;">SUMAS TOTALES</td>
                                    <td class="text-right" style="font-weight:400;">{{ $totalPax }}</td>
                                    <td class="text-right" style="font-weight:400;">{{ number_format($totalSales, 2, ',', '.') }}€</td>
                                    <td class="text-right" style="font-weight:400;">{{ number_format($totalCommission, 2, ',', '.') }}€</td>
                                    <td class="text-right" style="font-weight:400;">{{ number_format(round($totalSales / ($totalPax > 0 ? $totalPax : 1), 2), 2, ',', '.') }}€</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
        		</div>
            </div>
        </div>
    </body>
</html>
