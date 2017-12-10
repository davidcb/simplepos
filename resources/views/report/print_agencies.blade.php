@php
    $months = ['', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
@endphp
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Relación de comisiones agencias {{ $islandText }} - {{ $months[$month] }} {{ $year }}</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'>
		<link rel="shortcut icon" type="image/x-icon" href="/img/favicon.png" />
		<link href="css/reports.css" rel="stylesheet" type="text/css" />
	</head>
	<body class="skin-red fixed">

        <div class="container-fluid report report-agencies">
            @foreach ($estates as $estate)
            @if ($estate->totalAgencyCommissions($month, $year))
        	<div class="row">
        		<div class="col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
        						<tr class="title">
                                    <th colspan="6">Relación de comisiones agencias {{ $estate->name }}</th>
                                    <th colspan="2">{{ $months[$month] }} {{ $year }}</th>
                                </tr>
                                <tr class="header">
                                    <th class="text-left">Finca</th>
                                    <th class="text-left">Agencia</th>
                                    <th class="text-left">%</th>
                                    <th class="text-right">Visitas</th>
                                    <th class="text-right">Pax</th>
                                    <th class="text-right">Media</th>
                                    <th class="text-right">Ventas</th>
                                    <th class="text-right">Comisiones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($estate->activeAgencies($month, $year) as $agency)
                                @if ($agency && sizeof($agency->monthVisits($month, $year, $estate)) > 0 && ($agency->commission || $agency->per_person) && (!$partial || ($partial && $agency->report)))
                                @php
                                    $count++;
                                @endphp
                                <tr>
                                    <td class="text-left">{{ $estate->name }}</td>
                                    <td class="text-left">{{ $agency->name }}</td>
                                    <td class="text-left">{{ $agency->commission }}</td>
                                    <td class="text-right">{{ sizeof($agency->monthVisits($month, $year, $estate)) }}</td>
                                    <td class="text-right">{{ $agency->monthPax($month, $year, $estate) }}</td>
                                    <td class="text-right">{{ number_format($agency->monthAverage($month, $year, $estate), 2, ',', '.') }}€</td>
                                    <td class="text-right">{{ number_format($agency->fixedMonthSales($month, $year, $estate), 2, ',', '.') }}€</td>
                                    <td class="text-right">{{ number_format($agency->fixedMonthCommission($month, $year, $estate), 2, ',', '.') }}€</td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                            @if ($count)
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right">{{ number_format($estate->totalAgencyCommissions($month, $year), 2, ',', '.') }}€</td>
                            </tfoot>
                            @endif
                        </table>
                    </div>
        		</div>
            </div>
            @endif
            @endforeach
        </div>

    </body>
</html>
