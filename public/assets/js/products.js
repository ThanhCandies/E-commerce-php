Dropzone.autoDiscover = false

$(document).ready(function () {
	"use strict";

	toastr.options = {
		timeOut: 0,
		closeOnHover: false,
		tapToDismiss: false,
		closeButton: true,
	}

	var dataThumbView = $(".data-thumb-view")
		.on('xhr.dt', function (e, settings, json, xhr) {
			console.log(e)
			console.log(settings)
			console.log(json)
			if (!json) return toastr.error(xhr.responseText)
			const text = xhr.responseJSON;
			// console.log(text.stmt.queryString)
			// toastr.error(xhr.responseText);
		}).DataTable({
			responsive: true,
			processing: true,
			serverSide: true,
			searchDelay: 1000,
			ajax: {
				url: '/api/products',
				contentType: 'application/json; charset=UTF-8',
				data: function (params) {
					// Handle request here!
					params.page = params.start / params.length + 1;

					params.name = params.search.value;


					let obj = {};
					params.sort_by = params.order.map(({ column, dir }) => {
						const key = params.columns[column].data;
						obj[key] = dir;
					})
					params.sort_by = obj
					console.log(params)
				},
				dataSrc: function (json) {
					// Handle response here
					// console.log(json)
					return json.data
				},
			},

			order: [[3, "asc"]],
			dom:
				'<"top"<"actions action-btns"B><"action-filters"lf>><"clear">rt<"bottom"<"actions">ip>',
			oLanguage: {
				sLengthMenu: "_MENU_",
				sSearch: ""
			},
			aLengthMenu: [[4, 10, 15, 20], [4, 10, 15, 20]],
			select: {
				style: "multi"
			},
			bInfo: true,
			pageLength: 4,
			buttons: [
				{
					text: "<i class='feather icon-plus'></i> Add New",
					action: function () {
						$(this).removeClass("btn-secondary")
						$('#create_form').attr('method', 'POST')
						$(".dropzone").addClass("d-none")
						$('.add-data-btn').children('button').text('Add Data')
						$(".add-new-data").addClass("show")
						$(".overlay-bg").addClass("show")
					},
					className: "btn-outline-primary"
				}
			],
			columnDefs: [
				{ targets: [0, 1, 7], orderable: false },
				{ orderable: false, targets: 0, checkboxes: { selectRow: true } },
				{ className: 'product-img', targets: 1 },
				{ className: 'product-name', targets: 2 },
				{ className: 'product-category', targets: 3 },
				{ className: 'product-price', targets: 6 },
				{ className: 'product-action', targets: 7 },
			],
			columns: [
				{ data: null },
				{
					data: 'images',
					render: (data, type, row) => {
						if (data && data.length > 0) {
							const link = data[0].url
							return `<img src="${link}" alt="Img placeholder">`
						} else {
							'<img src="/app-assets/images/elements/apple-watch.png" alt="Img placeholder">'
						}
					},
					defaultContent: '<img src="/app-assets/images/elements/apple-watch.png" alt="Img placeholder">'
				},
				{ data: 'name' },
				{ data: 'category.name' },
				{
					data: null,
					defaultContent: "not setted"
				},
				{
					data: 'published',
					render: function (data, type, row) {
						const status = data ? "Published" : "Unpublish"
						const color = data ? "success" : "danger"
						return `
										<div class="chip chip-${color}">
												<div class="chip-body">
														<div class="chip-text">${status}</div>
												</div>
										</div>`
					}
				},
				{ data: 'price' },
				{
					data: null,
					"render": function (data, type, row) {
						return `<span class="action-edit" data-id-product="${row.id}">
										<i class="feather icon-edit"></i>
									</span>
									<span class="action-delete" data-id-product="${row.id}">
										<i class="feather icon-trash"></i>
									</span>`
					},
				},
			],
			initComplete: function (settings, json) {
				$(".dt-buttons .btn").removeClass("btn-secondary")
				$('[data-role="delete-list"]').on('click', async function (e) {
					e.preventDefault();
					let listDelete = []
					$.each(dataThumbView.rows({ selected: true }).data(), function (e) {
						listDelete.push(this.id)
					})
					if (!listDelete.length) return;
					const result = await isDelete();
					if (!result) return;

					$.ajax({
						url: '/admin/products/delete',
						method: 'delete',
						data: {
							id: listDelete
						},
						success: function (xml, textStatus, xhr) {
							deleteSuccess();
							setTimeout(() => { dataThumbView.ajax.reload(null, false) }, 1000)
						},
						error: function (xhr, textStatus) {
							alertError('Something wrong!! please try again.')
						},
					})

				})
			}
		})

	dataThumbView.on('draw.dt', function () {
		const $this = this;
		setTimeout(function () {
			if (navigator.userAgent.indexOf("Mac OS X") != -1) {
				$(".dt-checkboxes-cell input, .dt-checkboxes").addClass("mac-checkbox")
			}
		}, 50);

		// On Edit
		$('.action-edit').on("click", function (e) {
			e.stopPropagation();
			$(".dropzone").removeClass("d-none")
			$('#create_form').attr('method', 'PUT')

			$('#header_table').text('Edit product')
			$('.add-data-btn').children('button').text('Save Change')
			$('.add-data-btn').children('button').removeAttr('disabled')

			$('#data-name').val('Altec Lansing - Bluetooth Speaker');
			$('#data-price').val('99');
			$(".add-new-data").addClass("show");
			$(".overlay-bg").addClass("show");
		});

		// On Delete
		$('.action-delete').on("click", async function (e) {
			const $button = $(this)
			e.stopPropagation();
			const result = await isDelete();
			if (!result) return;
			// call ajax here!
			$button.closest('td').parent('tr').fadeOut();
			deleteSuccess();
			setTimeout(() => {
				dataThumbView.ajax.reload();
			}, 1000)
		});
	});

	// To append actions dropdown before add new button
	var actionDropdown = $(".actions-dropodown")
	actionDropdown.insertBefore($(".top .actions .dt-buttons"))

	// Scrollbar
	if ($(".data-items").length > 0) {
		new PerfectScrollbar(".data-items", { wheelPropagation: false })
	}

	// Close sidebar
	$(".hide-data-sidebar, .cancel-data-btn, .overlay-bg").on("click", function () {
		$(".add-new-data").removeClass("show")
		$(".overlay-bg").removeClass("show")
		$("#data-name, #data-price").val("")
		$('#header_table').text('Add new product')
		$("#data-category, #data-status").prop("selectedIndex", 0)
	})

	const formData = new FormData();

	var $dropzone = $(".dropzone").dropzone({
		url: '/upload/images',
		method: 'POST',
		paramName: 'images',
		maxFilesize: 5, // MB
		addRemoveLinks: true,
		maxFiles: 1,
		acceptedFiles: 'image/*',
		uploadMultiple: false,
		autoQueue: false,
		autoProcessQueue: false,
		error: function (file, response) {
			console.log(response);
			if (response.err) {

				toastr.error(response.message, 'Inconceivable!')
			}
		},
		success: function success(file, response) {
			file.previewElement.classList.add("dz-success");
			toastr.success(response, 'Inconceivable!')
		},
		init: function () {
			this.on('addedfile', function (file) {
				formData.append('images', file);
			})

			$(".hide-data-sidebar, .cancel-data-btn, .overlay-bg").on(
				"click",
				async function () {
					let list_id = []
					$.each($('.dz-add-new'), function (file) {
						list_id.push($(this).data('dzRemove'))
					})
					if (list_id.length) {
						await deleteImage(list_id)
					}
					// resetAll()
				}
			)
		}
	});
	$('#create_form').on('submit', function (e) {
		e.preventDefault();

		// var myDropzone = Dropzone.forElement(".dropzone");
		// myDropzone.options.method = "PUT"
		$('#create_form input[name],#create_form select[name]').each(function (index, element) {
			formData.append(element.name, element.value);
		})

		$.ajax({
			url: '/admin/products',
			method: 'POST',
			processData: false,
			contentType: false,
			data: formData,
			success: function (xml, status, xhr) {
				const response = xhr.responseJSON;
				if (!response.success) {
					let message = '';
					for (let key in response.error) {
						message += response.error[key] + "<br>";
					}

					return toastr.error(message, 'Error')
				};

				toastr.success(xml, 'success');
				$(".add-new-data").removeClass("show")
				$(".overlay-bg").removeClass("show")
				$("#data-name, #data-price").val("")
				$('#header_table').text('Add new product')
				$("#data-category, #data-status").prop("selectedIndex", 0)
			},
			error: function (xhr, textStatus) {
				toastr.error(xhr.responseText, 'err')
			}
		})

		// console.log('click submit');
		// $(this).submit();
		// myDropzone.processQueue();
		// console.log('123')
	});


	// mac chrome checkbox fix
	if (navigator.userAgent.indexOf("Mac OS X") != -1) {
		$(".dt-checkboxes-cell input, .dt-checkboxes").addClass("mac-checkbox")
	}

	//
	async function isDelete() {
		const result = await Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!',
			confirmButtonClass: 'btn btn-primary',
			cancelButtonClass: 'btn btn-danger ml-1',
			buttonsStyling: false,
		})
		return result.value;
	}
	async function deleteSuccess() {
		await Swal.fire(
			{
				type: "success",
				title: 'Deleted!',
				text: 'Your file has been deleted.',
				confirmButtonClass: 'btn btn-success',
			}
		)
	}
	function alertError(err = "Error") {
		Swal.fire({
			title: "Error!",
			text: err,
			type: "error",
			confirmButtonClass: 'btn btn-primary',
			buttonsStyling: false,
		});
	}
})