Dropzone.autoDiscover = false
let formData = new FormData();
let clearDropzone;

$(document).ready(function () {
	"use strict";

	toastr.options = {
		timeOut: 0,
		// closeOnHover: false,
		tapToDismiss: false,
		closeButton: true,
	}
	const $dropzone = $(".dropzone").dropzone({
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
			var dropzone = this;

			clearDropzone = function () {
				dropzone.removeAllFiles(true);
			};
			this.on('addedfile', function (file) {
				if (this.files.length > 1) {
					Swal.fire({
						title: "Max file reached!",
						text: "Photo only accept 1 pcs.\nRemove last image if you want to change, or contact developer to upgrade this feature.",
						type: "error",
						confirmButtonClass: 'btn btn-primary',
						buttonsStyling: false,
					});
					return this.removeFile(this.files[0]);
				}
				formData.append('images', file);
				formData.delete('image_id');
			})

			this.on('reset', function () {
				formData.append('image_id', '0')
			})

			$(".hide-data-sidebar, .cancel-data-btn, .overlay-bg").on(
				"click",
				async function () {
					let list_id = []
					$.each($('.dz-add-new'), function (file) {
						list_id.push($(this).data('dzRemove'))
					})
					if (list_id.length) {
					}
				}
			)
		}
	});

	$dropzone.addClass('d-none')

	var dataCategoryView = $(".data-list-view").on('xhr.dt', function (e, settings, json, xhr) {
		console.log(json)
		if (!json) return toastr.error(xhr.responseText)
	}).DataTable({
		responsive: true,
		processing: true,
		serverSide: true,
		ajax: {
			url: '/api/categories',
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

				return json.data
			},
		},
		dom:
			'<"top"<"actions action-btns"B><"action-filters"lf>><"clear">rt<"bottom"<"actions">p>',
		oLanguage: {
			sLengthMenu: "_MENU_",
			sSearch: ""
		},
		aLengthMenu: [[4, 10, 15, 20], [4, 10, 15, 20]],
		select: {
			style: "multi"
		},
		order: [[6, "asc"]],
		bInfo: true,
		pageLength: 4,
		buttons: [
			{
				text: "<i class='feather icon-plus'></i> Add New",
				action: function () {
					formData = new FormData();
				
					$('#header_table').text('Add new category')
					$("#data-name, #data-description").val("")

					$("#data-status").prop("selectedIndex", 0)

					$(this).removeClass("btn-secondary")
					
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
			{ className: 'product-action', targets: 4 },
		],
		columns: [
			{ data: null },
			{
				data: 'images',
				render: (data, type, row) => {
					if (data && data.url) {
						const link = data.url
						return `<img src="http://${link}" alt="Img placeholder">`
					} else {
						'<img src="/app-assets/images/elements/apple-watch.png" alt="Img placeholder">'
					}
				},
				defaultContent: '<img src="/app-assets/images/elements/apple-watch.png" alt="Img placeholder">'
			},
			{ data: 'name' },
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
			{ data: 'products' },
			{ data: 'created_at' },
			{
				data: null,
				render: function (data, type, row) {
					return `<span class="action-edit" data-id-product="${row.id}">
									<i class="feather icon-edit"></i>
								</span>
								<span class="action-delete" data-id-product="${row.id}">
									<i class="feather icon-trash"></i>
								</span>`
				},
				createdCell: function (td, cellData, rowData, row, col) {

					// On edit button
					$(td).children('.action-edit').on('click', function (e) {
						e.stopPropagation();
						formData = new FormData();
						formData.append('id', cellData.id)
						clearDropzone();
						const $dropzone = Dropzone.forElement(".dropzone")

						console.log(cellData.images)
						if (cellData.images) {
							cellData.images.accepted = true;
							let file = cellData.images

							$dropzone.removeAllFiles(true)
							$dropzone.emit("addedfile", file)
							$dropzone.emit("thumbnail", file, 'http://' + cellData.images.url)
							$dropzone.files.push(file)
							$dropzone.emit('complete', file)

							formData.delete('images');
						}

						// Add image for cateogries????
						$(".dropzone").removeClass("d-none")

						$('#header_table').text('Edit category')
						$('.add-data-btn').children('button').text('Save Change')
						$('.add-data-btn').children('button').removeAttr('disabled')

						$('#data-name').val(cellData.name ?? "");
						$('#data-description').val(cellData.description ?? "");

						$("#data-status").val(cellData.published ?? 0);


						$(".add-new-data").addClass("show");
						$(".overlay-bg").addClass("show");
					});

					// On delete button
					$(td).children('.action-delete').on('click', async function (e) {
						const $button = $(this)
						e.stopPropagation();
						const result = await isDelete();
						if (!result) return;
						// call ajax here!
						$.ajax({
							url: '/admin/categories',

							method: 'DELETE',

							data: { id: cellData.id },
							success: function (xml, statusCode, xhr) {
								$button.closest('td').parent('tr').fadeOut();
								if (xhr.responseJSON && !xhr.responseJSON.success) return alertError('No row are deleted');

								deleteSuccess(`You have been deleted ${xhr.responseJSON.row} row`);
								setTimeout(() => {
									dataProductsView.ajax.reload();
								}, 1000)
							},
							error: function (xhr) {
								if (xhr.responseText) toastr.error(xhr.responseText, 'Error');
								if (xhr.responseJSON && xhr.responseJSON.error) return toastr.error(xhr.responseText, 'Error');
							}
						})
					})
				}
			},
		],
		initComplete: function (settings, json) {
			$(".dt-buttons .btn").removeClass("btn-secondary")

			$('[data-role="delete-list"]').on('click', async function (e) {
				e.preventDefault();
				let listDelete = []
				$.each(dataCategoryView.rows({ selected: true }).data(), function (e) {

					listDelete.push(this.id)
				})

				if (!listDelete.length) return;
				const result = await isDelete();
				if (!result) return;
				$.ajax({
					url: '/admin/categories',
					// url: '/admin/test',
					method: 'DELETE',

					data: { id: listDelete },
					success: function (xml, statusCode, xhr) {

						if (xhr.responseJSON && xhr.responseJSON.error) return alertError('No row are deleted.');

						deleteSuccess(`You have been delete list item.`);
						// setTimeout(() => {
						dataCategoryView.ajax.reload();
						// }, 1000)
					},
					error: function (xhr) {
						if (xhr.responseText) toastr.error(xhr.responseText, 'Error');
						if (xhr.responseJSON && xhr.responseJSON.error) return toastr.error(xhr.responseText, 'Error');
					}
				})

			})
		}
	});

	dataCategoryView.on('draw.dt', function () {
		setTimeout(function () {
			if (navigator.userAgent.indexOf("Mac OS X") != -1) {
				$(".dt-checkboxes-cell input, .dt-checkboxes").addClass("mac-checkbox")
			}
		}, 50);
	});

	var dataProductsView = $(".data-thumb-view")
		.on('xhr.dt', function (e, settings, json, xhr) {
			if (!json) return toastr.error(xhr.responseText)
			const text = xhr.responseJSON;
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
					// console.log(params)
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
						formData = new FormData();
						$("#data-name, #data-price").val("")
						$('#header_table').text('Add new product')
						$("#data-name, #data-price, #data-description").val("")

						$("#data-category, #data-status").prop("selectedIndex", 0)

						$(this).removeClass("btn-secondary")
						// $('#create_form').attr('method', 'POST')
						$(".dropzone").addClass("d-none")
						$('.add-data-btn').children('button').text('Add Data')
						$(".add-new-data").addClass("show")
						$(".overlay-bg").addClass("show")
					},
					className: "btn-outline-primary"
				}
			],
			columnDefs: [
				{ targets: [0, 1, 8], orderable: false },
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
						if (data && data.url) {
							const link = data.url
							return `<img src="http://${link}" alt="Img placeholder">`
						} else {
							'<img src="/app-assets/images/elements/apple-watch.png" alt="Img placeholder">'
						}
					},
					defaultContent: '<img src="/app-assets/images/elements/apple-watch.png" alt="Img placeholder">'
				},
				{ data: 'name' },
				{
					data: 'categories.name',
					defaultContent: ''
				},
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
				{ data: 'created_at' },
				{
					data: null,
					render: function (data, type, row) {
						return `<span class="action-edit" data-id-product="${row.id}">
										<i class="feather icon-edit"></i>
									</span>
									<span class="action-delete" data-id-product="${row.id}">
										<i class="feather icon-trash"></i>
									</span>`
					},
					createdCell: function (td, cellData, rowData, row, col) {

						// On edit button
						$(td).children('.action-edit').on('click', function (e) {
							e.stopPropagation();
							formData = new FormData();
							formData.append('id', cellData.id)
							clearDropzone();
							const $dropzone = Dropzone.forElement(".dropzone")

							console.log(cellData.images)
							if (cellData.images) {
								cellData.images.accepted = true;
								let file = cellData.images

								$dropzone.removeAllFiles(true)
								$dropzone.emit("addedfile", file)
								$dropzone.emit("thumbnail", file, 'http://' + cellData.images.url)
								$dropzone.files.push(file)
								$dropzone.emit('complete', file)

								formData.delete('images');
							}

							$(".dropzone").removeClass("d-none")
							// $('#create_form').attr('method', 'PUT')

							$('#header_table').text('Edit product')
							$('.add-data-btn').children('button').text('Save Change')
							$('.add-data-btn').children('button').removeAttr('disabled')

							$('#data-name').val(cellData.name);
							$('#data-price').val(cellData.price);
							console.log(cellData);

							$("#data-category").val(cellData.categories ? cellData.categories.id : '');
							$("#data-status").val(cellData.published ?? 0);


							$(".add-new-data").addClass("show");
							$(".overlay-bg").addClass("show");
						});

						// On delete button
						$(td).children('.action-delete').on('click', async function (e) {
							const $button = $(this)
							e.stopPropagation();
							const result = await isDelete();
							if (!result) return;
							// call ajax here!
							$.ajax({
								url: '/admin/products',
								// url: '/admin/test',
								method: 'DELETE',

								data: { id: cellData.id, test: cellData.name },
								success: function (xml, statusCode, xhr) {
									$button.closest('td').parent('tr').fadeOut();
									if (xhr.responseJSON && xhr.responseJSON.error) return alertError('No row are deleted.');

									deleteSuccess(`You have been deleted ${xhr.responseJSON.row} row`);
									setTimeout(() => {
										dataProductsView.ajax.reload();
									}, 1000)
								},
								error: function (xhr) {
									if (xhr.responseText) toastr.error(xhr.responseText, 'Error');
									if (xhr.responseJSON && xhr.responseJSON.error) return toastr.error(xhr.responseText, 'Error');
								}
							})
						})
					}
				},
			],
			// rowCallback:function (row,data) {
			// 	console.log(row)
			// },
			initComplete: function (settings, json) {
				$(".dt-buttons .btn").removeClass("btn-secondary")
				$('[data-role="delete-list"]').on('click', async function (e) {
					e.preventDefault();
					let listDelete = []
					$.each(dataProductsView.rows({ selected: true }).data(), function (e) {
						console.log(e);
						console.log(this);
						listDelete.push(this.id)
					})
					if (!listDelete.length) return;
					const result = await isDelete();
					if (!result) return;
					$.ajax({
						url: '/admin/products',
						// url: '/admin/test',
						method: 'DELETE',

						data: { id: listDelete },
						success: function (xml, statusCode, xhr) {
							$button.closest('td').parent('tr').fadeOut();
							if (xhr.responseJSON && xhr.responseJSON.error) return alertError('No row are deleted.');

							deleteSuccess(`You have been deleted ${xhr.responseJSON.row} row`);
							setTimeout(() => {
								dataProductsView.ajax.reload();
							}, 1000)
						},
						error: function (xhr) {
							if (xhr.responseText) toastr.error(xhr.responseText, 'Error');
							if (xhr.responseJSON && xhr.responseJSON.error) return toastr.error(xhr.responseText, 'Error');
						}
					})
				})
			}
		});

	dataProductsView.on('draw.dt', function (e, settings) {
		// console.log(e, settings);
		const $this = this;
		setTimeout(function () {
			if (navigator.userAgent.indexOf("Mac OS X") != -1) {
				$(".dt-checkboxes-cell input, .dt-checkboxes").addClass("mac-checkbox")
			}
		}, 50);
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
		formData = new FormData();
		let obj = {}
		for (let pair of formData.entries()) {
			obj[pair[0]] = pair[1]
		}
		Dropzone.forElement('.dropzone').removeAllFiles(true)


		$(".add-new-data").removeClass("show")
		$(".overlay-bg").removeClass("show")

		Dropzone.forElement('.dropzone').removeAllFiles(true)
	})


	$("input,select,textarea").not("[type=submit]").jqBootstrapValidation(
		{
			submitSuccess: function ($form, event) {
				event.preventDefault();
				const form = $('form');
				const button = $("button[type='submit']");

				$('#create_form input[name],#create_form select[name],#create_form textarea[name]').each(function (index, element) {
					formData.append(element.name, element.value);
				});
				$.ajax({
					url: form.attr('action'),
					method: form.attr('method'),
					processData: false,
					contentType: false,
					data: formData,
					success: function (xml, status, xhr) {
						if (xhr.responseJSON && xhr.responseJSON["error"]) {
							for (const $key in xhr.responseJSON["error"]) {
								const helpblock = $(`input[name='${$key}']~div.help-block`)
								helpblock.parent().removeClass("validate").addClass("error")
								let text = '';
								xhr.responseJSON["error"][$key].forEach(element => {
									text += `<li>${element}</li>`;
								});
								helpblock.html(`<ul role="alert">${text}</ul>`)
							}
							return
						}
						$(".add-new-data").removeClass("show")
						$(".overlay-bg").removeClass("show")
						$("#data-name, #data-price, #data-description").val("")

						$("#data-category, #data-status").prop("selectedIndex", 0)
						dataProductsView.ajax.reload(null, false)
						dataCategoryView.ajax.reload(null, false)

						if (xhr.responseJSON && xhr.responseJSON["redirect"]) {
							window.location = xhr.responseJSON["redirect"];

							return;
						} else {
							toastr.success("", status)
						}
						console.log('no err')
						setTimeout(() => { dataProductsView.ajax.reload(null, false) }, 1000)
						Dropzone.forElement('.dropzone').removeAllFiles(true)

					},
					error: function (xhr, status, error) {
						console.log('err')
						toastr.error(xhr.responseText, status)
						$(".add-new-data").removeClass("show")
						$(".overlay-bg").removeClass("show")


						button.prop('disabled', false);
						// setTimeout(() => { dataProductsView.ajax.reload(null, false) }, 1000)

					}
				})
			}
		}
	);


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
	async function deleteSuccess(message = "You have been deleted.") {
		await Swal.fire(
			{
				type: "success",
				title: 'Deleted!',
				text: message,
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