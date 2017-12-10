<div class="overlay-wrapper discount">
    <a href="#" class="close-modal">cerrar</a>
    <div class="container">
    	<h2>% descuento para producto</h2>
    	<div class="frame">
            <div class="inputs">
                <label for="discount">Descuento:</label>
				<input type="number" name="discount" style="text-align:left;" />
            </div>
			<button>Aplicar</button>
    	</div>
    </div>
</div>

@section('scripts')
@parent

<script>
    $(function() {
        $('.overlay-wrapper.discount .close-modal').click(function(e) {
            e.preventDefault();
            $('.overlay-wrapper.discount').hide('fade');
        });

        $('.overlay-wrapper.discount button').click(function(e) {
            e.preventDefault();
            discountTd = $('.shopping-list .item.selected').find('div:nth-child(4)');
            discountTd.html($(this).parent().find('input').val() + '%');
            calculateRowTotal($('.shopping-list .item.selected'));
            updateTotalPrice();
            $('.overlay-wrapper.discount').hide('fade');
        });
    });
</script>

@endsection
