$(function() {
//media adaptive
    window.onresize = function () {
        if (document.body.offsetWidth >= 600) {
            let sidebar = document.getElementById("side");

            sidebar.removeAttribute("style");
        }
        if (document.body.offsetWidth >= 900) {
            let sidebar = document.getElementById("side");
        }


    };
    $(document).on('click', '.menu_button', function (event) { // выдвижение меню ul
        var sidebar = document.getElementById("side");
        sidebar.style.width = "100%";
        sidebar.style.overflow = "inherit";
        var registration_button = document.getElementById("registration_button");
        var logout_button = document.getElementById("logout_button");
        var cart_button = document.getElementById("cart_button");


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

        });
    });
});
//media adaptive