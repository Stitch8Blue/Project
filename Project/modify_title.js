function edit_row(id)
{
     var title_id = document.getElementById("title_id_val"+id).innerHTML;
     var title_name = document.getElementById("title_name_val"+id).innerHTML;

     document.getElementById("edit_title_id").value = title_id;
     document.getElementById("edit_title_name").value = title_name;  
}

function save_row()
{
     var title_id = document.getElementById("edit_title_id").value;
     var title_name = document.getElementById("edit_title_name").value;

     $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการแก้ไขรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                          type:'post',
                          url:'title_page.php',
                          data:{
                           edit_row:'edit_row',
                           row_id:title_id,
                           title_name_val:title_name},
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
                        url:'title_page.php',
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
    var title_name = document.getElementById("new_title_name").value;
    
    $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการเพิ่มรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                        type:'post',
                        url:'title_page.php',
                        data:{insert_row:'insert_row',
                        title_name:title_name},
                        success: function(data){
                            location.reload(false);

                        }
                    });
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการเพิ่มรายการข้อมูลแล้ว!');
                    document.getElementById("new_title_name").value = "";
                    setTimeout("location.reload(false)",1500);
                }
            }
    });  
}