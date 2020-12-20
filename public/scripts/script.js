$(function() {
    let city_select = $("#city_select");
    let city_select_li = $('.city_name');
    let city_input_container = $('#input_container');
    let city = $("#city");
    let post_select = $('#post_addr');

    function getCities(result){
        city.css('display','flex');
        let addresses = JSON.parse(result).data[0]['Addresses'];
        city.children().remove();
        city.append("<ul id='city_select_ul'></ul>");
        let select = $("#city_select_ul");
        for(let key  in addresses) {
            let city_value = String(addresses[key]['DeliveryCity']);
            let city = String(addresses[key]['Present']);
            select.append("<li class='city_name' value='"+city_value+"'>"+city+"</li>");
        }
    }
    function insertPosts(result) {
        let addresses = JSON.parse(result).data;
        console.log(addresses);
        post_select.children().remove();
        for(let key  in addresses) {
            let post_name = String(addresses[key]['Description']);
            post_select.append("<option class='post_name' value='"+post_name+"'>"+post_name+"</option>");
        }
    }
    function ajaxQuery(value, url, func){
        $.ajax({
            type:'POST',
            url: url,
            data: {city:value},
            success: function(result) {
                eval(func)(result)
            },
        });
    }
    function get_post_addresses(city_ref, post_url){
        ajaxQuery(city_ref,post_url,'insertPosts');
    }

    city.hover(function(){
        $(this).addClass("hovered");
    },function(){
        $(this).removeClass("hovered");
    });

    city_select.on('focusout', function(){
        if(!city.hasClass("hovered"))
            city.css('display','none');
    });
    city_select.on('focusin', function(){
        let city = $("#city_select").val();
        let city_url = $("#city_select").attr('url');
        ajaxQuery(city,city_url,'getCities');
    });
    city_select.on('input', function(){
        let city = $("#city_select").val();
        let city_url = $("#city_select").attr('url');
        if(city.length % 2 !== 0&&city.length!==1){

            ajaxQuery(city,city_url,'getCities');
        }
    });
    $(document).on('click', '.city_name' , function(event) {
        if(post_select){
            let city_url = $("#post_addr").attr('url');
            let city_ref = $(this).attr('value');
            let city_name = $(this).text();
            city_select.attr('value',city_ref);
            city_select.val(city_name);
            city.css('display','none');
            get_post_addresses(city_ref,city_url);
        }
        if(!post_select){
            let city_name = $(this).text();
            city_select.val(city_name);
            city.css('display','none');
        }
    });
});