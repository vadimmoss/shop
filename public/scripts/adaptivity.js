$(function() {
//media adaptive
    window.onresize = function () {
        if (document.body.offsetWidth >= 600) {
            let sidebar = document.getElementById("side");
            var profile_button = document.getElementById("profile_button");
            var logout_button = document.getElementById("logout_button");
            let logo_link  = document.getElementById('logo_link');
            if(profile_button === null  && logout_button === null ){

            }
            else{
                if( logo_link === null)
                {

                }
                else {
                    logo_link.style.display = "flex";
                    profile_button.style.display = "block";
                    logout_button.style.display = "block";
                }
            }
             sidebar.removeAttribute("style");
        }
        if (document.body.offsetWidth >= 900) {
            let sidebar = document.getElementById("side");
            // sidebar.style.width = "250px";
        }

        if (document.body.offsetWidth <= 600) {
                    let sidebar = document.getElementById("side");
                     //sidebar.style.width = "0";
                     //sidebar.style.overflow = "hidden";
                    var profile_button = document.getElementById("profile_button");
                    var logout_button = document.getElementById("logout_button");
                    let logo_link  = document.getElementById('logo_link');
                    if(profile_button === null && logout_button === null ){

                    }
                    else {
                        if(logo_link ===null){

                        }
                        else{
                            logo_link.style.display = "none";
                            profile_button.style.display = "none";
                            logout_button.style.display = "none";
                        }
                    }
                }
    };
    $(document).on('click', '.menu_button', function (event) { // выдвижение меню ul
        var sidebar = document.getElementById("side");
        sidebar.style.width = "100%";
        sidebar.style.overflow = "inherit";
        var search_block = document.getElementById("search_container");
        if (search_block !== null){
            search_block.style.display = "none";
        }
        var registration_button = document.getElementById("registration_button");
        var login_button = document.getElementById("login_button");
        var profile_button = document.getElementById("profile_button");
        var logout_button = document.getElementById("logout_button");
        var cart_button = document.getElementById("cart_button");
        if(profile_button === null && logout_button === null){

        }
        else {
            profile_button.style.display = "block";
            logout_button.style.display = "block";
        }
        if(registration_button === null && login_button === null){

        }
        else {
            registration_button.style.display = "block";
            login_button.style.display = "block";
        }
        let img = document.getElementById("menu_button_img");
        img.style.transform = "rotate(90deg)";
        let button = document.getElementById("menu_button_id");
        button.classList.toggle("menu_opened");

        $(document).on('click', '.menu_opened', function (event) { // выдвижение меню ul
            var sidebar = document.getElementById("side");
            sidebar.style.width = "0";
            let img = document.getElementById("menu_button_img");
            img.style.transform = "rotate(-90deg)";
            button.classList.add("menu_button");
            sidebar.style.overflow = "hidden";
            var search_block = document.getElementById("search_container");
            if (search_block !== null){
                search_block.style.display = "flex";
            }
            if(registration_button === null && login_button === null){

            }
            else {
                registration_button.style.display = "none";
                login_button.style.display = "none";
            }
            if(profile_button === null && logout_button === null){

            }
            else {
                profile_button.style.display = "none";
                logout_button.style.display = "none";
            }
        });
    });
});
//media adaptive