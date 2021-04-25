$(document).ready(function () {

	const checkout = $("#checkout");
	if (checkout.length > 0) {
		checkout.steps({
			headerTag: "h6",
			bodyTag: "fieldset",
			transitionEffect: "fade",
			autoFocus: true,
			titleTemplate: '<span class="step">#index#</span> #title#',
			enablePagination: false,
		})
		$(".place-order, .delivery-address").on("click", function () {
			checkout.steps("next", {});
		});
	}
	const quantityCounter = $(".quantity-counter");
	if (quantityCounter.length > 0) {
		quantityCounter.each(function () {
			let $this = $(this);
			$this.TouchSpin({
				min: $(this).attr('min'),
				max: $(this).attr('max'),
			})
			if ($this.val() == $this.attr('min')) $(this).siblings().find('.bootstrap-touchspin-down').addClass("disabled-max-min");
			if ($this.val() == $this.attr('max')) $(this).siblings().find('.bootstrap-touchspin-up').addClass("disabled-max-min");
		})
		quantityCounter.TouchSpin().on('touchspin.on.startdownspin', function () {
			var $this = $(this);
			$('.bootstrap-touchspin-up').removeClass("disabled-max-min");
			// console.log($this.attr('min'))
			if ($this.val() == $this.attr('min')) {
				$(this).siblings().find('.bootstrap-touchspin-down').addClass("disabled-max-min");
			}
			updatePrice()
		}).on('touchspin.on.startupspin', function () {
			var $this = $(this);
			$('.bootstrap-touchspin-down').removeClass("disabled-max-min");
			if ($this.val() == $this.attr('max')) {
				$(this).siblings().find('.bootstrap-touchspin-up').addClass("disabled-max-min");
			}
			updatePrice()
		});
	}
	if ($(".ecommerce-card").length > 0) {
		$(".remove-wishlist").on('click', function (e) {
			e.preventDefault();
			const $this = $(this);
			const id = $(this).data('id')
			$.post({
				url: '/removeItem',
				data: { id },
				success: function (xml, statusCode, xhr) {
					if (xhr.responseJSON && xhr.responseJSON.success === true) {
						$this.closest('.ecommerce-card').remove()
						updatePrice()
					}
				},
				error: function (xhr, statusCode) {
					console.log(xhr.responseText)
					console.log(xhr.responseJSON)
				}
			})
		})
		updatePrice()
	}
	function updatePrice() {
		let totalCount = 0,
			totalPrice = 0;
		if ($(".ecommerce-card").length === 0) {
			$("#checkout").remove()
			return;
		}
		$(".ecommerce-card").each(function (e) {
			const $input = $(this).find('input')
			const price = $input.data('price'),
				count = $input.val();
			totalCount += count;
			totalPrice += count * price
		})
		$('#totalMRP, #total').text(`$${totalPrice}`)
	}
})