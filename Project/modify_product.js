function edit_row(id)
{
     var pro_id = document.getElementById("pro_id_val"+id).innerHTML;
     var pro_name = document.getElementById("pro_name_val"+id).value;
     var pro_detail = document.getElementById("pro_detail_val"+id).value;
     var pro_amount = document.getElementById("pro_amount_val"+id).innerHTML;
     var pro_discount = document.getElementById("pro_discount_val"+id).value;
     //var pro_picture = document.getElementById("pro_picture_val"+id).value;
     var pro_annotation = document.getElementById("pro_annotation_val"+id).value;
     var pro_type_id = document.getElementById("pro_type_id_val"+id).value;
     var pro_unit_id = document.getElementById("pro_unit_id_val"+id).value;
     var pro_price = document.getElementById("pro_price_val"+id).value;
     var pro_unit_val = document.getElementById("pro_unit_val"+id).innerHTML;
    
    //select.options[select.selectedIndex].value;

     document.getElementById("edit_pro_id").value = pro_id;
     document.getElementById("edit_id").value = id;
     document.getElementById("edit_pro_type").value = pro_type_id;
     document.getElementById("edit_pro_name").value = pro_name;
     document.getElementById("edit_pro_detail").value = pro_detail;
     document.getElementById("edit_pro_price").value = parseFloat(pro_price);
     document.getElementById("edit_pro_amount").value = pro_amount;
     document.getElementById("edit_pro_unit").value = pro_unit_id;
     document.getElementById("edit_pro_discount").value = pro_discount;
     //document.getElementById("edit_pro_picture").value = pro_picture;
     document.getElementById("edit_pro_annotation").value = pro_annotation;
    
}

function save_row()
{
     var pro_id = document.getElementById("edit_id").value;
     var pro_type = document.getElementById("edit_pro_type").value;
     var pro_name = document.getElementById("edit_pro_name").value;
     var pro_detail = document.getElementById("edit_pro_detail").value;
     var pro_price = document.getElementById("edit_pro_price").value;
     var pro_amount = document.getElementById("edit_pro_amount").value;
     var pro_unit = document.getElementById("edit_pro_unit").value;
     var pro_discount = document.getElementById("edit_pro_discount").value;
     //var pro_picture = document.getElementById("edit_pro_picture").value;
     var pro_annotation = document.getElementById("edit_pro_annotation").value;
    
     $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการแก้ไขรายการข้อมูลสินค้าใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                          type:'post',
                          url:'product_page.php',
                          data:{
                           edit_row:'edit_row',
                           row_id:pro_id,
                           pro_type_val:pro_type,
                           pro_name_val:pro_name,
                           pro_detail_val:pro_detail,
                           pro_price_val:pro_price,
                           pro_amount_val:pro_amount,
                           pro_unit_val:pro_unit,
                           pro_discount_val:pro_discount,
                           /*pro_picture_val:pro_picture,*/
                           pro_annotation_val:pro_annotation},
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
            content: 'คุณต้องการลบรายการข้อมูลสินค้าใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                        type:'post',
                        url:'product_page.php',
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

function insert_row()
{
    var pro_type = document.getElementById("new_pro_type").value;
    var pro_name = document.getElementById("new_pro_name").value;
    var pro_detail = document.getElementById("new_pro_detail").value;
    var pro_price = document.getElementById("new_pro_price").value;
    var pro_amount = document.getElementById("new_pro_amount").value;
    var pro_unit = document.getElementById("new_pro_unit").value;
    var pro_discount = document.getElementById("new_pro_discount").value;
    var pro_annotation = document.getElementById("new_pro_annotation").value;
    //var text = false;
    //alert(pro_type+" "+pro_name+" "+pro_detail+" "+pro_price+" "+pro_amount+" "+pro_unit+" "+pro_discount+" "+pro_annotation);
    
    $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการเพิ่มรายการข้อมูลสินค้าใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                          type:'post',
                          url:'product_page.php',
                          data:{
                           insert_row:'insert_row',
                           pro_type_val:pro_type,
                           pro_name_val:pro_name,
                           pro_detail_val:pro_detail,
                           pro_price_val:pro_price,
                           pro_amount_val:pro_amount,
                           pro_unit_val:pro_unit,
                           pro_discount_val:pro_discount,
                           /*pro_picture_val:pro_picture,*/
                           pro_annotation_val:pro_annotation},
                           success:function(response) {
                               location.reload(false);
                          },
                    });
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการเพิ่มแล้ว!');
                }
            }
    })
}

function view_row(id)
{
    var pro_id = document.getElementById("pro_id_val"+id).innerHTML;
    var pro_name = document.getElementById("pro_name_val"+id).value;
    var pro_detail = document.getElementById("pro_detail_val"+id).value;
    var pro_amount = document.getElementById("pro_amount_val"+id).innerHTML;
    var pro_discount = document.getElementById("pro_discount_val"+id).value;
    //var pro_picture = document.getElementById("pro_picture_val"+id).value;
    var pro_annotation = document.getElementById("pro_annotation_val"+id).value;
    var pro_type_id = document.getElementById("pro_type_id_val"+id).value;
    var pro_unit_id = document.getElementById("pro_unit_id_val"+id).value;
    var pro_price = document.getElementById("pro_price_val"+id).value;
    
    var price = formatCurrency(pro_price);
    
    document.getElementById("view_pro_id").value = pro_id;
    document.getElementById("view_pro_type").value = pro_type_id;
    document.getElementById("view_pro_name").value = pro_name;
    document.getElementById("view_pro_detail").value = pro_detail;
    document.getElementById("view_pro_price").value = price;
    document.getElementById("view_pro_amount").value = pro_amount;
    document.getElementById("view_pro_unit").value = pro_unit_id;
    document.getElementById("view_pro_discount").value = pro_discount;
    //document.getElementById("view_pro_picture").value = pro_picture;
    document.getElementById("view_pro_annotation").value = pro_annotation;   
}

function formatCurrency(number) {
    number = parseFloat(number);
    return number.toFixed(2).replace(/./g, function(c, i, a) {
        return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
    });
}

function insert(){
   var pro_type = document.getElementById("new_pro_type").value;
    var pro_name = document.getElementById("new_pro_name").value;
    var pro_detail = document.getElementById("new_pro_detail").value;
    var pro_price = document.getElementById("new_pro_price").value;
    var pro_amount = document.getElementById("new_pro_amount").value;
    var pro_unit = document.getElementById("new_pro_unit").value;
    var pro_discount = document.getElementById("new_pro_discount").value;
    var pro_annotation = document.getElementById("new_pro_annotation").value; 
    
    alert(pro_type+" "+pro_name+" "+pro_detail+" "+pro_price+" "+pro_amount+" "+pro_unit+" "+pro_discount+" "+pro_annotation);
}