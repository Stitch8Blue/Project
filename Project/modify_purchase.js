function edit_po(id)
{
    $.ajax({
        type:'post',
        url:'purchase_page2.php',
        data:{edit_po:'edit_po',
              row_id:id},
        success:function(response){
            window.location.href = "purchase_page2.php";
        }
    });
}

function save_row()
{
     var emp_id = document.getElementById("edit_emp_id").value;
     var emp_name = document.getElementById("edit_emp_name").value;
     var emp_user = document.getElementById("edit_emp_user").value;
     var emp_pass = document.getElementById("edit_emp_pass").value;
     var emp_status = document.getElementById("edit_emp_status").value;

     $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการแก้ไขรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                          type:'post',
                          url:'purchase_page.php',
                          data:{
                           edit_row:'edit_row',
                           row_id:emp_id,
                           emp_name_val:emp_name,
                           emp_user_val:emp_user,
                           emp_pass_val:emp_pass,
                           emp_status_val:emp_status},
                           success:function(response) {
                               $.alert('ทำการแก้ไขแล้ว!');
                               location.reload(false);
                          }
                    });
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการแก้ไขแล้ว!');
                    location.reload(false);
                }
            }
    });
     
}

function delete_row(id)
{
    $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการลบรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                        type:'post',
                        url:'purchase_page.php',
                        data:{delete_row:'delete_row',
                        row_id:id},
                        success: function(response){
                            $.alert('ทำการลบแล้ว!');
                            location.reload(false);
                        }
                    });
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการลบแล้ว!');
                }
            }
    });
}

function approve(id){
    $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการอนุมัติรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                        type:'post',
                        url:'purchase_page.php',
                        data:{approve:'approve',
                        row_id:id},
                        success: function(response){
                            $.alert('ทำการอนุมัติแล้ว!');
                            location.reload(false);
                        }
                    });
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการอนุมัติแล้ว!');
                }
            }
    });
}

function cancel(id){
    $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการยกเลิกการสั่งซื้อรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                        type:'post',
                        url:'purchase_page.php',
                        data:{cancel:'cancel',
                        row_id:id},
                        success: function(response){
                            $.alert('ทำการยกเลิกการสั่งซื้อแล้ว!');
                            location.reload(false);
                        }
                    });
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการยกเลิกการสั่งซื้อแล้ว!');
                }
            }
    });
}