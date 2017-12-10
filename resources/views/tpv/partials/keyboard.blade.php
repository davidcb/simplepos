<div class="keyboard">
    <a class="key" href="#">7</a>
    <a class="key" href="#">8</a>
    <a class="key" href="#">9</a>
    <a class="key clear" href="#">C</a>
    <a class="key" href="#">4</a>
    <a class="key" href="#">5</a>
    <a class="key" href="#">6</a>
    <a class="key" href="#">1</a>
    <a class="key" href="#">2</a>
    <a class="key" href="#">3</a>
    <a class="key enter" href="#">Enter</a>
    <a class="key doublezero" href="#">00</a>
    <a class="key" href="#">0</a>
    <a class="key" href="#">,</a>
</div>

@section('scripts')
@parent

<script>
    $(function() {
        $('.key').click(function(e) {
            e.preventDefault();

            if ($(this).hasClass('clear')) {
                simulateKeyPress(8);
            } else if ($(this).hasClass('enter')) {
                simulateKeyPress(13);
            } else if ($(this).hasClass('doublezero')) {
                simulateKeyPress('0'.charCodeAt(0));
                simulateKeyPress('0'.charCodeAt(0));
            } else {
                k = $(this).html().charCodeAt(0);
                simulateKeyPress(k);
            }
        });

        $(document).on('fake:keypress', function(e) {
            if (e.which == 13) {
                $('.ean form').submit();
            } else if (e.which == 8) {
                $('.ean input').val($('.ean input').val().slice(0, -1));
            } else {
                $('.ean input').val($('.ean input').val() + String.fromCharCode(e.which));
            }
        });
    });

    function simulateKeyPress(character) {
        $.event.trigger({ type: 'fake:keypress', which: character });
    }
</script>

@endsection
