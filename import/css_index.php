<link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="assets/css/input.css" rel="stylesheet">
<link href="assets/css/styleLogin.css" rel="stylesheet">
<link href="assets/css/sb-admin-2.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap/css/datepicker3.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="assets/vendor/jquery-confirm-v3.3.4/css/jquery-confirm.css">
<link rel="stylesheet" type="text/css" href="assets/plugins/sweetalert/sweetalert2.css" />
<link rel="stylesheet" type="text/css" href="assets/plugins/select2/select2_index.css" />



<style>
    @font-face {
        font-family: myFirstFont;
        src: url("assets/fonts/DB Helvethaica X.ttf");
    }


    body {
        font-family: myFirstFont;
        font-size: 25px;
    }

    @media screen and (min-width: 768px) {



        #div_login {
            opacity: 0.95;
            border-radius: 25px;
            margin-left: -27rem;


        }

        #input_UserName {
            font-size: 16px;
        }

        #input_PassWord {
            font-size: 16px;
        }


    }

    @media screen and (min-width: 1023px) {

        .wallpaper {

            background-image: url(assets/img/bg-6.png);
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: grid;
            align-content: center;
            justify-content: center;

        }


        #div_login {
            opacity: 0.95;
            border-radius: 25px;
            margin-left: -25rem;


        }

        #input_UserName {
            font-size: 16px;
        }

        #input_PassWord {
            font-size: 16px;
        }

        #headerX {
            color: #1570EF;
            font-weight: bold;
            font-size: 25px;
        }

        #small1 {
            font-size: 15px;
        }

    }




    /* @media screen and (min-width: 1920px) {

        .wallpaper {

            background-image: url(assets/img/bg-6.png);
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: grid;
            align-content: center;
            justify-content: center;

        }

        #div_login {
            opacity: 0.95;
            border-radius: 25px;
            margin-left: -28rem;


        }

        #headerX {
            font-size: 1.5rem !important;
        }

        #input_UserName {
            font-size: 16px;
        }

        #input_PassWord {
            font-size: 16px;
        }
    } */

    @media screen and (min-width: 1536px) {

        .wallpaper {

            background-image: url(assets/img/bg-6.png);
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: grid;
            align-content: center;
            justify-content: center;

        }

        #div_login {
            opacity: 0.95;
            border-radius: 25px;
            margin-left: -35rem;


        }

        #input_UserName {
            font-size: 16px;
        }

        #input_PassWord {
            font-size: 16px;
        }

        #headerX {
            color: #1570EF;
            font-weight: bold;
            font-size: 30px;
        }

        #small1 {
            font-size: 25px;
        }
    }

    @media screen and (min-width: 1920px) {
        .wallpaper {

            background-image: url(assets/img/bg-6.png);
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: grid;
            align-content: center;
            justify-content: center;

        }

        #div_login {
            opacity: 0.95;
            border-radius: 25px;
            /* margin-left: -37rem; */
        }

        #input_UserName {
            font-size: 20px;
        }

        #input_PassWord {
            font-size: 20px;
        }

        #headerX {
            color: #1570EF;
            font-weight: bold;
            font-size: 30px;
        }

        #small1 {
            font-size: 25px;
        }
    }

    @media screen and (min-width: 2560px) {

        .wallpaper {

            background-image: url(assets/img/bg-6.png);
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: grid;
            align-content: center;
            justify-content: center;

        }

        #div_login {
            opacity: 0.95;
            border-radius: 25px;
            margin-left: -50rem;
            margin-top: -5rem;
            width: 40rem;
            font-size: 25px;
        }

        #input_UserName {
            font-size: 20px;
        }

        #input_PassWord {
            font-size: 20px;
        }
    }



    .banner {
        position: relative;
    }

    .banner>img {
        width: 100%;
        height: auto;
    }

    .banner>.content {
        position: absolute;
        top: 0;
        bottom: 0;
        overflow: auto;
    }

    .iconHelper {
        position: fixed;
        right: 2%;
        bottom: 2%;
        width: 100px;
        height: 100px;
        background: #ffffff;
        border-radius: 100px;
        font-size: 24px;
        color: #1c5a7d;
        cursor: pointer;

        -webkit-box-shadow: 4px 4px 5px 0px rgba(148, 143, 148, 1);
        -moz-box-shadow: 4px 4px 5px 0px rgba(148, 143, 148, 1);
        box-shadow: 4px 4px 5px 0px rgba(148, 143, 148, 1);
    }

    .help-title {
        font-size: 18px;
        font-weight: 600;
    }

    .help-line {
        color: #309b1d;
    }

    .helper {
        position: fixed;
        right: 2%;
        bottom: 2%;
        border-radius: 20px;
        width: 270px;
    }

    .helperIn {
        animation-duration: 2s;
        animation-fill-mode: both;
        animation-name: HelpIn;
    }

    .rotage {
        transition: 0.70s;
        -webkit-transition: 0.70s;
        -moz-transition: 0.70s;
        -ms-transition: 0.70s;
        -o-transition: 0.70s;
        width: 60px;
        display: block;
        margin-right: auto;
        margin-left: auto;
    }

    .rotage:hover {
        color: green;
        transition: 0.70s;
        -webkit-transition: 0.70s;
        -moz-transition: 0.70s;
        -ms-transition: 0.70s;
        -o-transition: 0.70s;
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        transform: rotate(360deg);
    }

    @keyframes HelpIn {
        from {
            bottom: -98%;
        }

        to {
            bottom: 2%;
        }
    }

    .helperOut {
        animation-duration: 1.5s;
        animation-fill-mode: both;
        animation-name: HelpOut;
    }

    @keyframes HelpOut {
        from {
            bottom: 2%;
        }

        to {
            bottom: -98%;
        }
    }

    button {
        outline: none !important;
        border: none;
        background: transparent;
        color: black;
    }

    /* body {
        font-family: 'Kanit', sans-serif;
    } */


    .col-center {
        vertical-align: middle !important;
    }

    .nav-item {
        margin-bottom: 15px !important;
    }

    /* .sidebar{
        padding: 0px !important;
    } */
</style>