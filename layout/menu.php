        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion " id="accordionSidebar" style="background-color: #004aad;overflow-y: auto;border: 2px solid #D0D5DD;">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-text mx-3 color_menu">
                    <img src="assets/img/logo.png" alt="" style="width: 100%;" id="img_logo">
                </div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- <p style="text-align: center;color: white;" class="mb-0 f16" >
               <span id="span_deproom">Operating Room (SMC)</span>
            </p>
            <p style="text-align: center;color: white;" class="mb-0 f14" >
               <span id="span_site">Sriphat Medical Center Chiang Mai</span>
            </p> -->
            <div class="sb-sidenav-menu" id="mydiv" style="flex-grow:1;overflow-y: auto;max-height: 1000px;flex-grow:1;">
                <li class="nav-item  py-2 collapse-inner rounded m-3 text-center" id="li_main">
                    <a class="collapse-item" href="pages/main.php" style="color: black;font-size: 16px;" id="a_main">
                        <img id="ic_mainpage" style="width: 65px;margin-left: 35px;display: block;margin-left: auto;margin-right: auto;">
                        <label style="font-size: 20px;color: white;" class="color_menu" id="menu1">หน้าหลัก</label>

                        <p class="timertext" style="font-size: 1.5rem;" hidden>
                            You are idle for
                            <span class="secs"></span> seconds.
                        </p>
                    </a>
                </li>


                <?php if ($RefDepID == "36DEN") { ?>
                    <li class="nav-item  py-2 collapse-inner rounded m-3 text-center" id="li_surgery" hidden>
                        <a class="collapse-item" href="pages/surgery.php" style="color: black;font-size: 16px;" id="a_surgery">
                            <img id="ic_operation_room" style="width: 65px;margin-left: 35px;display: block;margin-left: auto;margin-right: auto;">
                            <label style="font-size: 20px;color: white;" class="color_menu" id="">ห้องผ่าตัด</label>
                        </a>
                    </li>
                <?php } ?>




                <li class="nav-item  py-2 collapse-inner rounded m-3 text-center" id="li_recieve_stock" hidden>
                    <a class="collapse-item" href="pages/recieve_stock.php" style="color: black;font-size: 16px;" id="a_recieve_stock">
                        <img id="ic_setup_equipment_rooms" style="width: 65px;margin-left: 35px;display: block;margin-left: auto;margin-right: auto;">
                        <label style="font-size: 20px;color: #667085;" class="color_menu" id="menu2">รับอุปกรณ์เข้าคลัง</label>
                    </a>
                </li>

                <li class="nav-item  py-2 collapse-inner rounded m-3 text-center" id="li_set_hn" hidden>
                    <a class="collapse-item" href="pages/set_hn.php" style="color: black;font-size: 16px;" id="a_set_hn">
                        <img id="ic_set_hn" style="width: 65px;margin-left: 35px;display: block;margin-left: auto;margin-right: auto;">
                        <label style="font-size: 20px;color: #667085;" class="color_menu" id="menu16">กรอกข้อมูลคนไข้</label>
                    </a>
                </li>

                <li class="nav-item  py-2 collapse-inner rounded m-3 text-center" id="li_create_request" hidden>
                    <a class="collapse-item" href="index.php?s=create_request" style="color: black;font-size: 16px;" id="a_create_request">
                        <img id="ic_create_equipment_request" style="width: 65px;margin-left: 35px;display: block;margin-left: auto;margin-right: auto;">
                        <label style="font-size: 20px;color: #667085;" class="color_menu" id="menu3">สร้างใบขอเบิกอุปกรณ์</label>
                    </a>
                </li>


                <li class="nav-item  py-2 collapse-inner rounded m-3 text-center" id="li_pay" hidden>
                    <a class="collapse-item" href="pages/pay.php" style="color: black;font-size: 16px;" id="a_pay">
                        <img id="ic_dispense_equipment" style="width: 65px;margin-left: 35px;display: block;margin-left: auto;margin-right: auto;">
                        <label style="font-size: 20px;color: #667085;" class="color_menu" id="menu4">จ่ายอุปกรณ์</label>
                    </a>
                </li>


                <li class="nav-item  py-2 collapse-inner rounded m-3 text-center" id="li_hn" hidden>
                    <a class="collapse-item" href="pages/hn.php" style="color: black;font-size: 16px;" id="a_hn">
                        <img id="ic_search_hndata" style="width: 65px;margin-left: 35px;display: block;margin-left: auto;margin-right: auto;">
                        <label style="font-size: 20px;color: #667085;" class="color_menu" id="menu9">สืบค้นข้อมูล HN</label>
                    </a>
                </li>

                <li class="nav-item  py-2 collapse-inner rounded m-3 text-center" id="li_movement" hidden>
                    <a class="collapse-item" href="pages/movement.php" style="color: black;font-size: 16px;" id="a_movement">
                        <img id="ic_movement" style="width: 65px;margin-left: 35px;display: block;margin-left: auto;margin-right: auto;">
                        <label style="font-size: 20px;color: #667085;" class="color_menu" id="menu11">ความเคลื่่อนไหว</label>
                    </a>
                </li>

                <li class="nav-item  py-2 collapse-inner rounded m-3 text-center" id="li_request_item" hidden>
                    <a class="collapse-item" href="pages/request_item.php" style="color: black;font-size: 16px;" id="a_request_item">
                        <img id="ic_request_item" style="width: 65px;margin-left: 35px;display: block;margin-left: auto;margin-right: auto;">
                        <label style="font-size: 20px;color: #667085;" class="color_menu" id="menu15">ขอเบิกอุปกรณ์จากคลังหลัก</label>
                    </a>
                </li>


                <li class="nav-item  py-2 collapse-inner rounded m-3 text-center" id="li_report" hidden>
                    <a class="collapse-item" href="pages/report.php" style="color: black;font-size: 16px;" id="a_report">
                        <img id="ic_turnon_offdisplay_3" style="width: 65px;margin-left: 35px;display: block;margin-left: auto;margin-right: auto;">
                        <label style="font-size: 20px;color: #667085;" class="color_menu" id="menu14">รายงาน</label>
                    </a>
                </li>


                <li class="nav-item  py-2 collapse-inner rounded m-3 text-center" id="li_adjuststock" hidden>
                    <a class="collapse-item" href="pages/adjuststock.php" style="color: black;font-size: 16px;" id="a_adjuststock">
                        <img id="ic_adjust_stock" style="width: 65px;margin-left: 35px;display: block;margin-left: auto;margin-right: auto;">
                        <label style="font-size: 20px;color: #667085;" class="color_menu" id="menu12">ปรับยอดสต๊อก</label>
                    </a>
                </li>

                <li class="nav-item  py-2 collapse-inner rounded m-3 text-center" id="li_register_item" hidden>
                    <a class="collapse-item" href="pages/register_item.php" style="color: black;font-size: 16px;" id="a_register_item">
                        <img id="ic_register_equipment" style="width: 65px;margin-left: 35px;display: block;margin-left: auto;margin-right: auto;">
                        <label style="font-size: 20px;color: #667085;" class="color_menu" id="menu7">ลงทะเบียนอุปกรณ์</label>
                    </a>
                </li>


                <li class="nav-item  py-2 collapse-inner rounded m-3 text-center" id="li_stock_item" hidden>
                    <a class="collapse-item" href="pages/stock_item.php" style="color: black;font-size: 16px;" id="a_stock_item">
                        <img id="ic_inventory_tools" style="width: 65px;margin-left: 35px;display: block;margin-left: auto;margin-right: auto;">
                        <label style="font-size: 20px;color: #667085;" class="color_menu" id="menu8">คลังและเครื่องมือ</label>
                    </a>
                </li>

                <li class="nav-item  py-2 collapse-inner rounded m-3 text-center" id="li_receive_dirty" hidden>
                    <a class="collapse-item" href="pages/receive_dirty.php" style="color: black;font-size: 16px;" id="a_receive_dirty">
                        <img id="ic_receive_contaminated_equipment" style="width: 65px;margin-left: 35px;display: block;margin-left: auto;margin-right: auto;">
                        <label style="font-size: 20px;color: #667085;" class="color_menu" id="menu5">รับอุปกรณ์ปนเปื้อน</label>
                    </a>
                </li>

                <li class="nav-item  py-2 collapse-inner rounded m-3 text-center" id="li_send-n-sterile" hidden>
                    <a class="collapse-item" href="pages/send-n-sterile.php" style="color: black;font-size: 16px;" id="a_send-n-sterile">
                        <img id="ic_send_nsterile" style="width: 65px;margin-left: 35px;display: block;margin-left: auto;margin-right: auto;">
                        <label style="font-size: 20px;color: #667085;" class="color_menu" id="menu6">ส่งไป N Sterile</label>
                    </a>
                </li>


                <li class="nav-item  py-2 collapse-inner rounded m-3 text-center" id="li_setting" hidden>
                    <a class="collapse-item" href="pages/setting.php" style="color: black;font-size: 16px;" id="a_setting">
                        <img id="ic_turnon_offdisplay" style="width: 65px;margin-left: 35px;display: block;margin-left: auto;margin-right: auto;">
                        <label style="font-size: 20px;color: #667085;" class="color_menu" id="menu10">เปิด/ปิดการแสดงผล</label>
                    </a>
                </li>


                <li class="nav-item  py-2 collapse-inner rounded m-3 text-center" id="li_manage" hidden>
                    <a class="collapse-item" href="pages/manage.php" style="color: black;font-size: 16px;" id="a_manage">
                        <img id="ic_turnon_offdisplay_2" style="width: 65px;margin-left: 35px;display: block;margin-left: auto;margin-right: auto;">
                        <label style="font-size: 20px;color: #667085;" class="color_menu" id="menu13">จัดการข้อมูลระบบ</label>
                    </a>
                </li>



                <li class="nav-item  py-2 collapse-inner rounded m-3 text-center" id="li_permission">
                    <a class="collapse-item" href="pages/permission.php" style="color: black;font-size: 16px;" id="a_permission">
                        <img id="ic_permission" style="width: 65px;margin-left: 35px;display: block;margin-left: auto;margin-right: auto;">
                        <label style="font-size: 17px;color: #667085;" class="color_menu" id="menu17">กำหนดสิทธิการเข้าถึง</label>
                    </a>
                </li>









                <hr class="sidebar-divider d-none d-md-block">




                <?php if ($RefDepID == "nsterile") { ?>
                    <li class="nav-item  py-2 collapse-inner rounded m-3 text-center" id="li_receive_dirty">
                        <a class="collapse-item" href="pages/receive_dirty.php" style="color: black;font-size: 16px;" id="a_receive_dirty">
                            <img id="ic_receive_contaminated_equipment" style="width: 65px;margin-left: 35px;display: block;margin-left: auto;margin-right: auto;">
                            <label style="font-size: 20px;color: #667085;" class="" id="menu5">รับอุปกรณ์ปนเปื้อน</label>
                        </a>
                    </li>

                    <li class="nav-item  py-2 collapse-inner rounded m-3 text-center" id="li_send-n-sterile">
                        <a class="collapse-item" href="pages/send-n-sterile.php" style="color: black;font-size: 16px;" id="a_send-n-sterile">
                            <img id="ic_send_nsterile" style="width: 65px;margin-left: 35px;display: block;margin-left: auto;margin-right: auto;">
                            <label style="font-size: 20px;color: #667085;" class="" id="menu6">ส่งไป N Sterile</label>
                        </a>
                    </li>
                <?php } ?>


            </div>

            <div style="padding: 10px; text-align: center;background: #194185; " id="li_logout">
                <i class="fa-solid fa-right-from-bracket" style="color: #ffff;font-size: 65px;margin-left: 35px;display: block;margin-left: auto;margin-right: auto;"></i>
                <label style="font-size: 20px;color: white;" id="menu_logout">ออกจากระบบ</label>
            </div>


            <!-- <div class="sb-sidenav-footer">
                <li class="nav-item  py-2 collapse-inner rounded  text-center" id="li_logout" style="background: #194185;">
                    <a class="collapse-item" href="#" style="color: black;font-size: 16px;">
                        <i class="fa-solid fa-right-from-bracket" style="color: #ffff;font-size: 65px;margin-left: 35px;display: block;margin-left: auto;margin-right: auto;"></i>
                        <label style="font-size: 20px;color: white;">ออกจากระบบ</label>
                    </a>
                </li>
            </div> -->
















            <!-- <li class="nav-item " id="li_logout">
                <a class="nav-link" href="#">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>ออก</span></a>
            </li>  -->
            <!-- 
           <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div> -->






            <!-- <li class="nav-item " id="li_main">
                <a class="nav-link" href="index.php?page=main">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>หน้าหลัก</span></a>
            </li>

            <?php if ($RefDepID == "36DEN") { ?>
                <li class="nav-item " id="li_roomcheck">
                    <a class="nav-link" href="index.php?page=roomcheck">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>ห้องตรวจ</span></a>
                </li>



            <?php } ?>


            <?php if ($RefDepID == "10106103") { ?>


                <li class="nav-item " id="li_rutine">
                    <a class="nav-link" href="index.php?page=rutine">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>ตั้งค่าจ่ายอุปกรณ์ให้ห้องตรวจ</span></a>
                </li>

                <li class="nav-item" id="li_pay_roomcheck">
                    <a class="nav-link" href="index.php?page=pay_roomcheck">
                        <i class="fas fa-fw fa-table"></i>
                        <span>จ่ายอุปกรณ์ให้ห้องตรวจ</span></a>
                </li>

                <li class="nav-item" id="li_stricker">
                    <a class="nav-link" href="index.php?page=stricker">
                        <i class="fas fa-fw fa-chart-area"></i>
                        <span>รับของใช้แล้ว</span></a>
                </li>

                <li class="nav-item" id="li_send-n-sterile">
                    <a class="nav-link" href="index.php?page=send-n-sterile">
                        <i class="fas fa-fw fa-chart-area"></i>
                        <span>ส่งไป N-Sterile</span></a>
                </li>

                <li class="nav-item " id="li_stockRoom">
                    <a class="nav-link" href="index.php?page=stockRoom">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>ความเคลื่อนไหว</span></a>
                </li>

                <li class="nav-item " id="li_report">
                    <a class="nav-link" href="index.php?page=report">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>รายงาน</span></a>
                </li>

                <li class="nav-item" id="li_return_mainstock" hidden>
                    <a class="nav-link" href="index.php?page=return_mainstock">
                        <i class="fas fa-fw fa-table"></i>
                        <span>ใช้แล้ว-คืนสต๊อกหลัก</span></a>
                </li>



                <li class="nav-item" id="li_movement" hidden>
                    <a class="nav-link" href="index.php?page=movement">
                        <i class="fas fa-fw fa-table"></i>
                        <span>ความเคลื่อนไหว</span></a>
                </li>




                <hr class="sidebar-divider d-none d-md-block">

            <?php } ?>

            <li class="nav-item " id="li_logout">
                <a class="nav-link" href="#">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>ออก</span></a>
            </li> -->

            <!-- <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div> -->

        </ul>