function edit_row(id)
{
     var pro_id = document.getElementById("pro_id_val"+id).innerHTML;
     var pro_type = document.getElementById("pro_type_id_val"+id).innerHTML;
     var pro_amount = document.getElementById("pro_amount_val"+id).innerHTML;
     var pro_price = document.getElementById("price_val"+id).value;
     var pro_unit = document.getElementById("pro_unit_val"+id).innerHTML;
     var pro_name = document.getElementById("pro_name_val"+id).value;

     document.getElementById("edit_pro_id").value = pro_id+" : "+pro_name;
     document.getElementById("edit_pro_type").value = pro_type;
     document.getElementById("edit_pro_amount").value = pro_amount;
     document.getElementById("edit_pro_price").value = pro_price;
     document.getElementById("edit_pro_unit").value = pro_unit;
     document.getElementById("edit_new_pod_id").value = id;    
}

function save_row()
{
     var pro_amount = document.getElementById("edit_pro_amount").value;
     var pro_price = document.getElementById("edit_pro_price").value;
     var pod_id = document.getElementById("edit_new_pod_id").value;
 
     $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการแก้ไขรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                          type:'post',
                          url:'purchase_page2.php',
                          data:{
                           edit_row:'edit_row',
                           pod_id:pod_id,
                           pro_amount_val:pro_amount,
                           pro_price_val:pro_price},
                           success:function(response) {
                               $.alert('ทำการแก้ไขแล้ว!');
                               setTimeout("location.reload(false)",1500);
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
                        url:'purchase_page2.php',
                        data:{delete_row:'delete_row',
                        row_id:id},
                        success: function(response){
                            $.alert('ทำการลบแล้ว!');
                            setTimeout("location.reload(false)",1500);
                        }
                    });
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการลบแล้ว!');
                }
            }
    });
}

function add_item()
{  
    var po_id = document.getElementById("new_po_id").value;
    var pro_id = document.getElementById("new_pro_id").value;
    var pro_amount = document.getElementById("new_pro_amount").value;
    var pro_price = document.getElementById("new_pro_price").value;
    
    //alert(po_id+" "+pro_id+" "+pro_amount+" "+pro_price);
    
    $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการเพิ่มรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                        type:'post',
                        url:'purchase_page2.php',
                        data:{
                              add_item:'add_item',
                              po_id:po_id,
                              pro_id:pro_id,
                              pro_amount:pro_amount,
                              pro_price:pro_price},
                        success: function(data){
                            //alert(po_id+" "+pro_id+" "+pro_amount+" "+pro_price);
                            $.alert('ทำการเพิ่มข้อมูลเรียบร้อยแล้ว!');
                            setTimeout("location.reload(false)",1500);
                        }
                    });
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการเพิ่มรายการข้อมูลแล้ว!');
                    document.getElementById("new_pro_id").value = "";
                    document.getElementById("new_pro_amount").value = "";
                    document.getElementById("new_pro_price").value = "";
                    setTimeout("location.reload(false)",1500);
                }
            }
    });
    
}

function getProduct(val) {
      
        $.ajax({
            type: "POST",
            url: "purchase_page2.php",
            data: 'pro_type_id='+val,
            success: function(data){
                $("#new_pro_id").html(data);
                //document.getElementById("new_pro_name").options[val].selected = true;
        }
	});
}

function getProductID(val) {
      
        $.ajax({
            type: "POST",
            url: "purchase_page2.php",
            data: 'pro_id='+val,
            success: function(data){
                $("#new_pro_unit").html(data);
                //document.getElementById("new_pro_name").options[val].selected = true;
        }
	});
}