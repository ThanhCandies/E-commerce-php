(function (window, document, $) {
	'use strict';
	toastr.options = {
		timeOut: 0,
		extendedTimeOut: 0,
		tapToDismiss: false,
		closeButton: true
	}

	// Input, Select, Textarea validations except submit button
	$("input,select,textarea").not("[type=submit]").jqBootstrapValidation(
		{
			submitSuccess: function ($form, event) {
				event.preventDefault();
				const form = $('form');
				const button = $("button[type='submit']");
				const data = { ...form.serializeObject(), ajax: true };
				// console.log(form.attr('action'), form.attr('method'))
				$.ajax({
					url: form.attr('action'),
					method: form.attr('method'),
					data: JSON.stringify(form.serializeObject()),
					contentType: 'application/json; charset=utf-8',
					success: function (xml, status, xhr) {
						if (xhr.responseJSON && xhr.responseJSON["err"]) {
							for (const $key in xhr.responseJSON["err"]) {
								const helpblock = $(`input[name='${$key}']~div.help-block`)
								helpblock.parent().removeClass("validate").addClass("error")
								let text = '';
								xhr.responseJSON["err"][$key].forEach(element => {
									text += `<li>${element}</li>`;
								});
								helpblock.html(`<ul role="alert">${text}</ul>`)
							}
							return
						}
						if(xhr.responseJSON && xhr.responseJSON["redirect"]){
							// console.log(xhr.responseJSON["redirect"])
							window.location = xhr.responseJSON["redirect"];
							return;
						} else {
							toastr.error(xhr.responseText, status)
						}
					},
					error: function (xhr, status, error) {
						toastr.error(xhr.responseText, status)
						button.prop('disabled', false);
					}
				})
			}
		}
	);

})(window, document, jQuery);
