@extends('layouts.app')

@section('content')

@php
    $months = ['', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
@endphp

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
                            <th>Finca</th>
                            <th>Agencia</th>
                            <th>%</th>
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
                            <td>{{ $estate->name }}</td>
                            <td>{{ $agency->name }}</td>
                            <td>{{ $agency->commission }}</td>
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

@endsection
