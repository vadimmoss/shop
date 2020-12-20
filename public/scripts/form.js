$(function() {
	function fitler(){
		 console.clear();
		let url = $("#qqq").serialize();
		let url2 = $("#qqq").serializeArray();

		var uniqueNames = new Map();
		url2.forEach((item) => {
			if (url2.length >= 2){
				var new_item = uniqueNames.get(item['name']);
			}
			if($.inArray(item['name'], uniqueNames) === -1){

				let first_item = item['name'];
				if (new_item === undefined){
					let second_item = item['value'];
					uniqueNames.set(first_item,second_item);
				}
				else {
					let second_item =item['value']+" or " + item['name'] +' = '+ new_item;
					uniqueNames.set(first_item,second_item);
				}
			}
		});
		let maxPrice =  uniqueNames.get('max-price');
		let minPrice =  uniqueNames.get('min-price');
		uniqueNames.delete('max-price');
		uniqueNames.delete('min-price');
		uniqueNames.set('maxPrice', maxPrice);
		uniqueNames.set('minPrice', minPrice);
		console.log(uniqueNames);

		if (url===""){
			$.ajax({
				type: "POST",
				url: $(this).attr('action'),
				data: {filter:'all'},
				success: function(html) {
					// $(".cat_container").html(html);

					var cat_container = $('.cat_container', html); //get new block from received page
					$('.content').html(cat_container); //insert block to main page
				},
			});
		}
		else {
			var arr = [];
			uniqueNames.forEach( (value, key) => {
				arr.push( " ( " + `${key} = ${value}` +" ) ");
			});
			let table_name = $(this).attr('id');
			if (table_name === undefined){
				table_name = $('.slide-li-back').children('a').attr('id');
			}
			$.ajax({
				url: $(this).attr('action'),
				type: 'POST',
				data:  {filter: arr, table_name:table_name, maxPrice: maxPrice, minPrice: minPrice},
				success: function(html) {
					let content = $(".content");
					let timer;
					let load_gif = $(".load_gif");
					load_gif.css( "display","block");
					content.css( "display","none");
					var cat_container = $('.cat_container', html); //get new block from received page
					content.html(cat_container); //insert block to main page
					timer = setTimeout(function () {
						content.css( "display","grid");
						load_gif.css( "display","none");
					}, 500);
				},
			});
		}

	}
	$(document).on('click', '.characteristics', fitler);
	$(document).on('click', '.submit-price', fitler);



	$(document).on('click', '#search_button' , function(event){ //выдвижение меню li
		let search_string = document.getElementById("search_input_box").value;
		$.ajax({
			url: $(this).attr('action'),
			type: 'POST',
			data:  {search_string: search_string},
			success: function(html) {
				console.log(html);
				let content = $(".content");
				let timer;
				let load_gif = $(".load_gif");
				load_gif.css( "display","block");
				content.css( "display","none");
				var cat_container = $('.cat_container', html); //get new block from received page
				content.html(cat_container); //insert block to main page
				timer = setTimeout(function () {
					content.css( "display","grid");
					load_gif.css( "display","none");
				}, 500);
			},
		});
		event.stopPropagation();
	});
});

$(document).ready(function() {
	$( "#cart_button" ).click(function() {
		//href="/account/cart"
		//alert('form');
	 });
});
function showgif(){
	$(".cat_container").css('display', 'none');
	$(".loader").css('display', 'flex');
}
function hidegif(){
	$(".cat_container").css('display', 'block');
	$(".loader").css('display', 'none');
}
$(document).ready(function() {
	$('#registered_cart_form').submit(function(event) {
		var json;
		event.preventDefault();
		$.ajax({

			type: $(this).attr('method'),
			url: $(this).attr('action'),
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			ajaxStart: showgif(),
			success: function(result) {
				let cart_form = document.getElementById('cart_form');
				$('.cat_container').load('/account/cart .cat_container>*');
				$('#fixed_button_container').load('/account/cart #fixed_button_container>*', function() {
					hidegif();
				});
				if (cart_form === null)
				{
				}
				else
				{
					cart_form.style.display ="none";
					alertify.alert('Корзина', 'Заказ оформлен');

				}
				json = jQuery.parseJSON(result);
				if (json.url) {
					window.location.href = '/' + json.url;
				} else {
					alertify.alert(json.status, json.message);
				}
			},
		});
	});
	$('#unregistered_cart_form').submit(function(event) {
		var json;
		event.preventDefault();
		$.ajax({
			type: $(this).attr('method'),
			url: $(this).attr('action'),
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			ajaxStart: showgif(),
			success: function(result) {
				let cart_form = document.getElementById('cart_form');
				$('.cat_container').load('/cart .cat_container>*');
				$('#fixed_button_container').load('/cart #fixed_button_container>*', function() {
					hidegif();
				});
				if (cart_form === null)
				{
				}
				else
				{
					cart_form.style.display ="none";
					alertify.alert('Корзина', 'Заказ оформлен');

				}
				json = jQuery.parseJSON(result);
				if (json.url) {
					window.location.href = '/' + json.url;
				} else {
					alertify.alert(json.status, json.message);
				}
			},
		});
	});
	// $('#add_product').submit(function(event) {
	// 	if ($(this).attr('id') == 'no_ajax') {
	// 		return;
	// 	}
	// 	if ($(this).attr('id') == 'unregistered_cart_form') {
	// 		return;
	// 	}
	// 	if ($(this).attr('id') == 'registered_cart_form') {
	// 		return;
	// 	}
	// 	var json;
	// 	event.preventDefault();
	// 	alert( $(this).attr('action'));
	// 	$.ajax({
	// 		type: $(this).attr('method'),
	// 		url: $(this).attr('action'),
	// 		data: new FormData(this),
	// 		contentType: false,
	// 		cache: false,
	// 		processData: false,
	// 		success: function(result) {
	// 			alert(result);
	// 			json = jQuery.parseJSON(result);
	// 			if (json.url) {
	// 				window.location.href = '/' + json.url;
	// 			} else {
	// 				alertify.alert(json.status, json.message);
	// 			}
	// 		},
	// 	});
	// });
	$('form').submit(function(event) {
		if ($(this).attr('id') === 'admin_form') {
			event.preventDefault();
			$.ajax({
				type: $(this).attr('method'),
				url: $(this).attr('action'),
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				success: function(result) {
					var add_form = document.getElementById("add_form");
					add_form.style.display = "none";
					$('#left-categories').load(location + ' #left-categories > *');
				},
			});
			return;
		}
		if ($(this).attr('id') === 'add_class_form_id') {
			event.preventDefault();
			$.ajax({
				type: $(this).attr('method'),
				url: $(this).attr('action'),
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				success: function(result) {
					var add_form = document.getElementById("add_class_form_id");
					add_form.style.display = "none";
					window.location.reload();
				},
			});
			return;
		}
		if ($(this).attr('id') === 'add_chars_form_id') {
			event.preventDefault();
			$.ajax({
				type: $(this).attr('method'),
				url: $(this).attr('action'),
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				success: function(result) {
					var add_form = document.getElementById("add_chars_form_id");
					add_form.style.display = "none";
					window.location.reload();
				},
			});
			return;
		}
		if ($(this).attr('id') === 'add_product') {
			event.preventDefault();
			$.ajax({
				type: $(this).attr('method'),
				url: $(this).attr('action'),
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				success: function(result) {
					var add_form = document.getElementById("add_product");
					add_form.style.display = "none";
					window.location.reload();
				},
			});
			return;
		}
		if ($(this).attr('id') === 'add_type_form_id') {
			event.preventDefault();
			$.ajax({
				type: $(this).attr('method'),
				url: $(this).attr('action'),
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				success: function(result) {
					var add_form = document.getElementById("add_type_form_id");
					add_form.style.display = "none";
					window.location.reload();
				},
			});
			return;
		}
		if ($(this).attr('id') == 'no_ajax') {
			return;
		}
		if ($(this).attr('id') == 'unregistered_cart_form') {
			return;
		}
		if ($(this).attr('id') == 'registered_cart_form') {
			return;
		}
		if ($(this).attr('id') == 'activation_form') {
			var json;
			event.preventDefault();
			$.ajax({
				type: $(this).attr('method'),
				url: $(this).attr('action'),
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				success: function(result) {
					json = jQuery.parseJSON(result);
					if (json.url) {
						window.location.href = '/' + json.url;
					} else {
						alertify.alert(json.status, json.message);
					}
					if(json.status === 'Success'){
						var activate_form = document.getElementById("activate_form");
						activate_form.style.display="none";
					}
				},
			});
			return;
		}
		//register_form
		if ($(this).attr('id') == 'register_form') {
			var json;
			event.preventDefault();

			$.ajax({
				type: $(this).attr('method'),
				url: $(this).attr('action'),
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				success: function(result) {
					//alert(result);
					json = jQuery.parseJSON(result);
					if (json.url) {
						window.location.href = '/' + json.url;
					} else {
						if (json.status === 'Success'){
							//alert('Туть форма з вводом кода тыц!:)');
							var cart_form = document.getElementById("reg_form");
							cart_form.style.display="none";
							$('#activate_form').css('display','flex')

						}
					}
				},
			});
			return;
		}

		var json;
		event.preventDefault();

		$.ajax({
			type: $(this).attr('method'),
			url: $(this).attr('action'),
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			success: function(result) {
				json = jQuery.parseJSON(result);
				if (json.url) {
					window.location.href = '/' + json.url;
				} else {
					alertify.alert(json.status, json.message);
				}
			},
		});
	});
});
