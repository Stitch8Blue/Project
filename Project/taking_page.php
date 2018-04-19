<?php
    session_start();
	include("connect.php");  

	$sql = "SELECT * FROM taking JOIN purchase_order ON taking.po_id = purchase_order.po_id JOIN employee ON taking.emp_id = employee.emp_id JOIN purchase_order_status ON purchase_order_status.po_stu_id = purchase_order.po_stu_id JOIN company ON company.com_id = purchase_order.com_id GROUP BY taking.po_id";
	$query = mysqli_query($conn,$sql);

    if(isset($_POST['insert_row'])){
        
        $sql_ck = "SELECT * FROM purchase_order_detail WHERE po_id = '".$_POST['new_po_id']."'";
        $query_ck = mysqli_query($conn,$sql_ck);
        
        while($row = mysqli_fetch_array($query_ck,MYSQLI_ASSOC)){
            $sql_add = "INSERT INTO taking VALUES ('','".$_POST['new_po_id']."','".$_POST['new_tak_date']."','".$row['pro_id']."','".$row['pod_amount']."','0','1','".$_SESSION['UserID']."','".$_POST['new_tak_annotation']."')";
            $query_add = mysqli_query($conn,$sql_add);
        }
        exit();
    }

    if(isset($_POST['save_all'])){
        $sql_add_all = "UPDATE taking SET tak_date='".$_POST['tak_date']."',tak_annotation='".$_POST['tak_annotation']."' WHERE po_id = '".$_POST['po_id']."'";
        mysqli_query($conn,$sql_add_all);
        exit();
    }

    if(isset($_POST['delete_row'])){
        $sql_delete = "DELETE FROM taking WHERE po_id = '".$_POST['row_id']."'";
        mysqli_query($conn,$sql_delete);
        exit();
    }

?>
<html>
<head>
<title>การจัดการสั่งซื้อสินค้า</title>
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
  
  <script>
      
  $(function () {
      
    $("#pro_table").DataTable({
                    "oLanguage": {
                    "sLengthMenu": 'แสดง _MENU_ รายการ ต่อหน้า',
                    "sZeroRecords": 'ไม่เจอข้อมูลที่ค้นหา',
                    "sInfo": 'แสดง _START_ ถึง _END_ ของ _TOTAL_ รายการ',
                    "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 รายการ",
                    "sInfoFiltered": "(จากรายการทั้งหมด _MAX_ รายการ)",
                    "sSearch": "ค้นหา :"
            }
    });
      
    document.getElementById("new_tak_date").valueAsDate = new Date();
  });
      
function insert_row(){
      
      var new_po_id = document.getElementById("new_po_id").value;
      var new_tak_date = document.getElementById("new_tak_date").value;
      var new_tak_annotation = document.getElementById("new_tak_annotation").value;
      
      $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการเพิ่มรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                        type:'post',
                        url:'taking_page.php',
                        data:{insert_row:'insert_row',
                        new_po_id:new_po_id,
                        new_tak_date:new_tak_date,
                        new_tak_annotation:new_tak_annotation},
                        success: function(response){
                            $.alert('ทำการเพิ่มแล้ว!');
                            location.reload(false);
                        }
                    });
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการเพิ่มแล้ว!');
                    document.getElementById("new_po_id").value = "";
                    document.getElementById("new_po_date").value = "";
                    document.getElementById("new_tak_annotation").value = "";
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
                        url:'taking_page.php',
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

  function getPurchase(val) {
      
        $.ajax({
            type: "POST",
            url: "taking_page.php",
            data: {getPurchase:'getPurchase',com_id:val},
            success: function(data){
                $("#new_po_id").html(data);
        }
	});
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
        การจัดการข้อมูลการรับสินค้า
        <!--<small>advanced tables</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">การจัดการข้อมูล</a></li>
        <li class="active">การรับสินค้า</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">ตารางข้อมูลการรับสินค้า</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="pro_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>รหัสการสั่งซื้อสินค้า</th>
                        <th>วันที่รับสินค้า</th>
                        <th>บริษัทจัดจำหน่าย</th>
                        <th>สถานะการสั่งซื้อ</th>  
                        <th>พนักงานรับสินค้า</th>
                        <th>หมายเหตุ</th>
                        <th>การจัดการข้อมูล</th>
                    </tr>
                </thead>
                <tbody>
                <?php
					while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
					{
                ?>
                    <tr id="row<?php echo $row['tak_id'];?>">
                        <td id="po_id_val<?php echo $row['tak_id'];?>"><?php echo $row['po_id'];?></td>
                        <td id="tak_date_val<?php echo $row['tak_id'];?>"><?php echo $row['tak_date'];?></td>
                        <td id="com_name_val<?php echo $row['tak_id'];?>"><?php echo $row['com_name'];?></td>
                        <td id="po_stu_name_val<?php echo $row['tak_id'];?>"><?php echo $row['po_stu_name'];?></td>
                        <td id="emp_name_val<?php echo $row['tak_id'];?>"><?php echo $row['emp_name'];?></td>
                        <td id="tak_annotation_val<?php echo $row['tak_id'];?>"><?php echo $row['tak_annotation'];?></td>
                        <td>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#myModal2" id="edit_button<?php echo $row['tak_id'];?>" onclick="javascript:location.href='taking_page2.php?id=<?php echo $row['po_id'];?>'"><i class="fa fa-fw fa-list-ul"></i></button>
                        <!--<button class="btn btn-danger" id="delete_button<?php echo $row['po_id'];?>" onclick="delete_row('<?php echo $row['po_id'];?>');"><i class="fa fa-fw fa-trash-o"></i></button>-->
                        </td>                        
                    </tr>
                <?php
					}
				?>
                </tbody>
              </table>
            </div>
          </div>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">เพิ่มข้อมูลการรับสินค้า</button>
                 
                <div class="modal fade" id="myModal" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">เพิ่มข้อมูลการรับสินค้า</h4>
                            </div>
                            <div class="modal-body">
                                        <div class="form-group">
                                            <label>รหัสการสั่งซื้อ<font color="red"> *</font></label>
                                            <select class="form-control select2" style="width: 100%;" id="new_po_id" name="new_po_id">
                                            <?php
                                                $sql_po ="SELECT * FROM purchase_order WHERE purchase_order.po_stu_id = '2' ";
                                                $query_po = mysqli_query($conn,$sql_po);
                                            ?>
                                                <option value="">เลือกรหัสการสั่งซื้อสินค้า</option>
                                            <?php 
                                                while($row = mysqli_fetch_array($query_po,MYSQLI_ASSOC)){
                                            ?>
                                                <option value="<?php echo $row["po_id"];?>"><?php echo $row["po_id"];?></option>
                                            <?php 
                                                }
                                            ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>วันที่รับสินค้า<font color="red"> *</font></label>
                                            <input type="date" class="form-control" id="new_tak_date">
                                        </div>
                                        <div class="form-group">
                                            <label>พนักงาน</label>
                                            <input type="text" class="form-control" value="<?php echo $_SESSION['UserName'];?>" id="new_emp_id" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>หมายเหตุ</label>
                                            <input type="text" class="form-control" id="new_tak_annotation">
                                        </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                                <button class="btn btn-success" onclick="insert_row()">เพิ่ม</button>
                            </div>
                        </div>
                    </div>
            </div>
            
     
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
</div>
</body>
</html>