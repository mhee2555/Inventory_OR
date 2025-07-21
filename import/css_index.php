<!-- <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->
<!-- <link href="assets/css/input.css" rel="stylesheet"> -->
<!-- <link href="assets/css/styleLogin.css" rel="stylesheet"> -->
<!-- <link href="assets/css/sb-admin-2.css" rel="stylesheet"> -->
<link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap/css/datepicker3.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="assets/vendor/jquery-confirm-v3.3.4/css/jquery-confirm.css">
<link rel="stylesheet" type="text/css" href="assets/plugins/sweetalert/sweetalert2.css" />
<link rel="stylesheet" type="text/css" href="assets/plugins/select2/select2_index.css" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">



<style>
    @font-face {
        font-family: myFirstFont;
        src: url("assets/fonts/DB Helvethaica X.ttf");

    }


    body {
        font-family: myFirstFont;
        font-size: 25px;
                background: linear-gradient(to right, #cbb8e5 50%, #65d4c0 50%);
        margin: 0;
        padding: 0;
    }

    .main-container {
        display: flex;
        height: 100vh;
        justify-content: center;
        align-items: center;
        padding: 10px;
    }

    .login-box {
        width: 100%;
        max-width: 1300px;
        height: 760px;
        background-color: white;
        display: flex;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .left-panel {
        width: 50%;
        background-color: white;
        padding:  60px;
    }

    .right-panel {
        width: 50%;
        background: url('assets/img/img_login.png') no-repeat center center;
        background-size: cover;
    }

    .form-control {
        height: 45px;
        border-radius: 8px;
        font-size: 16px;
    }

    .btn-login {
        background-color: #6b2da5;
        color: white;
        font-weight: bold;
        height: 45px;
        border-radius: 8px;
        font-size: 23px;
    }

    .btn-login:hover {
        background-color: #5a2393;
    }

    .custom-checkbox {
        margin-top: 10px;
    }

    .logo {
        text-align: center;
        margin-bottom: 30px;
    }

    .logo img {
        height: 100px;
    }

    /* ส่วนของ Responsive Mobile */
    @media (max-width: 768px) {
        .login-box {
            flex-direction: column;
            height: auto;
        }

        .left-panel,
        .right-panel {
            width: 100%;
            height: auto;
        }

        .right-panel {
            order: -1;
            min-height: 200px;
        }

        .left-panel {
            padding: 50px 20px;
        }

        .form-control,
        .btn-login {
            font-size: 16px;
            height: 44px;
        }

        h3,
        h5 {
            font-size: 20px;
        }

        .text-muted {
            font-size: 14px;
        }
    }

    /* .sidebar{
        padding: 0px !important;
    } */
</style>