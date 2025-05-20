<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>เข้าสู่ระบบ</title>
    <link rel="icon" type="image/x-icon" href="assets/img/icon_bangkok_hospital_dentistry.png">
    <?php include_once('import/css_index.php'); ?>

</head>

<!-- <body style="background-image: url(assets/img/bg-77.png);background-size: cover;"> -->

<body style="overflow-y: hidden;">



    <div class="wallpaper">




        <div class="d-flex pr-5">
            <div style="" id="div_login">
                <div class="card-body">
                    <div class="row m-0 p-0">


                        <div class="col-12 mt-2">
                            <div class="p-3">


                                <div class="text-center">
                                    <h1 class="h1  mb-4" style="color:#101828;font-weight: bold;" id="headerX">ลงชื่อเข้าใช้บัญชีของคุณ</h1>
                                    <small class="h5" id="small1">ยินดีต้อนรับ! กรุณากรอกรายละเอียดของคุณ</small>
                                </div>
                                <div class="form-group">
                                    <label for="" style="font-size: 18px;font-weight: bold;color:black;">ชื่อผู้ใช้งาน</label>
                                    <input type="text" class="form-control form-control-user" id="input_UserName" placeholder="ชื่อผู้ใช้งาน">
                                </div>
                                <div class="form-group">
                                    <label for="" style="font-size: 18px;font-weight: bold;color:black;">รหัสผ่าน</label>
                                    <input type="password" class="form-control form-control-user" id="input_PassWord" placeholder="รหัสผ่าน">
                                </div>
                                <div class="form-group" hidden>
                                    <label for="" style="font-size: 18px;font-weight: bold;color:black;">ห้องตรวจ</label>
                                    <select id="select_departmentRoom" class="form-control" style="font-size: 20px;">
                                    </select>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="" style="font-size: 18px;font-weight: bold;color:black;">เลือกแพทย์</label>
                                    <br>
                                    <select id="select_doctor" class="form-control select2" style="font-size: 20px;">
                                    </select>
                                </div> -->
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember">
                                    <label class="form-check-label" for="exampleCheck1">Remember me</label>
                                </div>

                                <button class="btn-login btn-block mt-2" id="btn_login" style="background-color: #643695 !important;">เข้าสู่ระบบ</button>

                                <hr class="mt-3">

                                <div class="form-group mt-5">
                                    <input type="text" class="form-control form-control-user" id="input_Scan" placeholder="สแกนเข้าสู่ระบบ" style="font-size: 20px;">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>








    <!-- <div class="iconHelper " id="showHelper" title="Helper">
        <div class="iconHelper d-flex align-items-center justify-content-center">
            <i class="fab fa-line rotage" style="font-size: 70px;"></i>
        </div>
    </div> -->





    <?php include_once('import/js.php'); ?>
    <script src="assets/js/input.js"></script>

    <script>
        $(function() {

            $(".select2").select2();

            var localStorageC = localStorage.getItem('checkbox');
            var localStorageD = localStorage.getItem('deproom');
            var localStorageDoctor = localStorage.getItem('doctor');
            var localStorageDoctorName = localStorage.getItem('doctorName');

            



            if (localStorageC == 1) {
                $("#remember").attr('checked', true);
                setTimeout(() => {
                    $("#select_departmentRoom").val(localStorageD);
                }, 500);
            } else {
                $("#remember").attr('checked', false);
                localStorage.removeItem('checkbox');
                localStorage.removeItem('deproom');
                localStorage.removeItem('doctor');
            }

            $("#btn_login").click(function() {

                var text = "";
                if ($("#input_UserName").val() == "") {
                    text = "กรุณากรอก UserName";
                    showDialogFailed(text);
                    return;
                }

                if ($("#input_PassWord").val() == "") {
                    text = "กรุณากรอก Password";
                    showDialogFailed(text);
                    return;
                }

                LoginUser();



            })


            $('#input_Scan').keypress(function(e) {
                if (e.which == 13) {
                    LoginUser();
                }
            });
            selection_departmentRoom();
            // selection_Doctor();
            // $(".img-background img").animate({
            //     opacity: '1'
            // }, 3500);



        })
        
        // function selection_Doctor() {
        //     $.ajax({
        //         url: "process/login.php",
        //         type: 'POST',
        //         data: {
        //             'FUNC_NAME': 'selection_Doctor',
        //         },
        //         success: function(result) {
        //             var ObjData = JSON.parse(result);
        //             console.log(ObjData);
        //             var option = `<option value="">กรุณาเลือกแพทย์</option>`;
        //             if (!$.isEmptyObject(ObjData)) {
        //                 $.each(ObjData, function(kay, value) {
        //                     option += `<option value="${value.ID}">${value.Doctor_Name}</option>`;
        //                 });
        //             } else {
        //                 option = `<option value="0">Data not found</option>`;
        //             }
        //             $("#select_doctor").html(option);


        //         }
        //     });
        // }
        function selection_departmentRoom() {
            $.ajax({
                url: "process/login.php",
                type: 'POST',
                data: {
                    'FUNC_NAME': 'selection_departmentRoom',
                },
                success: function(result) {
                    var ObjData = JSON.parse(result);
                    console.log(ObjData);
                    var option = `<option value="">กรุณาเลือกห้องตรวจ</option>`;
                    if (!$.isEmptyObject(ObjData)) {
                        $.each(ObjData, function(kay, value) {
                            option += `<option value="${value.id}">${value.departmentroomname}</option>`;
                        });
                    } else {
                        option = `<option value="0">Data not found</option>`;
                    }
                    $("#select_departmentRoom").html(option);


                }
            });
        }

        function LoginUser() {
            $.ajax({
                url: "process/login.php",
                type: 'POST',
                data: {
                    'FUNC_NAME': 'LoginUser',
                    'input_UserName': $("#input_UserName").val(),
                    'input_PassWord': $("#input_PassWord").val(),
                    'select_departmentRoom': $("#select_departmentRoom").val(),
                    // 'select_doctor': $("#select_doctor").val(),
                    'input_Scan': $("#input_Scan").val()
                },
                error: function(result) {
                    console.log(result);
                },
                success: function(result) {
                    var ObjData = JSON.parse(result);

                    if (!$.isEmptyObject(ObjData)) {

                        //  console.log(result);

                        var IsAdmin = "";

                        $.each(ObjData, function(kay, value) {
                            IsAdmin = value.IsAdmin;
                            console.log(IsAdmin);
                            if (IsAdmin == '0') {
                                // if ($("#select_departmentRoom").val() == "") {
                                //     text = "กรุณาเลือกห้องตรวจ";
                                //     showDialogFailed(text);
                                //     return;
                                // }

                                location.href = "index.php?s=main";
                            } else if (IsAdmin == '1') {
                                location.href = "index.php?s=main";
                            }

                            if ($('#remember').is(':checked')) {
                                localStorage.setItem('deproom', $("#select_departmentRoom").val());
                            
                                localStorage.setItem('checkbox', 1);
                            } else {
                                localStorage.setItem('checkbox', 0);
                            }
                            // localStorage.setItem('doctor', $("#select_doctor").val());
                            // localStorage.setItem('doctorName', $("#select2-select_doctor-container").text());

                        });
                    }else{
                        text = "ผู้ใช้หรือรหัสผ่านผิด";
                        showDialogFailed(text);

                        $("#input_Scan").val("");
                        $("#input_UserName").val("");
                        $("#input_PassWord").val("");

                    }




     

                }
            });
        }


        function LoginUser_Api() {
            $.ajax({
                url: "process/curlapi.php",
                type: 'POST',
                data: {
                    'FUNC_NAME': 'LoginUser',
                    'input_UserName': $("#input_UserName").val(),
                    'input_PassWord': $("#input_PassWord").val(),
                    'select_departmentRoom': $("#select_departmentRoom").val()
                },
                error: function(result) {
                    console.log(result);
                },
                success: function(result) {
                    var ObjData = JSON.parse(result);

                    console.log(result);
                    console.log(ObjData.user);
                    if (ObjData.user != undefined) {
                        location.href = "index.php?page=main";
                    } else {
                        showDialogFailed("ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง");
                        return;
                    }
                    //  console.log(ObjData.user);
                    //  console.log(ObjData.user.fName);
                    //  console.log(ObjData.user.lName);
                    //  console.log(ObjData.user.department.name);

                    // var IsAdmin = "";
                    // 
                    //     $.each(ObjData.user, function(kay, value) {
                    //         IsAdmin = value.IsAdmin;

                    //         if (IsAdmin == '0') {
                    //             if ($("#select_departmentRoom").val() == "") {
                    //                 text = "กรุณาเลือกห้องตรวจ";
                    //                 showDialogFailed(text);
                    //                 return;
                    //             }

                    //             location.href = "index.php?page=roomcheck";
                    //         } else if (IsAdmin == '1') {
                    //             location.href = "index.php?page=main";
                    //         }


                    //     });

                    // 


                }
            });
        }

        function showDialogFailed(text) {


            Swal.fire({
                title: "Failed!",
                text: text,
                icon: "error"
            });

        }
    </script>

</body>

</html>