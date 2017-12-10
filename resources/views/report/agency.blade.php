@extends('layouts.app')

@section('content')

<div class="container-fluid report report-agency">
    <div class="row">
        <div class="col-xs-12">
            <h1>{{ $agency->name }}</h1>
        </div>
    </div>
	<div class="row">
		<div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="header">
                            <th>Fecha</th>
                            <th>Guía</th>
                            <th>Pax</th>
                            <th>Venta</th>
                            <th>Comisión</th>
                            <th>Media por pax</th>
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
                            <td>{{ $visit->visitDateReadable() }}</td>
                            <td>{{ $visit->guide ? $visit->guide->name : '' }}</td>
                            <td>{{ $visit->pax }}</td>
                            <td>{{ $visit->fixedSales() }}€</td>
                            <td>{{ $visit->fixedAgencyCommission() }}€</td>
                            <td>{{ $visit->fixedAverage() }}€</td>
                        </tr>
                        @else
                        <tr>
                            <td></td>
                            <td>{{ $visit->guide ? $visit->guide->name : '' }}</td>
                            <td>{{ $visit->pax }}</td>
                            <td>{{ $visit->fixedSales() }}€</td>
                            <td>{{ $visit->fixedAgencyCommission() }}€</td>
                            <td>{{ $visit->fixedAverage() }}€</td>
                        </tr>
                        @endif
                        @php
                            $totalPax += $visit->pax;
                            $totalSales += $visit->fixedSales();
                            $totalCommission += $visit->fixedAgencyCommission();
                            $lastDate = $visit->visit_date;
                        @endphp
                        @endforeach
                        <tr class="odd">
                            <td>Grupos: {{ sizeof($agency->monthVisits($month, $year, $estate)) }}</td>
                            <td>SUMAS TOTALES</td>
                            <td>{{ $totalPax }}</td>
                            <td>{{ $totalSales }}€</td>
                            <td>{{ $totalCommission }}€</td>
                            <td>{{ round($totalSales / ($totalPax > 0 ? $totalPax : 1), 2) }}€</td>
                        </tr>
                    </tbody>
                </table>
            </div>
		</div>
    </div>
</div>

@endsection
