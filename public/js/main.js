$(document).ready(function () {
	$(window).bind('scroll', function() {
		var navHeight = $('.nav').position();
			if ($(window).scrollTop() > 67) {
				$('.nav').addClass('fixed');
			}
			else {
				$('.nav').removeClass('fixed');
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
		$div3.setAttribute('class','dropdown__list');
		$div2.setAttribute('class', 'dropdown__list-container');
		$(this).find('option').each(function (e) {
			const $option = this;
			const $$div = document.createElement('div');
			$$div.setAttribute('class','dropdown__list-item')
			$$div.innerText=this.innerText

			$($$div).click(function(){
				$($option).attr('selected',true)
				
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

	function closeAll(e){
		$('.dropdown__container').not(e).removeClass('active')
	}

	document.addEventListener("click", closeAll);
})
