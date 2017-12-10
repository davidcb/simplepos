<header>
    <a class="back" href="{{ route('tpv.home') }}">volver</a>
    <a class="list" href="{{ route('tpv.ventas') }}">ventas</a>
    <a class="parked" href="{{ route('tpv.aparcadas') }}">aparcadas @if(isset($parkedSales) && sizeof($parkedSales))<span>{{ $parkedSales }}</span>@endif</a>
    <a class="moves" href="#">movimientos de efectivo</a>
    <a class="close-cash" href="{{ route('tpv.cerrar-caja') }}">cerrar caja</a>
    <a class="logout" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">cerrar sesión</a>
</header>

<!-- <div class="clockdate">
    <div class="clockdate-wrapper">
        <div class="date"></div>
        <div class="clock"></div>
    </div>
</div> -->

<form id="logout-form" action="{{ route('tpv.logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>

@section('scripts')
@parent

<script>
    $(function() {
        //startTime();

        $('header .moves').click(function(e) {
            e.preventDefault();
            $('.overlay-wrapper.moves').show('fade');
        });
    });

    /*function startTime() {
        var today = new Date();
        var hr = today.getHours();
        var min = today.getMinutes();
        var sec = today.getSeconds();
        hr = checkTime(hr);
        min = checkTime(min);
        sec = checkTime(sec);
        $(".clockdate .clock").html(hr + ":" + min + ":" + sec);

        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        var days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        var curWeekDay = days[today.getDay()];
        var curDay = today.getDate();
        var curMonth = months[today.getMonth()];
        var curYear = today.getFullYear();
        var date = curWeekDay + ", " + curDay + " " + curMonth + " " + curYear;
        $(".clockdate .date").html(date);

        var time = setTimeout(function(){ startTime() }, 500);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }*/
</script>

@endsection
