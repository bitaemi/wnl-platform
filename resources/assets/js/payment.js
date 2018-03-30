window.$ = window.jQuery = require('jquery');
let moment = require('moment');

require('moment-duration-format');

function getTimeLeft(date) {
	return moment.duration(moment(date).diff(moment(), 'seconds'), 'seconds').format('d[d] h[h] m[m] s[s]')
}

$(function () {
	let inputs         = $('.input'),
		personalData   = $('#personal-data'),
		toggleCheckbox = personalData.find('#personal-data-invoice-toggle'),
		invoiceForm    = personalData.find('#personal-data-invoice-form'),
		countdown      = $('.signups-countdown'),
		theDate        = countdown.data('start'); // ;)

	window.setInterval(function() {
		countdown.html(getTimeLeft(theDate));
	}, 1000);

	toggleCheckbox.on('change', function () {
		invoiceForm.toggleClass('show').toggleClass('hidden');
	});

	inputs.on('focus', function (event) {
		$(event.target).siblings('.text-danger').remove();
	});

	$('button.p24-submit').click(function () {
		$.ajax({
			data: {
				controller: 'PaymentAjaxController',
				method: 'setPaymentMethod',
				payment: 'online',
				sess_id: $('[name="p24_session_id"]').val()
			},
			success: function (response) {
				if (response.status == 'success') {
					$('.p24_form').submit();
				}
			}
		});
	});

	$.ajaxSetup({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		url: $('body').data('base') + '/ax',
		data: {},
		method: 'POST',
		error: function (error) {
			console.log(error);
		}
	});
});
