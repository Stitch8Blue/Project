function edit_row(id)
{
     var pro_type_id = document.getElementById("pro_type_id_val"+id).innerHTML;
     var pro_type_name = document.getElementById("pro_type_name_val"+id).innerHTML;

     document.getElementById("edit_pro_type_id").value = pro_type_id;
     document.getElementById("edit_pro_type_name").value = pro_type_name;  
}

function save_row()
{
     var pro_type_id = document.getElementById("edit_pro_type_id").value;
     var pro_type_name = document.getElementById("edit_pro_type_name").value;

     $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการแก้ไขรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                          type:'post',
                          url:'product_type_page.php',
                          data:{
                           edit_row:'edit_row',
                           row_id:pro_type_id,
                           pro_type_name_val:pro_type_name},
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
            content: 'คุณต้องการลบรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                        type:'post',
                        url:'product_type_page.php',
                        data:{delete_row:'delete_row',
                        row_id:id},
                        success: function(response){
                            location.reload(false); 
                        }
                    });
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการลบรายการข้อมูลแล้ว!');
                }
            }
    });
}

function insert_row()
{
    var pro_type_name = document.getElementById("new_pro_type_name").value;
    
    $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการเพิ่มรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                        type:'post',
                        url:'product_type_page.php',
                        data:{insert_row:'insert_row',
                        pro_type_name:pro_type_name},
                        success: function(response){
                            location.reload(false); 
                        }
                    });
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการเพิ่มรายการข้อมูลแล้ว!');
                    document.getElementById("new_pro_type_name").value = "";
                    setTimeout("location.reload(false)",1500);
                }
            }
    });  
}