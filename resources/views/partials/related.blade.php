<!--
    Parámetros:
        - products
        - inputs[label, field, pivot_field]
        - elementField (sale_id, order_id)
        - elementId (al editar)
-->

<div class="form-group">
    <div class="col-md-12">
        <label class="control-label">Productos</label>
        <input type="text" class="form-control" id="productsText" name="productsText" placeholder="Comienza a escribir el nombre de un producto para buscarlo...">
        <div class="related">
            @if (sizeof($products))
            @foreach ($products as $product)
            <div class="item">
                <p>{{ $product->name }}</p>
                <a href="#" class="deleteRelated" data-product-id="{{ $product->id }}">Eliminar</a>
                <input type="hidden" name="products[]" value="{{ $product->id }}">
                @if (sizeof($inputs))
                @foreach ($inputs as $input)
                <label>{{ $input['label'] }}<input type="text" name="{{ $input['field'] }}[]" value="{{ $product->pivot->{$input['pivot_field']} }}"></label>
                @endforeach
                @endif
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>

@section('scripts')
@parent

<script>
	$(function() {

		$('#productsText').autocomplete({
			source: function(request, response) {
				$.ajax({
					url: '/buscar-productos',
					data: {
						term: request.term,
					},
					dataType: 'jsonp',
					success: function( data ) {
						response( $.map( data, function( item ) {
							return {
								id: item.id,
								label: item.name,
								value: item.name,
								name: item.name,
								price: item.price,
							}
						}));
					}
				});
			},
			select: function(e, ui) {
                $inputs = '';
                @if (sizeof($inputs))
                    @foreach ($inputs as $input)
                        @if ($input['field'] == 'prices')
                        $inputs += '<label>{{ $input["label"] }}<input type="text" name="{{ $input["field"] }}[]" value="' + ui.item.price + '"></label>';
                        @else
                        $inputs += '<label>{{ $input["label"] }}<input type="text" name="{{ $input["field"] }}[]"></label>';
                        @endif
                    @endforeach
                @endif
				$('.related').append($('<div class="item"><p>' + ui.item.name + '</p><a href="#" class="deleteRelated" data-product-id="' + ui.item.id + '">Eliminar</a><input type="hidden" name="products[]" value="' + ui.item.id + '">' + $inputs + '</div>'));
                $(this).val(''); return false;
			}
		});

		$('.deleteRelated').click(function(e) {
			e.preventDefault();
			if (confirm('¿Estás seguro de que quieres eliminar este producto?')) {
                @if ($elementId)
				$.get('/eliminar-producto-relacionado', {product_id: $(this).attr('data-product-id'), {{ $elementField }}: {{ $elementId }}});
                @endif
				$(this).parent().remove();
			}
		});
	});
</script>

@endsection
