<div class="overlay-wrapper cropper">
	<div class="overlay">
		<form id="crop_image" action="" method="post" class="form">
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
			<input type="hidden" id="ratio" name="ratio" />
			<div>
				<p style="margin:10px 0 8px; text-align:center;">Seleccionar el área a recortar. La imagen original se conservará y se guardará una copia a una resolución de <span class="dimensions"></span> píxeles.</p>
				<div class="image_cropping">
					<img src="" alt="Imagen a recortar" title="Imagen a recortar" />
				</div>
			</div>
			<div class="clear"></div>
			<div class="elem footer" style="text-align: center;">
				<a class="cancel my_button" href="#">CANCELAR</a>
				<input class="my_button" type="submit" value="RECORTAR" />
			</div>
		</form>
	</div>
</div>

@section('scripts')
@parent
<script>
	$(function() {
		$current_image = null;
		
		$(document).on('click', '.cutImage', function(e) {
			e.preventDefault();
			url = $(this).attr('href');
			//$('#crop_image').attr('action', url);
			url = url.split('/');
			url.reverse();
			cutType = parseInt(url[0]);
			image = url[1];
			subdir = url[2];
			switch (cutType) {
				case 1:
					wid = 1220;
					hei = 541;
					break;
				case 2:
					wid = 1115;
					hei = 654;
					break;
			}
			ratio = wid / hei;
			$('#ratio').val(ratio);
			$('.image_cropping img').attr('src', '/verImagen/' + subdir + '/' + image + '/admin');
			$('.preview').attr('src', '/verImagen/' + subdir + '/w_' + image + '/admin');
			$('.dimensions').html(wid + 'x' + hei);
			$current_image = $(this).parent().parent().find('.img img');
			$('.image_cropping > img').cropper({
				aspectRatio: $('#ratio').val(),
				autoCrop: false,
				done: function(data) {
					$('#x').val(data.x);
					$('#y').val(data.y);
					$('#w').val(data.width);
					$('#h').val(data.height);
				}
			});
			$('#crop_image').attr('action', '/recortarImagen/' + subdir + '/' + image + '/' + cutType);
			$('.overlay-wrapper.cropper').show('fade');
		});
		
		$('.cancel').on('click', function(e) {
			e.preventDefault();
			$('.image_cropping > img').cropper("destroy");
			$('.overlay-wrapper.cropper').hide('fade');
		});
		
		$('#crop_image').on('submit', function(e) {
			if (checkCoords()) {
				e.preventDefault();
				$('.loader-container').fadeIn(500, function() {
					$(this).show();
				});
				$.post($('#crop_image').attr('action'), {x: $('#x').val(), y: $('#y').val(), w: $('#w').val(), h: $('#h').val(), _token: '<?php echo csrf_token(); ?>'}, function(data) {
					d = new Date();
					$current_image.attr('src', data + '?' + d.getTime());
					$('.loader-container').fadeOut(500, function() {
						$(this).hide();
					});
					$('.cancel').trigger('click');
				});
			} else {
				e.preventDefault();
			}
		});
	});
	
	function checkCoords() {
		if (parseInt($('#w').val())) {
			return true;
		}
		alert('Por favor, seleccione un área a recortar y luego presione "Recortar".');
		return false;
	};
</script>
@endsection