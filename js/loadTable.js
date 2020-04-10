$(document).on('click', 'button', function() {
			$("th:last-child, td:last-child").css({
				display: "none"
			});
		})
		$(document).ready(function() {
			load_data();

			function showTable(response) {
				var table = $('#root').tableSortable({
					data: JSON.parse(response),
					columns: columns,
					searchField: '#searchField',
					rowsPerPage: 15,
					sorting: false,
					pagination: true
				});
				$('#changeRows').on('change', function() {
					table.updateRowsPerPage(parseInt($(this).val(), 10));
				});
			}

			function filter_data() {
				var action = 'fetch_data';
				var minimum_price = $('#hidden_minimum_price').val();
				var maximum_price = $('#hidden_maximum_price').val();
				var price = get_filter('price');
				var module = get_filter('module');
				var system = get_filter('system');
				var type = get_filter('type');
				var country = get_filter('country');
				$.ajax({
					url: "ProcessingData.php?init=false",
					method: "POST",
					data: {
						action: action,
						price: price,
						minimum_price: minimum_price,
						maximum_price: maximum_price,
						module: module,
						system: system,
						type: type,
						country: country
					},
					success: function(data) {
						showTable(data);
						$("th:last-child, td:last-child").css({
							display: "none"
						});
						$(document).on('click', 'tr', function() {
							var arr = $(this).text().split(' ');
							var id = arr[arr.length - 1];

							$.each(JSON.parse(response), function(index, value) {
								if (value.id === id) {
									$('#productDetail').modal('show');
									$('#release').text(value.release);
									$('#module').text(value.module);
									$('#code').text(value.id);
									$('#description').text(value.desp);
									$('#price').text(value.mrp);
									$('#system').text(value.system);
									$('#race').text(value.race);
									$('#type').text(value.type);
									$('#qtyPack').text(value.qtyPack);
									$('#country').text(value.country);
								}
							});
						});
					}
				});
			}

			var columns = {
				module: 'Module',
				desp: 'Description',
				mrp: 'Price(RM)',
				qty: 'Quantity Order',
				id: 'id'
			}

			function load_data() {
				$.ajax({
					method: 'GET',
					url: 'ProcessingData.php?stock=yes&init=true',
					data: {},
					success: function(response) {
						showTable(response);
						$("th:last-child, td:last-child").css({
							display: "none"
						});
						$(document).on('click', 'tr', function() {
							var arr = $(this).text().split(' ');
							var id = arr[arr.length - 1];

							$.each(JSON.parse(response), function(index, value) {
								if (value.id === id) {
									$('#productDetail').modal('show');
									$('#release').text(value.release);
									$('#module').text(value.module);
									$('#code').text(value.id);
									$('#description').text(value.desp);
									$('#price').text(value.mrp);
									$('#system').text(value.system);
									$('#race').text(value.race);
									$('#type').text(value.type);
									$('#qtyPack').text(value.qtyPack);
									$('#country').text(value.country);
								}
							});
						});
					}
				});
			}

			$(function() {
				$("#slider-range").slider({
					range: true,
					min: 0,
					max: 1300,
					values: [10, 800],
					slide: function(event, ui) {
						$("#amount").val("RM" + ui.values[0] + " - RM" + ui.values[1]);
						$('#hidden_minimum_price').val(ui.values[0]);
						$('#hidden_maximum_price').val(ui.values[1]);
						filter_data();
					}
				});
				$("#amount").val("RM" + $("#slider-range").slider("values", 0) +
					" - RM" + $("#slider-range").slider("values", 1));
			});

			function get_filter(class_name) {
				var filter = [];
				$('.' + class_name + ':checked').each(function() {
					filter.push($(this).val());
				});
				return filter;
			}

			$('.common_selector').click(function() {
				filter_data();
			});

			$(".reset-btn").click(function() {
				$("#filterForm").trigger("reset");
				load_data();
				$("#amount").val("RM" + $("#slider-range").slider("values", 0) +
					" - RM" + $("#slider-range").slider("values", 1));
			});
			var item = [];
			$(document).on('click', '#btnAdd', function() {
				item.push($(this).val());
				var action1 = 'add_cart';
				var action2 = 'cart_count';
				$.ajax({
					url: "./countCart.php",
					method: "POST",
					data: {
						action: action2,
						item: item,
					},
					success: function(data) {
						data = JSON.parse(data);
						$("body").overhang({
							type: data.type,
							message: data.msg
						});
					}
				});
				$.ajax({
					url: "./addCart.php",
					method: "POST",
					data: {
						action: action1,
						item: item,
					}
				});
			});
		});
