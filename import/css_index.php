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
    /* ===== Reset Modal Style ===== */
    #modalResetPassword .modal-content {
        border: 0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 18px 60px rgba(16, 24, 40, .18);
    }

    #modalResetPassword .modal-header {
        border: 0;
        padding: 18px 20px;
        background: #643695;
        color: #fff;
    }

    #modalResetPassword .modal-title {
        font-weight: 800;
        letter-spacing: .2px;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    #modalResetPassword .modal-title .badge {
        background: rgba(255, 255, 255, .18);
        border: 1px solid rgba(255, 255, 255, .25);
        color: #fff;
        font-weight: 600;
        padding: 6px 10px;
        border-radius: 999px;
    }

    #modalResetPassword .close {
        color: #fff;
        opacity: 1;
        text-shadow: none;
    }

    #modalResetPassword .modal-body {
        padding: 18px 20px 6px;
        background: #fff;
    }

    #modalResetPassword .hint-box {
        background: #F6F7FB;
        border: 1px solid #EEF2F6;
        border-radius: 12px;
        padding: 12px 14px;
        color: #344054;
        font-size: 14px;
    }

    #modalResetPassword label {
        font-weight: 700;
        color: #101828;
    }

    #modalResetPassword .form-control {
        border-radius: 12px;
        height: 46px;
        border: 1px solid #E4E7EC;
        box-shadow: none !important;
    }

    #modalResetPassword .form-control:focus {
        border-color: rgba(100, 54, 149, .6);
        box-shadow: 0 0 0 .2rem rgba(100, 54, 149, .15) !important;
    }

    #modalResetPassword .input-group-text {
        border-radius: 12px 0 0 12px;
        border: 1px solid #E4E7EC;
        background: #F9FAFB;
        color: #667085;
    }

    #modalResetPassword .input-group .form-control {
        border-left: 0;
        border-radius: 0 12px 12px 0;
    }

    #modalResetPassword .btn {
        border-radius: 12px;
        padding: 10px 14px;
        font-weight: 700;
    }

    #modalResetPassword .btn-primary {
        background: #643695;
        border: 0;
    }

    #modalResetPassword .btn-primary:hover {
        filter: brightness(.98);
    }

    #modalResetPassword .btn-secondary {
        background: #F2F4F7;
        border: 1px solid #E4E7EC;
        color: #344054;
    }

    #modalResetPassword .modal-footer {
        border: 0;
        padding: 14px 20px 18px;
        background: #fff;
    }

    #modalResetPassword .pw-meter {
        font-size: 12px;
        margin-top: 6px;
        color: #667085;
    }

    #modalResetPassword .is-match {
        color: #12B76A;
        font-weight: 700;
    }

    #modalResetPassword .not-match {
        color: #F04438;
        font-weight: 700;
    }

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
        padding: 30px;
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