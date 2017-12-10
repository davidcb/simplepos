@php
    $months = ['', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
@endphp
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Relación de comisiones vendedores {{ $islandText }} - {{ $months[$month] }} {{ $year }}</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'>
		<link rel="shortcut icon" type="image/x-icon" href="/img/favicon.png" />
		<link href="css/reports.css" rel="stylesheet" type="text/css" />
	</head>
	<body class="skin-red fixed">

        <div class="container-fluid report report-salesman">
            @for ($i = 0, $n = sizeof($salesmans); $i < $n; $i++)
            <div class="row">
        		<div class="col-xs-12">
                    <h4>{{ $salesmans[$i]->name }}</h4>
                </div>
            </div>
        	<div class="row">
        		<div class="col-xs-7">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr class="header">
                                    <th></th>
                                    <th>Buses</th>
                                    <th>Media</th>
                                    <th>Ventas</th>
                                    <th>#</th>
                                    <th>Bono</th>
                                    <th>A repartir</th>
                                    <th>Comisión</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($estates as $estate)
                                @if ($estate->buses($month, $year) > 0)
                                <tr>
                                    <td>{{ $estate->name }}</td>
                                    <td>{{ $estate->buses($month, $year) }}</td>
                                    <td>{{ number_format($estate->busesAverageSales($month, $year), 2, ',', '.') }}</td>
                                    <td>{{ number_format($estate->busesSales($month, $year), 2, ',', '.') }}</td>
                                    <td>{{ number_format($estate->sharp(), 2, ',', '.') }}</td>
                                    <td>{{ $estate->busesBonus($month, $year) }}%</td>
                                    <td>{{ number_format($estate->totalBusesCommission($month, $year), 2, ',', '.') }}</td>
                                    <td>{{ number_format($estate->perPersonBusesCommission($month, $year), 2, ',', '.') }}</td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
        		</div>
        		<div class="col-xs-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped thin">
                            <thead>
                                <tr class="header">
                                    <th>Bono guaguas</th>
                                    <th colspan="2">Bono coches</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>&gt;13,50€ = 2%</td>
                                    <td>&gt;75€ = 2%</td>
                                    <td>&gt;80€ = 3%</td>
                                </tr>
                                <tr>
                                    <td>&gt;15,50€ = 3%</td>
                                    <td>&gt;83€ = 4%</td>
                                    <td>&gt;85€ = 5%</td>
                                </tr>
                                <tr>
                                    <td>&gt;16,50€ = 3,5%</td>
                                    <td>&gt;90€ = 6%</td>
                                    <td>&gt;94€ = 7%</td>
                                </tr>
                                <tr>
                                    <td>&gt;17,50€ = 4%</td>
                                    <td>&gt;98€ = 8%</td>
                                    <td>&gt;102€ = 9%</td>
                                </tr>
                                <tr>
                                    <td>&gt;19,50€ = 5%</td>
                                    <td colspan="2" class="text-center">&gt;105€ = 10%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
        		</div>
        	</div>
                @foreach ($salesmans[$i]->activeEstates() as $estate)
                <div class="row">
                    <div class="col-xs-7">
                        @if (sizeof($salesmans[$i]->monthCarsVisits($month, $year, $estate)))
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr class="header">
                                        <th colspan="2">Ventas coches</th>
                                        <th>{{ $estate->name }}</th>
                                    </tr>
                                    <tr class="header">
                                        <th class="text-left">Fecha</th>
                                        <th class="text-right">Venta</th>
                                        <th class="text-right">Comisión</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($salesmans[$i]->monthCarsVisits($month, $year, $estate) as $visit)
                                    <tr>
                                        <td class="text-left">{{ $visit->visitDateReadable() }}</td>
                                        <td class="text-right">{{ number_format($visit->sales_total, 2, ',', '.') }}€</td>
                                        <td class="text-right">{{ number_format($visit->carComission(), 2, ',', '.') }}€</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td class="text-right">{{ number_format($salesmans[$i]->carsSales($month, $year, $estate), 2, ',', '.') }}€</td>
                                        <td class="text-right">{{ number_format($salesmans[$i]->totalVisitCarsCommission($month, $year, $estate), 2, ',', '.') }}€</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">Nº coches</td>
                                        <td class="text-right">{{ $salesmans[$i]->cars($month, $year, $estate) }}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">Promedio</td>
                                        <td class="text-right">{{ number_format($salesmans[$i]->carsAverageSales($month, $year, $estate), 2, ',', '.') }}€</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">Venta < 18h</td>
                                        <td class="text-right">{{ number_format($salesmans[$i]->regularTimeCarsSales($month, $year, $estate), 2, ',', '.') }}€</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">Bono
                                            @if($salesmans[$i]->carsBonus($month, $year, $estate))
                                            {{ $salesmans[$i]->carsBonus($month, $year, $estate) }}%
                                            @endif
                                        </td>
                                        <td class="text-right">{{ number_format($salesmans[$i]->regularTimeCarsCommission($month, $year, $estate), 2, ',', '.') }}€</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">Com. > 18h</td>
                                        <td class="text-right">{{ number_format($salesmans[$i]->overTimeCarsCommission($month, $year, $estate), 2, ',', '.') }}€</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">Comisiones</td>
                                        <td class="text-right">{{ number_format($salesmans[$i]->totalCarsCommission($month, $year, $estate), 2, ',', '.') }}€</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">Horas extra</td>
                                        <td class="text-right">{{ number_format($salesmans[$i]->overtimePayment($month, $year, $estate), 2, ',', '.') }}€</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        @endif
                    </div>
                    <div class="col-xs-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr class="header">
                                        <th colspan="2">Ventas agencias</th>
                                        <th>{{ $estate->name }}</th>
                                    </tr>
                                    <tr class="header">
                                        <th>Fecha</th>
                                        <th class="text-right">Venta</th>
                                        <th class="text-right">Comisión</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($salesmans[$i]->monthBusesVisits($month, $year, $estate) as $visit)
                                    <tr>
                                        <td>{{ $visit->visitDateReadable() }}</td>
                                        <td class="text-right">{{ number_format($visit->sales_total, 2, ',', '.') }}€</td>
                                        <td class="text-right">{{ number_format($visit->average(), 2, ',', '.') }}€</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-right">{{ number_format($salesmans[$i]->busesSales($month, $year, $estate), 2, ',', '.') }}€</td>
                                        <td class="text-right">{{ number_format($salesmans[$i]->busesAverage($month, $year, $estate), 2, ',', '.') }}€</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-right">Nº buses</td>
                                        <td class="text-right">{{ $salesmans[$i]->buses($month, $year, $estate) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-right">{{ $salesmans[$i]->estatePercentage($estate) }}% Comisiones</td>
                                        <td class="text-right">{{ number_format($salesmans[$i]->estateBusesCommission($month, $year, $estate), 2, ',', '.') }}€</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                @endforeach
            <div class="row">
                <div class="col-xs-7">
                    @if($salesmans[$i]->manager)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <tbody>
                                @foreach($salesmans[$i]->subordinates() as $subordinate)
                                @foreach ($subordinate->activeEstates() as $estate)
                                @if ($subordinate->carsSales($month, $year, $estate) > 0)
                                <tr>
                                    <td>{{ $subordinate->name }}</td>
                                    <td class="text-right">{{ number_format($subordinate->carsAverageSales($month, $year, $estate), 2, ',', '.') }}€</td>
                                    <td class="text-right">{{ number_format($subordinate->carsSales($month, $year, $estate), 2, ',', '.') }}€</td>
                                    <td class="text-right">
                                        @if ($salesmans[$i]->managerSalesmanCarsBonus($month, $year, $subordinate, $estate))
                                        {{ $salesmans[$i]->managerSalesmanCarsBonus($month, $year, $subordinate, $estate) }}%
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if ($salesmans[$i]->managerSalesmanCarsBonus($month, $year, $subordinate, $estate))
                                        {{ number_format($salesmans[$i]->managerSalesmanCarsCommission($month, $year, $subordinate, $estate), 2, ',', '.') }}€
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right">{{ number_format($salesmans[$i]->managerCarsCommission($month, $year), 2, ',', '.') }}€</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @endif
                </div>
                <div class="col-xs-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <tfoot>
                                <tr>
                                    <td>Extras</td>
                                    <td class="text-right">{{ number_format($salesmans[$i]->extras, 2, ',', '.') }}€</td>
                                </tr>
                                @if ($salesmans[$i]->plus)
                                <tr>
                                    <td>Plus de transporte</td>
                                    <td class="text-right">{{ number_format($salesmans[$i]->plus, 2, ',', '.') }}€</td>
                                </tr>
                                @endif
                                <tr>
                                    <td>Comisiones</td>
                                    <td class="text-right">{{ number_format($salesmans[$i]->totalCommission($month, $year), 2, ',', '.') }}€</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td class="text-right">{{ number_format($salesmans[$i]->totalCommission($month, $year) + $salesmans[$i]->extras + $salesmans[$i]->plus, 2, ',', '.') }}€</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
                @if ($i + 1 < $n)
                <div class="page-break"></div>
                @endif
            @endfor
        </div>
    </body>
</html>
