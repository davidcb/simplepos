@extends('layouts.app')

@section('content')

<div class="container-fluid report report-salesman">
    @foreach ($salesmans as $salesman)
    <div class="row">
		<div class="col-xs-12">
            <h1>{{ $salesman->name }}</h1>
        </div>
    </div>
	<div class="row">
		<div class="col-xs-8">
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
                            <td>{{ $estate->busesAverageSales($month, $year) }}</td>
                            <td>{{ $estate->busesSales($month, $year) }}</td>
                            <td>{{ $estate->sharp() }}</td>
                            <td>{{ $estate->busesBonus($month, $year) }}%</td>
                            <td>{{ $estate->totalBusesCommission($month, $year) }}</td>
                            <td>{{ $estate->perPersonBusesCommission($month, $year) }}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
		</div>
		<div class="col-xs-4">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr class="header">
                            <th>Bono guaguas</th>
                            <th colspan="2">Bono coches</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>>13,50€ = 2%</td>
                            <td>>75€ = 2%</td>
                            <td>>80€ = 3%</td>
                        </tr>
                        <tr>
                            <td>>15,50€ = 3%</td>
                            <td>>83€ = 4%</td>
                            <td>>85€ = 5%</td>
                        </tr>
                        <tr>
                            <td>>16,50€ = 3,5%</td>
                            <td>>90€ = 6%</td>
                            <td>>94€ = 7%</td>
                        </tr>
                        <tr>
                            <td>>17,50€ = 4%</td>
                            <td>>98€ = 8%</td>
                            <td>>102€ = 9%</td>
                        </tr>
                        <tr>
                            <td>>19,50€ = 5%</td>
                            <td colspan="2">>105€ = 10%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
		</div>
	</div>
    @foreach ($salesman->activeEstates() as $estate)
    <div class="row">
        <div class="col-xs-5">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr class="header">
                            <th colspan="2">Ventas coches</th>
                            <th>{{ $estate->name }}</th>
                        </tr>
                        <tr class="header">
                            <th>Fecha</th>
                            <th>Venta</th>
                            <th>Comisión</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($salesman->monthCarsVisits($month, $year, $estate) as $visit)
                        <tr>
                            <td>{{ $visit->visitDateReadable() }}</td>
                            <td>{{ $visit->sales_total }}€</td>
                            <td>{{ $visit->carComission() }}€</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td>{{ $salesman->carsSales($month, $year, $estate) }}€</td>
                            <td>{{ $salesman->totalVisitCarsCommission($month, $year, $estate) }}€</td>
                        </tr>
                        <tr>
                            <td>Nº coches</td>
                            <td>{{ $salesman->cars($month, $year, $estate) }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Promedio</td>
                            <td>{{ $salesman->carsAverageSales($month, $year, $estate) }}€</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Venta < 18h</td>
                            <td>{{ $salesman->regularTimeCarsSales($month, $year, $estate) }}€</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Bono
                                @if($salesman->carsBonus($month, $year, $estate))
                                {{ $salesman->carsBonus($month, $year, $estate) }}%
                                @endif
                            </td>
                            <td>{{ $salesman->regularTimeCarsCommission($month, $year, $estate) }}€</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Com. > 18h</td>
                            <td>{{ $salesman->overTimeCarsCommission($month, $year, $estate) }}€</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Comisiones</td>
                            <td>{{ $salesman->totalCarsCommission($month, $year, $estate) }}€</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Horas extra</td>
                            <td>{{ $salesman->overtimePayment($month, $year, $estate) }}€</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="col-xs-5 col-xs-offset-2">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr class="header">
                            <th colspan="2">Ventas agencias</th>
                            <th>{{ $estate->name }}</th>
                        </tr>
                        <tr class="header">
                            <th>Fecha</th>
                            <th>Venta</th>
                            <th>Comisión</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($salesman->monthBusesVisits($month, $year, $estate) as $visit)
                        <tr>
                            <td>{{ $visit->visitDateReadable() }}</td>
                            <td>{{ $visit->sales_total }}€</td>
                            <td>{{ $visit->average() }}€</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td>{{ $salesman->busesSales($month, $year, $estate) }}€</td>
                            <td>{{ $salesman->busesAverage($month, $year, $estate) }}€</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Nº buses</td>
                            <td>{{ $salesman->buses($month, $year, $estate) }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{ $salesman->estatePercentage($estate) }}% Comisiones</td>
                            <td>{{ $salesman->estateBusesCommission($month, $year, $estate) }}€</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @endforeach
    <div class="col-xs-5">
        @if($salesman->manager)
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <tbody>
                    @foreach($salesman->subordinates() as $subordinate)
                    @foreach ($subordinate->activeEstates() as $estate)
                    @if ($subordinate->carsSales($month, $year, $estate) > 0)
                    <tr>
                        <td>{{ $subordinate->name }}</td>
                        <td>{{ $subordinate->carsAverageSales($month, $year, $estate) }}€</td>
                        <td>{{ $subordinate->carsSales($month, $year, $estate) }}€</td>
                        <td>
                            @if ($salesman->managerSalesmanCarsBonus($month, $year, $subordinate, $estate))
                            {{ $salesman->managerSalesmanCarsBonus($month, $year, $subordinate, $estate) }}%
                            @endif
                        </td>
                        <td>
                            @if ($salesman->managerSalesmanCarsBonus($month, $year, $subordinate, $estate))
                            {{ $salesman->managerSalesmanCarsCommission($month, $year, $subordinate, $estate) }}€
                            @endif
                        </td>
                    </tr>
                    @endif
                    @endforeach
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $salesman->managerCarsCommission($month, $year) }}€</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @endif
    </div>
    <div class="col-xs-5 col-xs-offset-2">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <tfoot>
                    <tr>
                        <td>Extras</td>
                        <td>{{ $salesman->extras }}€</td>
                    </tr>
                    @if ($salesman->plus)
                    <tr>
                        <td>Plus de transporte</td>
                        <td>{{ $salesman->plus }}€</td>
                    </tr>
                    @endif
                    <tr>
                        <td>Comisiones</td>
                        <td>{{ $salesman->totalCommission($month, $year) }}€</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>{{ $salesman->totalCommission($month, $year) + $salesman->extras + $salesman->plus }}€</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @endforeach
</div>

@endsection
