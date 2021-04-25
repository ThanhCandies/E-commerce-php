let carts ={};
$(document).ready(function () {
	$(window).bind('scroll', function () {
		var navHeight = $('.nav').position();
		if ($(window).scrollTop() > 80) {
			$('.nav').parent('div').addClass('fixed');
		}
		else {
			$('.nav').parent('div').removeClass('fixed');
		}
	});

	$('.dropdown__container').each(function (e) {
		let a = 0;
		const $select = $(this).find('select')
		const text = $select.children('option:selected').text();
		const $div = $(`<div>${text}</div>`).addClass('dropdown__selected');

		const $div2 = document.createElement('div');
		const $div3 = document.createElement('div');
		$div3.appendChild($div2);
		$div3.setAttribute('class', 'dropdown__list');
		$div2.setAttribute('class', 'dropdown__list-container');
		$(this).find('option').each(function (e) {
			const $option = this;
			const $$div = document.createElement('div');
			$$div.setAttribute('class', 'dropdown__list-item')
			$$div.innerText = this.innerText

			$($$div).click(function () {
				$($option).attr('selected', true)

				$div.text(this.innerText)

			})
			$div2.appendChild($$div)
		})


		$(this).prepend($div3, $div);
		$(this).on('click', function (e) {
			e.stopPropagation();
			closeAll(this)
			$(this).toggleClass("active")
		})
	})

	function closeAll(e) {
		$('.dropdown__container').not(e).removeClass('active')
	}

	document.addEventListener("click", closeAll);
	if ($("#slider li").length > 0) {
		$("#slider").lightSlider({
			item: 6,
			loop: true,
			auto:true,
			pause:5000,
			slideMove: 2,
			mode: "slide",
			easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
			speed: 1000,
			pauseOnHover:true,
			pager:false,
			responsive: [
				
				{
					breakpoint: 1280,
					settings: {
						item: 5,
						slideMove: 1,
						slideMargin: 6,
					}
				},
				{
					breakpoint: 1100,
					settings: {
						item: 4,
						slideMove: 1,
						slideMargin: 6,
					}
				},
				{
					breakpoint: 800,
					settings: {
						item: 3,
						slideMove: 1,
						slideMargin: 6,
					}
				},
				{
					breakpoint: 650,
					settings: {
						item: 2,
						slideMove: 1
					}
				}
			]
		})
	}

	$(".cart, .cart__add").on('click',function(e){
		e.preventDefault();
		const id = $(this).data('id')
		$.post({
			url:'/addCart',
			data:{ id},
			success:function(xml,statusCode,xhr){
				console.log(xhr.responseText)
				console.log(xhr.responseJSON)
			},
			error:function(xhr,statusCode){
				console.log(xhr.responseText)
				console.log(xhr.responseJSON)
			}
		})
	})





})
