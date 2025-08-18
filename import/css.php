<link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="assets/css/sb-admin-2.css" rel="stylesheet">
<link href="assets/css/style_rutine.css" rel="stylesheet">
<link rel="stylesheet" href="assets/vendor/datepicker/dist/css/datepicker.min.css">

<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">



<link rel="stylesheet" href="assets/vendor/jquery-confirm-v3.3.4/css/jquery-confirm.css">
<link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="assets/plugins/select2/select2.css" />
<link rel="stylesheet" type="text/css" href="assets/plugins/sweetalert/sweetalert2.css" />
<!-- <link rel="stylesheet" type="text/css" href="assets/plugins/Dropify/dd.css" /> -->
<link rel="stylesheet" type="text/css" href="assets/plugins/dropifyM/dist/css/dropify.css" />


<link rel="stylesheet" type="text/css" href="assets/css/fixedColumns.bootstrap4.css" />
<link rel="stylesheet" href="assets/loadding/jquery.loadingModal.min.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->

<style>



/* ให้ Sidebar สูงเต็ม body */
#accordionSidebar {
  height: 100%;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

/* ส่วนเมนูเลื่อน scroll ได้ */
.sb-sidenav-menu {
  flex: 1 1 auto;
  overflow-y: auto;
}

/* ปุ่ม logout ติดล่าง */
#li_logout {
  background: #194185;
  padding: 10px;
  text-align: center;
}

    #table_DepRoom_rfid_movement thead th:nth-child(-n+7),
    #table_DepRoom_rfid_movement tbody td:nth-child(-n+7) {
        min-width: 80px;
        /* ปรับค่าตามจริงของแต่ละคอลัมน์ */
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    #table_DepRoom_movement thead th:nth-child(-n+7),
    #table_DepRoom_movement tbody td:nth-child(-n+7) {
        min-width: 80px;
        /* ปรับค่าตามจริงของแต่ละคอลัมน์ */
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    #table_DepRoom_normal_movement thead th:nth-child(-n+7),
    #table_DepRoom_normal_movement tbody td:nth-child(-n+7) {
        min-width: 80px;
        /* ปรับค่าตามจริงของแต่ละคอลัมน์ */
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }


    /* th:nth-child(1),
    td:nth-child(1) {
        min-width: 50px !important;
    } */

    .position-relative {
        width: 100%;
        /* ปรับขนาดตามต้องการ */
    }

    .input-icon {
        position: absolute;
        right: 18px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.2em;
        pointer-events: none;
        /* ไม่ให้คลิกโดนไอคอน */
    }

    .tab-button-group {
        display: inline-flex;
        /* เปลี่ยนจาก flex -> inline-flex */
        flex-wrap: wrap;
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 8px;
        background-color: #fff;
        gap: 8px;
    }

    .tab-button {
        padding: 8px 16px;
        background-color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        color: #333;
        transition: background-color 0.3s;
        white-space: nowrap;
    }

    .tab-button.active {
        background-color: #f1e9f9;
    }

    .tab-button-group {
        display: inline-flex;
        /* เปลี่ยนจาก flex -> inline-flex */
        flex-wrap: wrap;
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 8px;
        background-color: #fff;
        gap: 8px;
    }

    .tab-button2 {
        padding: 8px 16px;
        background-color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        color: #333;
        transition: background-color 0.3s;
        white-space: nowrap;
    }

    .tab-button2.active {
        background-color: #f1e9f9;
    }

    /* ::-webkit-input-placeholder {
   text-align: center;
} */
    .custom-switch.custom-switch-lg .custom-control-label::before,
    .custom-switch.custom-switch-lg .custom-control-label::after {
        top: 0.25rem;
        width: 3rem;
        height: 1.5rem;
    }

    .custom-switch.custom-switch-lg .custom-control-label::after {
        width: 1.5rem;
        height: 1.5rem;
        top: 0.25rem;
    }

    .custom-switch.custom-switch-lg .custom-control-input:checked~.custom-control-label::after {
        transform: translateX(1.5rem);
    }

    .custom-switch.custom-switch-lg .custom-control-label {
        font-size: 1.2rem;
        padding-left: 3.5rem;
    }

    .custom-label {
        display: inline-block;
        padding: 8px 15px;
        /* เพิ่มระยะขอบ */
        border: 2px solid #5A3187;
        /* เส้นขอบสีฟ้า */
        border-radius: 8px;
        /* มุมโค้งมน */
        font-size: 16px;
        font-weight: bold;
        color: #5A3187;
        background-color: #F5F0FA;
        /* สีพื้นหลัง */
    }

    .custom-label:hover {
        background-color: #5A3187;
        color: white;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    thead {
        background-color: #F2F4F7 !important;
        line-height: 35px;
    }

    /* input[id^="input_return_claim"]::-webkit-input-placeholder {
        color: white !important;
    } */
    /* input[id^="input_return_ex"]::-webkit-input-placeholder {
        color: white !important;
    } */
    tr {
        font-size: 16px;
    }

    td {
        font-size: 16px;
    }

    .red-text {
        color: red;
        font-size: 0.8em;
        /* ปรับขนาดฟอนต์ */
        margin-top: -10px;
    }

    .primary-text {
        color: #009900;
        font-size: 0.8em;
        /* ปรับขนาดฟอนต์ */
        margin-top: -10px;
    }

    .success-text {
        color: #0000CC;
        font-size: 0.8em;
        /* ปรับขนาดฟอนต์ */
        margin-top: -10px;
    }

    [aria-controls="select2-input_itemname_itemcode-container"] {
        background-color: #fff !important;
        border: 1px solid #aaa !important;
        border-radius: 4px !important;
        height: 53px !important;
    }

    #select2-input_itemname_itemcode-container {
        color: #444 !important;
        line-height: 45px !important;
        font-size: 25px !important;
    }

    #image-viewer {
        display: none;
        position: fixed;
        z-index: 9999;
        padding-top: 100px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.9);
    }

    .modal-contentx {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    .modal-contentx {
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @keyframes zoom {
        from {
            transform: scale(0)
        }

        to {
            transform: scale(1)
        }
    }

    #image-viewer .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    #image-viewer .close:hover,
    #image-viewer .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }


    ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    /* input[id^="input_stock_back"]::-webkit-input-placeholder {
        color: white !important;
    } */

    input[id^="input_stockmain"]::-webkit-input-placeholder {
        color: white !important;
    }

    .notification-drop {
        font-family: 'Ubuntu', sans-serif;
        color: #444;
    }

    .notification-drop .item {
        padding: 10px;
        font-size: 18px;
        position: relative;
        border-bottom: 1px solid #ddd;
    }

    .notification-drop .item:hover {
        cursor: pointer;
    }

    .notification-drop .item i {
        margin-left: 10px;
    }

    .notification-drop .item ul {
        display: none;
        position: absolute;
        top: 100%;
        background: #fff;
        left: -200px;
        right: 0;
        z-index: 1;
        border-top: 1px solid #ddd;
    }

    .notification-drop .item ul li {
        font-size: 16px;
        padding: 15px 0 15px 25px;
    }

    .notification-drop .item ul li:hover {
        background: #ddd;
        color: rgba(0, 0, 0, 0.8);
    }

    @media screen and (min-width: 500px) {
        .notification-drop {
            display: flex;
            /* justify-content: flex-end; */
        }

        .notification-drop .item {
            border: none;
        }
    }



    .notification-bell {
        font-size: 35px;
    }

    .btn__badge {
        background: #FF5D5D;
        color: white;
        font-size: 12px;
        position: absolute;
        top: 0;
        right: 0px;
        padding: 3px 10px;
        border-radius: 50%;
    }

    .pulse-button {
        box-shadow: 0 0 0 0 rgba(255, 0, 0, 0.5);
        -webkit-animation: pulse 1.5s infinite;
    }

    .pulse-button:hover {
        -webkit-animation: none;
    }

    @-webkit-keyframes pulse {
        0% {
            -moz-transform: scale(0.9);
            -ms-transform: scale(0.9);
            -webkit-transform: scale(0.9);
            transform: scale(0.9);
        }

        70% {
            -moz-transform: scale(1);
            -ms-transform: scale(1);
            -webkit-transform: scale(1);
            transform: scale(1);
            box-shadow: 0 0 0 50px rgba(255, 0, 0, 0);
        }

        100% {
            -moz-transform: scale(0.9);
            -ms-transform: scale(0.9);
            -webkit-transform: scale(0.9);
            transform: scale(0.9);
            box-shadow: 0 0 0 0 rgba(255, 0, 0, 0);
        }
    }


    .colorG {
        background-color: #66CC66;
    }


    .wrapper {
        position: relative;
        width: 400px;
        height: 200px;
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .signature-pad {
        position: absolute;
        left: 0;
        top: 0;
        width: 400px;
        height: 200px;
        background-color: white;
    }


    #accordionSidebar::-webkit-scrollbar {
        display: none;
    }

    @font-face {
        font-family: myFirstFont;
        src: url("assets/fonts/DB Helvethaica X.ttf");
    }


    body {
        font-family: "Noto Sans Thai", sans-serif;
        /* font-family: myFirstFont; */
        font-size: 18px;
    }

    .f24 {
        font-size: 24px;
    }

    .f20 {
        font-size: 20px;
    }

    .f18 {
        font-size: 18px;
    }

    .f16 {
        font-size: 16px;
    }

    .f14 {
        font-size: 14px;
    }

    /* span {
        font-size: 16px !important;
    } */

    .datepicker {
        z-index: 9999;
    }

    .colorRed {
        background-color: #f8aeae;
    }

    .list-group.list-group-tree {
        padding: 0;
    }

    .list-group.list-group-tree .list-group {
        margin-bottom: 0;
    }

    .list-group.list-group-tree>.list-group>.list-group-item {
        padding-left: 30px;
    }

    .list-group.list-group-tree>.list-group>.list-group>.list-group-item {
        padding-left: 45px;
    }

    .list-group.list-group-tree>.list-group>.list-group>.list-group-item>.list-group-item {
        padding-left: 60px;
    }

    .list-group.list-group-tree>.list-group>.list-group>.list-group-item>.list-group-item>.list-group-item {
        padding-left: 75px;
    }

    .list-group.list-group-tree>.list-group>.list-group>.list-group-item>.list-group-item>.list-group-item>.list-group-item {
        padding-left: 90px;
    }


    a:link {
        text-decoration: none;
    }





    .list-group-item .fa {
        margin-right: 5px;
    }

    .fa-chevron:before {
        content: "\f054";
        /*right*/
    }

    .in>.fa-chevron:before {
        content: "\f078";
        /*down*/
    }
</style>