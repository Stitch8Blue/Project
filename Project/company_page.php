<?php
    session_start();
	include("connect.php");  

	$sql = "SELECT * FROM company;";
	$query = mysqli_query($conn,$sql);

    if(isset($_POST['edit_row'])){
        $row = $_POST['row_id'];
        $com_name = $_POST['com_name'];
        $com_add = $_POST['com_address'];
        $com_tel = $_POST['com_tel'];
        $com_email = $_POST['com_email'];
        $com_people = $_POST['com_people'];
        $com_annotation = $_POST['com_annotation'];
        
        $sql_ck_update = "SELECT * FROM company WHERE (com_name = '".$com_name."' OR com_tel = '".$com_tel."' OR com_email = '".$com_email."') AND com_id != '".$row."'";
        $query_ck_update = mysqli_query($conn,$sql_ck_update);
        $num = mysqli_num_rows($query_ck_update);
        
        if($num > 0){
            $mgs = "ไม่สามารถแก้ไขข้อมูลได้ !! เนื่องจากข้อมูลถูกซ้ำ.";
            $_SESSION['mgs'] = $mgs;
        }
        else{
            $sql_edit = "UPDATE company SET com_name='".$_POST['com_name']."',com_address='".$_POST['com_address']."',com_tel='".$_POST['com_tel']."',com_email='".$_POST['com_email']."',com_people='".$_POST['com_people']."',com_annotation='".$_POST['com_annotation']."' WHERE com_id = '".$_POST['row_id']."'";
            mysqli_query($conn,$sql_edit); 
            $mgs = "ทำการแก้ไขข้อมูลแล้ว!";
            $_SESSION['mgs'] = $mgs;
        } 
        exit();
    }    

    if(isset($_POST['delete_row'])){
        $sql_delete = "DELETE FROM company WHERE com_id = '".$_POST['row_id']."'";
        
        if(mysqli_query($conn,$sql_delete)){
            $mgs = "ทำการลบข้อมูลแล้ว!";
            $_SESSION['mgs'] = $mgs;
        }
        else{
            $mgs = "ไม่สามารถลบข้อมูลได้ !! เนื่องจากข้อมูลถูกใช้อยู่.";
            $_SESSION['mgs'] = $mgs;
        } 
        exit();
    }
        
    if(isset($_POST['insert_row'])){
        
        $sql_ck_add = "SELECT * FROM company WHERE com_name = '".$_POST['com_name']."' OR com_tel = '".$_POST['com_tel']."' OR com_email = '".$_POST['com_email']."'";
        $query_ck_add = mysqli_query($conn,$sql_ck_add);
        $num = mysqli_num_rows($query_ck_add);
        
        if($num > 0){
            $mgs = "ไม่สามารถเพิ่มข้อมูลได้ !! เนื่องจากข้อมูลซ้ำ.";
            $_SESSION['mgs'] = $mgs;
        }
        else{
           $sql_add = "INSERT INTO company VALUES('','".$_POST['com_name']."','".$_POST['com_address']."','".$_POST['com_tel']."','".$_POST['com_email']."','".$_POST['com_people']."','".$_POST['com_annotation']."')";
            mysqli_query($conn,$sql_add);
            $mgs = "ทำการเพิ่มข้อมูลแล้ว!";
            $_SESSION['mgs'] = $mgs;
            
        }
        exit();
    }
?>
<html>
<head>
<title>การจัดการบริษัทจัดจำหน่าย</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="plugins/select2/select2.min.css">
    
  <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="dist/css/styleFont.css" />
    
  <script src="dist/js/app.min.js"></script>
  <script src="dist/js/demo.js"></script>
  
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
  <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <script src="plugins/fastclick/fastclick.js"></script>
  <script src="plugins/select2/select2.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
  <script src="plugins/input-mask/jquery.inputmask.js"></script>
  <script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
  
  <script>
      
  $(function () {
      
    $("#pro_table").DataTable({
                        "oLanguage": {
                        "sLengthMenu": 'แสดง _MENU_ รายการ ต่อหน้า',
                        "sZeroRecords": 'ไม่เจอข้อมูลที่ค้นหา',
                        "sInfo": 'แสดง _START_ ถึง _END_ ของ _TOTAL_ รายการ',
                        "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 รายการ",
                        "sInfoFiltered": "(จากรายการทั้งหมด _MAX_ รายการ)",
                        "sSearch": "ค้นหา :",
                        "oPaginate": {
                            "sFirst":    "หน้าแรก",
                            "sPrevious": "ก่อนหน้า",
                            "sNext":     "ถัดไป",
                            "sLast":     "หน้าสุดท้าย"
                        }
                }
        });
      $("[data-mask]").inputmask();
  });

function edit_row(id)
{
     var com_id = document.getElementById("com_id_val"+id).innerHTML;
     var com_name = document.getElementById("com_name_val"+id).innerHTML;
     var com_address = document.getElementById("com_address_val"+id).innerHTML;
     var com_tel = document.getElementById("com_tel_val"+id).innerHTML;
     var com_email = document.getElementById("com_email_val"+id).innerHTML;
     var com_people = document.getElementById("com_people_val"+id).innerHTML;
     var com_annotation = document.getElementById("com_annotation_val"+id).innerHTML;
    
     document.getElementById("edit_com_id").value = com_id;
     document.getElementById("edit_com_name").value = com_name;
     document.getElementById("edit_com_address").value = com_address;
     document.getElementById("edit_com_tel").value = com_tel;
     document.getElementById("edit_com_email").value = com_email;
     document.getElementById("edit_com_people").value = com_people;
     document.getElementById("edit_com_annotation").value = com_annotation;   
}

function save_row()
{
     var com_id = document.getElementById("edit_com_id").value;
     var com_name = document.getElementById("edit_com_name").value;
     var com_address = document.getElementById("edit_com_address").value;
     var com_tel = document.getElementById("edit_com_tel").value;
     var com_email = document.getElementById("edit_com_email").value;
     var com_people = document.getElementById("edit_com_people").value;
     var com_annotation = document.getElementById("edit_com_annotation").value;

     $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการแก้ไขรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                          type:'post',
                          url:'company_page.php',
                          data:{
                           edit_row:'edit_row',
                           row_id:com_id,
                           com_name:com_name,
                           com_address:com_address,
                           com_tel:com_tel,
                           com_email:com_email,
                           com_people:com_people,
                           com_annotation:com_annotation},
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
                        url:'company_page.php',
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
    var com_name = document.getElementById("new_com_name").value;
    var com_address = document.getElementById("new_com_address").value;
    var com_tel = document.getElementById("new_com_tel").value;
    var com_email = document.getElementById("new_com_email").value;
    var com_people = document.getElementById("new_com_people").value;                 
    var com_annotation = document.getElementById("new_com_annotation").value;
    
    if(com_name != "" && com_address != "" && com_tel != "" && com_email != "" && com_people != ""){
       $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการเพิ่มรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                        type:'post',
                        url:'company_page.php',
                        data:{insert_row:'insert_row',
                             com_name:com_name,
                             com_address:com_address,
                             com_tel:com_tel,
                             com_email:com_email,
                             com_people:com_people,
                             com_annotation:com_annotation},
                        success: function(response){
                            location.reload(false);     
                        }
                    });
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการเพิ่มรายการข้อมูลแล้ว!');
                    document.getElementById("new_com_name").value = "";
                    document.getElementById("new_com_address").value = "";
                    document.getElementById("new_com_tel").value = "";
                    document.getElementById("new_com_email").value = "";
                    document.getElementById("new_com_people").value = "";
                    document.getElementById("new_com_annotation").value = "";
                    setTimeout("location.reload(false)",1500);
                }
            }
    });
    }
    else{
        $.alert('เติมข้อมูลให้ครบ!');  
    }    
}
  </script>
  <script>
      var m = '<?=$_SESSION['mgs'];?>';
    if(m){
       $.alert(m);
       <?php unset($_SESSION['mgs']);?>
    } 
 </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<?php include("aside.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        การจัดการข้อมูลบริษัทจัดจำหน่าย
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"></a>การจัดการข้อมูล</li>
        <li class="active">บริษัทจัดจำหน่าย</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">ตารางข้อมูลบริษัทจัดจำหน่าย</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="pro_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>รหัสบริษัทจัดจำหน่าย</th>
                        <th>ชื่อบริษัทจัดจำหน่าย</th>
                        <th>ที่อยู่</th>
                        <th>เบอร์โทร</th>
                        <th>อีเมล์</th>
                        <th>บุคคลที่ติดต่อ</th>
                        <th>หมายเหตุ</th>
                        <th>การจัดการข้อมูล</th>
                    </tr>
                </thead>
                <tbody>
                <?php
					while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
					{
                ?>
                    <tr id="row<?php echo $row['com_id'];?>">
                        <td id="com_id_val<?php echo $row['com_id'];?>"><?php echo $row['com_id'];?></td>
                        <td id="com_name_val<?php echo $row['com_id'];?>"><?php echo $row['com_name'];?></td>
                        <td id="com_address_val<?php echo $row['com_id'];?>"><?php echo $row['com_address'];?></td>
                        <td id="com_tel_val<?php echo $row['com_id'];?>"><?php echo $row['com_tel'];?></td>
                        <td id="com_email_val<?php echo $row['com_id'];?>"><?php echo $row['com_email'];?></td>
                        <td id="com_people_val<?php echo $row['com_id'];?>"><?php echo $row['com_people'];?></td>
                        <td id="com_annotation_val<?php echo $row['com_id'];?>"><?php echo $row['com_annotation'];?></td>
                        <td>
                            <button class="btn btn-warning" data-toggle="modal" data-target="#myModal2" id="edit_button<?php echo $row['com_id'];?>" onclick="edit_row('<?php echo $row['com_id'];?>');"><i class="fa fa-fw fa-pencil-square-o"></i></button>
                            <button class="btn btn-danger" id="delete_button<?php echo $row['com_id'];?>" onclick="delete_row('<?php echo $row['com_id'];?>');"><i class="fa fa-fw fa-trash-o"></i></button>
                        </td> 
                    </tr>
                <?php
					}
				?>
                </tbody>
              </table>
            </div>
          </div>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">เพิ่มข้อมูลบริษัทจัดจำหน่าย</button>
                 
                <div class="modal fade" id="myModal" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">เพิ่มข้อมูลบริษัทจัดจำหน่าย</h4>
                            </div>
                            <div class="modal-body">
                                        <div class="form-group">
                                            <label>ชื่อบริษัทจัดจำหน่าย<font color="red"> *</font></label>
                                            <input type="text" class="form-control" id="new_com_name">                                            
                                        </div>
                                        <div class="form-group">
                                            <label>ที่อยู่<font color="red"> *</font></label>
                                            <textarea class="form-control" row="3" id="new_com_address"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>เบอร์โทร<font color="red"> *</font></label>
                                            <input type="text" class="form-control" id="new_com_tel" maxlength="10">
                                        </div>
                                        <div class="form-group">
                                            <label>อีเมล์<font color="red"> *</font></label>
                                            <input type="email" class="form-control" id="new_com_email">
                                        </div>
                                        <div class="form-group">
                                            <label>บุคคลที่ติดต่อ<font color="red"> *</font></label>
                                            <input type="text" class="form-control" id="new_com_people">
                                        </div>
                                        <div class="form-group">
                                            <label>หมายเหตุ</label>
                                            <input type="text" class="form-control" id="new_com_annotation">
                                        </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                                <button class="btn btn-success" onclick="insert_row()">เพิ่ม</button>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="modal fade" id="myModal2" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">แก้ไขข้อมูลบริษัทจัดจำหน่าย</h4>
                            </div>
                            <div class="modal-body">
                                        <div class="form-group">
                                            <label>รหัสบริษัทจัดจำหน่าย</label>
                                            <input type="text" class="form-control" id="edit_com_id" readonly>                                    
                                        </div>
                                        <div class="form-group">
                                            <label>ชื่อบริษัทจัดจำหน่าย<font color="red"> *</font></label>
                                            <input type="text" class="form-control" id="edit_com_name">                                          
                                        </div>
                                        <div class="form-group">
                                            <label>ที่อยู่<font color="red"> *</font></label>
                                            <textarea class="form-control" row="3" id="edit_com_address"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>เบอร์โทร<font color="red"> *</font></label>
                                            <input type="text" class="form-control" id="edit_com_tel" maxlength="10">
                                        </div>
                                        <div class="form-group">
                                            <label>อีเมล์<font color="red"> *</font></label>
                                            <input type="email" class="form-control" id="edit_com_email">
                                        </div>
                                        <div class="form-group">
                                            <label>บุคคลที่ติดต่อ<font color="red"> *</font></label>
                                            <input type="text" class="form-control" id="edit_com_people">
                                        </div>
                                        <div class="form-group">
                                            <label>หมายเหตุ</label>
                                            <input type="text" class="form-control" id="edit_com_annotation">
                                        </div>  
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                                <button class="btn btn-success" onclick="save_row()">บันทึก</button>
                            </div>
                        </div>
                    </div>
                </div>
          </div>
          <!-- /.box -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
</div>
</body>
</html>