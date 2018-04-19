function edit_row(id)
{
     var emp_id = document.getElementById("emp_id_val"+id).innerHTML;
     var tle_id = document.getElementById("tle_id_val"+id).value;
     var emp_name = document.getElementById("emp_name_val"+id).innerHTML;
     var emp_user = document.getElementById("emp_user_val"+id).innerHTML;

     document.getElementById("edit_emp_id").value = emp_id;
     document.getElementById("edit_tle_id").options[tle_id].selected = true; 
     document.getElementById("edit_emp_name").value = emp_name;
     document.getElementById("edit_emp_user").value = emp_user; 
}

function save_row()
{
     var emp_id = document.getElementById("edit_emp_id").value;
     var tle_id = document.getElementById("edit_tle_id").value; 
     var emp_name = document.getElementById("edit_emp_name").value;
     var emp_user = document.getElementById("edit_emp_user").value;
    
     $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการแก้ไขรายการข้อมูลพนักงานใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                           $.ajax({
                              type:'post',
                              url:'employee_page.php',
                              data:{
                               edit_row:'edit_row',
                               row_id:emp_id,
                               tle_id:tle_id,
                               emp_name_val:emp_name,
                               emp_user_val:emp_user},
                               success:function(response) {
                                   location.reload(false);
                               }
                        });                    
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการแก้ไขแล้ว!');
                }
            }
    });
     
}

function delete_row(id)
{
    $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการลบรายการข้อมูลพนักงานใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                        type:'post',
                        url:'employee_page.php',
                        data:{delete_row:'delete_row',
                        row_id:id},
                        success: function(response){
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

function insert_row(){
/*$('#formAdd').submit(function(e)
{
	e.preventDefault();*/
    
    var tle_id = document.getElementById("new_tle_id").value;
    var emp_name = document.getElementById("new_emp_name").value;
    var emp_user = document.getElementById("new_emp_user").value;
    var emp_pass = document.getElementById("new_emp_pass").value;
    var emp_pass_con = document.getElementById("new_emp_pass_con").value;
    var emp_status = document.getElementById("new_emp_status").value;
    var text_null = false;
    
    if(emp_status == "1")
     {
         emp_status = "USER";
     }
     else if(emp_status == "2")
     {
         emp_status = "ADMIN";
     }
    
    if(emp_pass != "" && emp_pass_con != "" && emp_pass == emp_pass_con && tle_id != "" && emp_name != "" && emp_user != "" && emp_status != ""){
        text_null = true;
    }
    else{
         $.alert('เติมข้อมูลไม่ครบ หรือ รหัสผ่านไม่ตรงกัน!');
    }
    
    if(text_null == true){
        $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการเพิ่มรายการข้อมูลพนักงานใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                        $.ajax({
                            type:'post',
                            url:'employee_page.php',
                            data:{insert_row:'insert_row',
                            tle_id:tle_id,    
                            emp_name:emp_name,
                            emp_user:emp_user,
                            emp_pass:emp_pass,
                            emp_status:emp_status},
                            success: function(response){
                                location.reload(false); 
                            }
                        });   
                    }                    
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการเพิ่มรายการข้อมูลพนักงานแล้ว!');
                    document.getElementById("new_tle_id").value = "";
                    document.getElementById("new_emp_name").value = "";
                    document.getElementById("new_emp_user").value = "";
                    document.getElementById("new_emp_pass").value = "";
                    document.getElementById("new_emp_pass_con").value = "";
                    document.getElementById("new_emp_status").value ="";
                    setTimeout("location.reload(false)",1500);
                }
        });
    }
//});
}

function resetpass(pass,id)
{
    $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการรีเซตรหัสผ่านพนักงานใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                            $.ajax({
                            type:'post',
                            url:'employee_page.php',
                            data:{resetpass:'resetpass',
                            id:id},
                            success: function(response){
                                $.alert('ทำการรีเซตรหัสผ่านพนักงานแล้ว!');
                                setTimeout("location.reload(false)",1500); 
                            }
                        });                
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการรีเซตรหัสผ่านพนักงานแล้ว!');
                    setTimeout("location.reload(false)",1500);
                }
            }
    });
}

function approve(id)
{
    var status = document.getElementById("emp_status_val"+id).innerHTML;
    
    $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการเปลี่ยนสถานะพนักงานใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                            $.ajax({
                            type:'post',
                            url:'employee_page.php',
                            data:{approve:'approve',
                                id:id,
                                status:status},
                            success: function(response){
                                $.alert('ทำการเปลี่ยนสถานะพนักงานแล้ว!');
                                setTimeout("location.reload(false)",1500); 
                            }
                        });                
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการเปลี่ยนสถานะพนักงานแล้ว!');
                }
            }
    });
}

function confirmPass(id){
    $.confirm({
        title: 'รหัสผ่านใหม่!',
        content: '' +
        '<form action="" ">' +
        '<div class="form-group">' +
        '<input type="password" class="name form-control" required />' +
        '</div>' +
        '</form>',
        buttons: {
            formSubmit: {
                text: 'ตกลง',
                btnClass: 'btn-blue',
                action: function () {
                    var name = this.$content.find('.name').val();
                    if(!name){
                        $.alert('กรุณาใสรหัสผ่าน');
                        return false;
                    }
                        resetpass(name,id);
                }
            },
            ยกเลิก: function () {
                //close
            },
        },
        onContentReady: function () {
            // bind to events
            var jc = this;
            this.$content.find('form').on('submit', function (e) {
                // if the user submits the form by pressing enter in the field.
                e.preventDefault();
                jc.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
    });    
}