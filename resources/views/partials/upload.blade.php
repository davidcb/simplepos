<div class="overlay-wrapper image">
	<div class="overlay">
		<a class="close" href="#">CERRAR</a>
		<h2>DETALLES DE LA IMAGEN</h2>

		<div class="form-group">
			<div class="col-md-12">
				<label class="control-label">Título</label><br/>
				<input type="text" class="form-control" name="title">
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-12">
				<label class="control-label">Imagen principal</label><br/>
				<input type="checkbox" name="main" value="1">
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-12">
				<a class="cutImage my_button" href="#">recortar</a>
			</div>
		</div>

		<div class="form-group buttons">
			<div class="col-md-12">
				<a href="#" class="cancel_button">Cancelar</a>
				<button class="my_button submit">Guardar</button>
			</div>
		</div>
	</div>
</div>

@section('scripts')
@parent

<script>

	$(function() {

		switch ({{ $type }}) {
			case 3: // Galería de imágenes
				$('.minigallery_{{ $number }}').dropzone({
					url: '/subirFichero',
					clickable: '.upload_button',
					maxFilesize: 4, // MB
					acceptedFiles: '.svg,.jpg,.jpeg,.png,.gif',
					init: function() {
						this.on("sending", function(file, xhr, formData) {
							formData.append("_token", "{{ csrf_token() }}");
							formData.append("module", "{{ $module }}");
							formData.append("cropType", "{{ isset($cropType) ? $cropType : null }}");
						});
					},
					complete: function(file) {
						this.removeFile(file);
					},
					success: function(file, response) {
						response = response.split('|');

						$fileDiv = '<a class="image" href="#" data-url="' + response[1] + '" data-cropType="' + response[2] + '" data-module="' + response[3] + '"><img src="/verImagen/' + response[3] + '/m_' + response[1] + '" alt="Imagen" /></a>';

						$('#{{ $formid }}').append($('<input type="hidden" name="{{ $field }}[]" value="' + response[1] + '" />'));
						$('#{{ $formid }} .minigallery_{{ $number }}').append($fileDiv);
						$('.upload_{{ $number }}').hide('fade');
					}
				});
				break;
		}

		var clicked;

		$(document).on('click', '.images-container .image', function(e) {
			e.preventDefault();
			$('.overlay-wrapper.image').show('fade');
			clicked = $(this);
			// Rellenamos el formulario con los datos de la imagen en la que hemos hecho click
			$('.overlay-wrapper.image input[name="title"]').val(clicked.attr('data-title'));
			$('.overlay-wrapper.image input[name="main"]').prop('checked', clicked.attr('data-main') == 1 ? true : false);
			$('.overlay-wrapper.image .cutImage').attr('href', '/recortarImagen/' + clicked.attr('data-module') + '/' + clicked.attr('data-url') + '/' + clicked.attr('data-cropType'));
		});

		// Cuando se le da al botón de guardar...
		$('.overlay-wrapper.image .submit').click(function(e) {
			e.preventDefault();
			// Si ya está persistido, guardamos los datos de la imagen y se los asociamos al enlace de la imagen en el dropzone.
			if (clicked.attr('data-id')) {
				clicked.attr('data-title', $('.overlay-wrapper.image input[name="title"]').val());
				clicked.attr('data-main', $('.overlay-wrapper.image input[name="main"]').is(':checked') ? 1 : 0);
				$.get('/guardarInfoImagen', {id: clicked.attr('data-id'), title: $('.overlay-wrapper.image input[name="title"]').val(), main: $('.overlay-wrapper.image input[name="main"]').is(':checked') ? 1 : 0}, function() {
					$('.overlay-wrapper.image').hide('fade');
				});
			} else {
				// TODO - Ver cómo hacer para guardar el nombre y el main si no está persistido.
				$('.overlay-wrapper.image').hide('fade');
			}
		});
		// Cuando se le da al botón de cancelar se cierra el overlay
		$('.overlay-wrapper.image .cancel_button').click(function(e) {
			e.preventDefault();
			$('.overlay-wrapper.image').hide('fade');
		});

	});
	
</script>

@endsection