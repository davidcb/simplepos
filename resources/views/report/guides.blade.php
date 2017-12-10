@extends('layouts.app')

@section('content')

<div class="container-fluid report report-guides">
	<div class="row">
		<div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="header">
                            <th>Agencia</th>
                            <th>Guía</th>
                            <th>Finca</th>
                            <th>Comisiones</th>
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
                            <td>{{ $guide->agency ? $guide->agency->name : '' }}</td>
                            <td>{{ $guide->name }}</td>
                            <td>{{ $estate->name }}</td>
                            <td>{{ $guide->commission($month, $year, $estate) }}€</td>
                        </tr>
                        @else
                        <tr class="even">
                            <td></td>
                            <td></td>
                            <td>{{ $estate->name }}</td>
                            <td>{{ $guide->commission($month, $year, $estate) }}€</td>
                        </tr>
                        @endif
                        @endforeach
                        <tr class="odd">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{ $guide->totalCommission($month, $year) }}€</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{ $estate->totalAgencyCommissions($month, $year) }}€</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
		</div>
    </div>
</div>

@endsection
