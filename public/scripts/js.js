$(function() {




    // $(document).on("click",".catalog_button_name_unactive",function(){
    //     $(".cat_container").css('display', 'none');
    //     $(".catalog_block_unactive").toggleClass('catalog_block_active').removeClass('catalog_block_unactive');
    //     $(".catalog_button_name_unactive").toggleClass('catalog_button_name_active').removeClass('catalog_button_name_unactive');
    //     $(".catalog_block_active").load('/menu .menu_container')
    //
    // });
    // $(document).on("click",".catalog_button_name_active",function(){
    //     $(".catalog_block_active").toggleClass('catalog_block_unactive').removeClass('catalog_block_active');
    //     $(".catalog_button_name_active").toggleClass('catalog_button_name_unactive').removeClass('catalog_button_name_active');
    //     $(".cat_container").css('display', 'grid');
    // });



    $(document).on('click', '.plus_button' , function(event) {
        let current_value = $(this).siblings('.amount_input').val();
        current_value = Number(current_value) + 1;
        $(this).siblings('.amount_input').val(current_value);
        let price = Number($(this).parents('.product_container_form').find('.product_price_form').text());
        let one_price = Number($(this).parents('.product_container_form').find('.product_price_form').attr('price'));
        price = price + one_price;
        $(this).parents('.product_container_form').find('.product_price_form').text(price);
        let amount_price = 0;
        let prices = (document).getElementsByClassName('product_price_form');
        console.log(prices);
        for (var i = 0; i < prices.length; i++) {
            amount_price = amount_price + Number( prices[i].textContent);
        }
        $('#amount_number').text(amount_price);
        $('#amount_price_invisible').val(amount_price);
    });
    $(document).on('click', '.minus_button' , function(event) {
        let current_value = $(this).siblings('.amount_input').val();
        if (Number(current_value) > 1){
            current_value = Number(current_value) - 1;
            $(this).siblings('.amount_input').val(current_value);
            let price = Number($(this).parents('.product_container_form').find('.product_price_form').text());
            let one_price = Number($(this).parents('.product_container_form').find('.product_price_form').attr('price'));
            price = price - one_price;
            $(this).parents('.product_container_form').find('.product_price_form').text(price)
            let amount_price = 0;
            let prices = (document).getElementsByClassName('product_price_form');
            console.log(prices);
            for (var i = 0; i < prices.length; i++) {
                amount_price = amount_price + Number( prices[i].textContent);
            }
            $('#amount_number').text(amount_price);
            $('#amount_price_invisible').val(amount_price);
        }
    });



    $('#zakaz_button').click(function () {
        var form = document.getElementById("cart_form");
        form.style.display = "flex";
    });

    $('#registration_button').click(function(){
        var form = document.getElementById("reg_form");
        form.style.display = "flex";
    });
    $('#login_button').click(function(){
        var form = document.getElementById("login_form");
        form.style.display = "flex";
        setTimeout( () => form.style.opacity  = "1",100);
    });
    //add_form
    $('#add_new_category').click(function(){
        var add_form = document.getElementById("add_form");
        add_form.style.display = "flex";
    });
    //add_new_class
    $('#add_new_class').click(function(){
        var add_form = document.getElementById("add_class_form");
        add_form.style.display = "flex";
    });
    $('#add_new_type').click(function(){
        var add_form = document.getElementById("add_type_form");
        add_form.style.display = "flex";
    });
    $('#add_new_chars').click(function(){
        var add_form = document.getElementById("add_chars_form");
        add_form.style.display = "flex";
    });
    $('#add_new_product').click(function(){
        var add_form = document.getElementById("add_product_form");
        add_form.style.display = "flex";
    });
    $('.admin_close_button').click(function(){
        var add_form = document.getElementById("add_form");
        var add_char_form = document.getElementById("add_chars_form");
        var add_product_form = document.getElementById("add_product_form");
        var add_class_form = document.getElementById("add_class_form");
        var add_type_form = document.getElementById("add_type_form");
        var cart_form = document.getElementById("cart_form");
        var all_forms = document.getElementsByClassName("form_style");


        $(all_forms)[0].reset();
        add_type_form.style.display = "none";
        add_char_form.style.display = "none";
        add_form.style.display = "none";
        add_product_form.style.display = "none";
        add_class_form.style.display = "none";
        cart_form.style.display = "none";

    });

    $('.close_button').click(function(){
        var cart_form = document.getElementById("cart_form");
        var login_form = document.getElementById("login_form");
        var register_form = document.getElementById("reg_form");
        var all_forms = document.getElementsByClassName("form_style");
        $(all_forms)[0].reset();
        cart_form.style.display = "none";
        register_form.style.display = "none";
        login_form.style.display = "none";

    });
    $('.reg_close_button').click(function(){
        var login_form = document.getElementById("login_form");
        var register_form = document.getElementById("reg_form");
        var all_forms = document.getElementsByClassName("form_style");
        $(all_forms)[0].reset();
        register_form.style.display = "none";
        login_form.style.opacity  = "0";
        setTimeout(() => login_form.style.display = "none", 200);
    });





    $(document).on('click', 'li.slide-li' , function(event){ // выдвижение меню ul

        $(this).children("ul").slideToggle('fast');
        $('.slide-li-back').children("ul").slideToggle('fast');
        $('.slide-li-back').addClass("slide-li");
        $('.slide-li-back').removeClass("slide-li-back");

        let  category = $(this).children("a.cat_image").attr('id');
        $('input:checkbox').removeAttr('checked');
        event.stopPropagation();
    });
    $(document).on('click', 'li' , function(event){ // выдвижение меню li
        //all li click
        $(".img-cat-active").addClass("cat_image");
        $(".img-cat-active").removeClass("img-cat-active");
        $(this).children("a.cat_image").toggleClass("img-cat-active");
        $(this).children("a.cat_image").removeClass("cat_image");
        event.stopPropagation();
    });
    $(document).on('click', '#left-categories > li > ul' , function(event){ //выдвижение меню li
        $(this).children("li").slideToggle('fast');

        event.stopPropagation();
    });
//ЗАКРЫТЬ ВСЕ UL ПО НАЖАТИЮ НА ДРУГОЙ
    $(document).on('click', 'li.slide-li-back' , function(event){ // выдвижение меню ul
        $(".img-cat-active").toggleClass("cat_image");
        $(".img-cat-active").removeClass("img-cat-active");
        $('input:checkbox').removeAttr('checked');
        $(this).children("ul").slideToggle('fast');
        event.stopPropagation();
        $(this).removeClass("slide-li-back");
        $(this).addClass("slide-li");
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
    });
    $(document).on( "click",'#add_cat',  function(event) { //Открытие формы по нажатию на кнопку #add_cat
        let form = document.getElementById("add_category_form");
        form.style.display = "flex";
        event.stopPropagation();
    });
    // $(document).on("mouseover",".product_container",function(){
    //         $(this).children(".product_characteristics").css({"display":"block"});
    //     });
    // $(document).on("mouseout",".product_container",function(){
    //     $(this).children(".product_characteristics").css({"display":"none"});
    // });

    $(document).on('change', '#new_product_parent_cat', function() {
        var e = document.getElementById("new_product_parent_cat");
        var strUser = e.options[e.selectedIndex].value;
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: {category:strUser},
            success: function(html) {
                // $(".cat_container").html(html);

                var add_product_form = $('#yyy', html); //get new block from received page
                $('#xxx').html(add_product_form); //insert block to main page
            },
        });
        event.stopPropagation();
    });


    var timer;

    $('#profile_button').on({
        'mouseover': function () {
            let cc = $("#profile_list_container");
            cc.css({"display":"block"});

            clearTimeout(timer);
        },
        'mouseout' : function () {
            timer = setTimeout(function () {
                let cc = $("#profile_list_container");
                cc.css({"display":"none"});
            }, 200);

        }
    });
    $('#profile_list_container').on({
        'mouseover': function () {
            $("#profile_list_container").css({"display":"block"});
            clearTimeout(timer);
        },
        'mouseout' : function () {
            timer = setTimeout(function () {
                $("#profile_list_container").css({"display":"none"});
            }, 200);

        }
    });
    function cart_fitler(){
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

        console.log(uniqueNames);
        let table_name = $(this).attr('id');
        if (table_name === undefined){
            table_name = $('.slide-li-back').children('a').attr('id');
        }
        let maxPrice =  uniqueNames.get('max-price');
        let minPrice =  uniqueNames.get('min-price');
        uniqueNames.delete('max-price');
        uniqueNames.delete('min-price');
        if(uniqueNames.size === 0){

            uniqueNames.set('maxPrice', maxPrice);
            uniqueNames.set('minPrice', minPrice);
            var arr = [];
            uniqueNames.forEach( (value, key) => {
                arr.push( " ( " + `${key} = ${value}` +" ) ");
            });
            let table_name = $(this).attr('id');
            if (table_name === undefined){
                table_name = $('.slide-li-back').children('a').attr('id');
            }
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: {filter:arr, maxPrice: maxPrice, minPrice: minPrice,table_name:table_name},
                success: function(html) {
                    // $(".cat_container").html(html);
                    var cat_container = $('.cat_container', html); //get new block from received page
                    $('.content').html(cat_container); //insert block to main page
                },
            });
        }
        else {
            uniqueNames.set('maxPrice', maxPrice);
            uniqueNames.set('minPrice', minPrice);


            if (url===""){
                // $.ajax({
                //     type: "POST",
                //     url: $(this).attr('action'),
                //     data: {filter:'all'},
                //     success: function(html) {
                //         // $(".cat_container").html(html);
                //
                //         var cat_container = $('.cat_container', html); //get new block from received page
                //         $('.content').html(cat_container); //insert block to main page
                //     },
                // });
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
                        let load_gif = $(".main_loader");
                        load_gif.css( "display","block");
                        content.css( "display","none");
                        var cat_container = $('.cat_container', html); //get new block from received page
                        content.html(cat_container); //insert block to main page
                        timer = setTimeout(function () {
                            content.css( "display","grid");
                            load_gif.css( "display","none");
                        }, 200);
                    },
                });
            }
        }


    }
    function catalog_fitler(){
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

        console.log(uniqueNames);
        let table_name = $(this).attr('id');
        if (table_name === undefined){
            table_name = $('.slide-li-back').children('a').attr('id');
        }
        let maxPrice =  uniqueNames.get('max-price');
        let minPrice =  uniqueNames.get('min-price');
        uniqueNames.delete('max-price');
        uniqueNames.delete('min-price');
        if(uniqueNames.size === 0){

            uniqueNames.set('maxPrice', maxPrice);
            uniqueNames.set('minPrice', minPrice);
            var arr = [];
            uniqueNames.forEach( (value, key) => {
                arr.push( " ( " + `${key} = ${value}` +" ) ");
            });
            let table_name = $(this).attr('id');
            if (table_name === undefined){
                table_name = $('.slide-li').children('a').attr('id');
            }
            $.ajax({
                type: "POST",
                url: window.location,
                data: {filter:arr, maxPrice: maxPrice, minPrice: minPrice,table_name:table_name},
                success: function(html) {
                    // $(".cat_container").html(html);
                    var cat_container = $('.cat_container', html); //get new block from received page
                    $('.content').html(cat_container); //insert block to main page
                },
            });
        }
        else {
            uniqueNames.set('maxPrice', maxPrice);
            uniqueNames.set('minPrice', minPrice);


            if (url===""){
                // $.ajax({
                //     type: "POST",
                //     url: $(this).attr('action'),
                //     data: {filter:'all'},
                //     success: function(html) {
                //         // $(".cat_container").html(html);
                //
                //         var cat_container = $('.cat_container', html); //get new block from received page
                //         $('.content').html(cat_container); //insert block to main page
                //     },
                // });
            }
            else {
                var arr = [];
                uniqueNames.forEach( (value, key) => {
                    arr.push( " ( " + `${key} = ${value}` +" ) ");
                });
                let table_name = $(this).attr('id');
                if (table_name === undefined){
                    table_name = $('.slide-li').children('a').attr('id');
                }

                $.ajax({
                    url:  window.location,
                    type: 'POST',
                    data:  {filter: arr, table_name:table_name, maxPrice: maxPrice, minPrice: minPrice},
                    success: function(html) {

                        let content = $(".content");
                        let timer;
                        let load_gif = $(".main_loader");
                        load_gif.css( "display","block");
                        content.css( "display","none");
                        var cat_container = $('.cat_container', html); //get new block from received page
                        content.html(cat_container); //insert block to main page
                        timer = setTimeout(function () {
                            content.css( "display","grid");
                            load_gif.css( "display","none");
                        }, 200);
                    },
                });
            }
        }


    }
    //buy_button_catalog
    $(document).on('click', '.buy_button_catalog', function(event) {
        let id_product = $(this).attr('id');
        let category_id = $(this).attr('category');
        $.ajax({
            type: "POST",
            url: "/cart/add",
            data: {id_product:id_product, category_id:category_id},
            success: function(html) {
                //$('.cat_container').load(window.location + ' .cat_container>* ');
                // $('.fixed_button_container').load('/ .fixed_button_container>*');
                $('#cart_button').load('/ #cart_button');
                catalog_fitler();
            },
        });
    });
    $(document).on('click', '.buy_button', function(event) {
        let id_product = $(this).attr('id');
        let category_id = $(this).attr('category');
        $.ajax({
            type: "POST",
            url: "/cart/add",
            data: {id_product:id_product, category_id:category_id},
            success: function(html) {
                // $('.cat_container').load('/ .cat_container>*');
                // $('.fixed_button_container').load('/ .fixed_button_container>*');
                $('#cart_button').load('/ #cart_button');
                cart_fitler();
            },
        });
    });
    $(document).on('click', '.buy_button_product_page', function(event) {
        let id_product = $(this).attr('id');
        let category_id = $(this).attr('category');
        let location = window.location;
        $.ajax({
            type: "POST",
            url: "/cart/add",
            data: {id_product:id_product, category_id:category_id},
            success: function(html) {
                $('#cart_button').load('/ #cart_button');
                $('.product_items').load(location + ' .product_items>* ');
            },
        });
    });
    $(document).on('click', '.del_from_cart_registered', function(event) {
        let id_product = $(this).attr('id');
        let category_id = $(this).attr('category');
        $.ajax({
            type: "POST",
            url: "/cart/del",
            data: {id_product:id_product, category_id:category_id},
            success: function(html) {
                $('#amount_button_number').load('/cart #amount_button_number');
                $('.cat_container').load('account/cart .cat_container>*');

            },

        })
    });
    $(document).on('click', '.del_button', function(event) {
        let id_product = $(this).attr('id');
        let category_id = $(this).attr('category');
        $.ajax({
            type: "POST",
            url: "/cart/del",
            data: {id_product:id_product, category_id:category_id},
            success: function(html) {
                $('#amount_button_number').load('/cart #amount_button_number');
                $('.cat_container').load('/cart .cat_container>*');
                $('#cart_button').load('/ #cart_button');
            },

        })
    });
    //adding to cart
    $(document).on('click', '#add_to_cart', function(event) {
        var input = document.getElementById("add_to_cart");
        var id_product = input.value;
        var category_id = input.name;
        $.ajax({
            type: "POST",
            url: "/account/cart",
            data: {id_product:id_product, category_id:category_id},
            success: function(result) {
                json = jQuery.parseJSON(result);
                alertify.alert(json.status, json.message);
            },
        });
        event.stopPropagation();
    });
    // $(document).on('click', '.buy_button', function(event) {
    //     var input = document.getElementById("add_to_cart");
    //     var id_product = $(this).attr('id');
    //     var category_id = $(this).attr('category');
    //     $.ajax({
    //         type: "POST",
    //         url: "/account/cart",
    //         data: {id_product:id_product, category_id:category_id},
    //         success: function(result) {
    //         },
    //     });
    //     event.stopPropagation();
    // });







    $(document).on('click', '.slide-li', function(event) {
        let  category = $(this).children("div").attr('id');
        // alert(category);
        $(this).removeClass("slide-li");
        $(this).addClass("slide-li-back");
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data:  {table_name: category, filter: ""},
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
    });







//buy_button

//del_from_cart
    $(document).on('click', '.del_from_cart', function(event) {
        let id_del_product_from_cart = $(this).attr('value');
        $.ajax({
            type: "POST",
            url: "/cart/cart",
            data: {id_del_product_from_cart:id_del_product_from_cart},
            success: function(html) {
                var products = $('.cat_container>*', html); //get new block from received page
                $('.cat_container').html(products); //insert block to main page
            },
        });
        event.stopPropagation();
    });

    $(document).on('click', '.del_from_cart_registered', function(event) {
        let id_del_product_from_cart = $(this).attr('value');
        $.ajax({
            type: "POST",
            url: "/account/cart",
            data: {id_del_product_from_cart:id_del_product_from_cart},
            success: function(html) {
                var products = $('.cat_container>*', html); //get new block from received page
                $('.cat_container').html(products); //insert block to main page
            },
        });
        event.stopPropagation();
    });

    if (document.getElementById("count_classes_chars") !== null){
        var count_classes_chars = document.getElementById("count_classes_chars");
        count_classes_chars.oninput = function() {
            let count = $('#count_classes_chars').val();
            let arr = Array();
            for (let i = 0; i <= count; i++) {
                arr.push(i);
            }
            count = arr.length - 1;
            var ul = document.getElementById('classes_chars');
            let count_li = (document.getElementById('classes_chars').childNodes.length);
            count_li = count_li - 1;
            count = count - count_li;
            while (count < 0) {
                ul.removeChild(ul.lastChild);
                count++;
            }
            for (let i = 0; i < count; i++) {
                let li = document.createElement('li');
                let input = document.createElement('input');
                let label = li.appendChild(document.createElement('label'));
                let value = "class_" + i;
                var node = document.createTextNode("Введите клас: ");
                label.appendChild(node);
                input.setAttribute("name", value);
                li.appendChild(input);
                ul.appendChild(li);

            }
        };


        var input_count_chars = document.getElementById("count_chars");
        input_count_chars.oninput = function() {
            let count = $('#count_chars').val();
            let arr = Array();
            for (let i=0; i<=count; i++) {
                arr.push(i);
            }
            count = arr.length-1;
            var ul = document.getElementById('chars');
            let count_li = (document.getElementById('chars').childNodes.length);
            count_li = count_li-1;
            count = count -count_li;
            while (count < 0 ){
                ul.removeChild(ul.lastChild);
                count++;
            }
            for (let i = 0; i < count; i++) {
                let li = document.createElement('li');
                let input = document.createElement('input');
                let label = li.appendChild(document.createElement('label'));
                let value = "char_" + i;
                var node = document.createTextNode("Введите характеристику: ");
                label.appendChild(node);
                input.setAttribute("name", value);
                li.appendChild(input);
                ul.appendChild(li);
            }
        };


        var count_category_class = document.getElementById("count_category_class");

        count_category_class.oninput = function() {

            let count = $('#count_category_class').val();
            let arr = Array();
            for (let i=0; i<=count; i++) {
                arr.push(i);
            }
            count = arr.length-1;
            var ul = document.getElementById('classes_category');
            let count_li = (document.getElementById('classes_category').childNodes.length);
            count_li = count_li-1;
            count = count -count_li;
            while (count < 0 ){
                ul.removeChild(ul.lastChild);
                count++;
            }
            for (let i = 0; i < count; i++) {
                let li = document.createElement('li');
                let input = document.createElement('input');
                let label = li.appendChild(document.createElement('label'));
                let value = "char_" + i;
                var node = document.createTextNode("Введите характеристику: ");
                label.appendChild(node);
                input.setAttribute("name", value);
                li.appendChild(input);
                ul.appendChild(li);

            }

        };
        //new_char_parent_cat


        $(document).on('input', '#new_char_parent_cat', function(event) {
            var input_count_category = document.getElementById("new_char_parent_cat");
            input_count_category = input_count_category.options[input_count_category.selectedIndex].value;
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: {input_count_category:input_count_category},
                success: function(html) {
                    var cat_container = $('#new_parent_name > *', html); //get new block from received page
                    $('#li_classes > #new_parent_name').html(cat_container); //insert block to main page
                },
            });
            event.stopPropagation();
        });
        $(document).on('input', '#new_product_parent_cat', function(event) {
            var new_product_parent_cat = document.getElementById("new_product_parent_cat");
            new_product_parent_cat = new_product_parent_cat.options[new_product_parent_cat.selectedIndex].value;
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: {new_product_parent_cat:new_product_parent_cat},
                success: function(html) {
                    var cat_container = $('#type_of_product > *', html); //get new block from received page
                    $('#type_of_product').html(cat_container); //insert block to main page
                },
            });
            event.stopPropagation();
        });

    }
    $(document).on('change', '#city_addr', function() {
        var e = document.getElementById("city_addr");
        var strCity = e.options[e.selectedIndex].value;
        //alert(strCity);
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: {city_post:strCity},
            success: function(html) {
                // $(".cat_container").html(html);

                var address_post_department = $('#address_post_department > *', html); //get new block from received page
                //#cart_form > div > form> *
                $('#address_post_department').html('');
                $('#address_post_department').html(address_post_department); //insert block to main page
            },
        });
        event.stopPropagation();
    });
    $(document).on('change', '#city_addr_unregistered', function() {
        var e = document.getElementById("city_addr_unregistered");
        var strCity = e.options[e.selectedIndex].value;
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: {city_post:strCity},
            success: function(html) {
                // $(".cat_container").html(html);

                var address_post_department = $('#address_post_department_unregistered > *', html); //get new block from received page
                console.log(address_post_department);
                //#cart_form > div > form> *
                $('#address_post_department_unregistered').html('');
                $('#address_post_department_unregistered').html(address_post_department); //insert block to main page
            },
        });
    });
    $(document).on('change', '#city_addr_unregistered', function() {
        var e = document.getElementById("city_addr_unregistered");
        var strCity = e.options[e.selectedIndex].value;
        //alert(strCity);
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: {city_post:strCity},
            success: function(html) {
                // $(".cat_container").html(html);

                var address_post_department = $('#address_post_department > *', html); //get new block from received page
                //#cart_form > div > form> *
                $('#address_post_department').html('');
                $('#address_post_department').html(address_post_department); //insert block to main page
            },
        });
        event.stopPropagation();
    });



    // $('#admin_form').submit(function(event) {
    //     var add_form = document.getElementById("add_form");
    //     let location = window.location;
    //     add_form.style.display = "none";
    //     $('.container').load(location + '.container > *');
    // });


});