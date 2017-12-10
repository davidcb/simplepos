require('./bootstrap');
require('./jquery-ui');
require('./adminLTE');
require('./clipboard');
require('./cropper.min');
require('./dropzone');
require('./sweetalert.min');
require('./colorpicker');
require('../../../node_modules/jquery-slimscroll/jquery.slimscroll');

$('#selectAll').on('click change', function() {
	$('.check').prop('checked', this.checked);
	if (this.checked) {
		$('.check').each(function() {
			$(this).parent().parent().addClass('selected');
		});
	} else {
		$('.check').each(function() {
			$(this).parent().parent().removeClass('selected');
		});
	}
});

$('.check').on('change', function() {
	$(this).parent().parent().toggleClass('selected');
});

$.datepicker.setDefaults($.datepicker.regional['es']);
$(document).on('focus', '.datepicker', function() {
	$(this).datepicker({
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		changeMonth: true,
		changeYear: true,
		onSelect: function() {
			$(this).focus();
		}
	}).datepicker();
});
