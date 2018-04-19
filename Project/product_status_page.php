<?php
    session_start();
	include("connect.php");  

	$sql = "SELECT * FROM product_status";
	$query = mysqli_query($conn,$sql);

    if(isset($_POST['edit_row'])){
        $row = $_POST['row_id'];
        $pro_stu_name_val = $_POST['pro_stu_name_val'];
        
        $sql_ck_update = "SELECT * FROM product_status WHERE pro_stu_name = '".$pro_stu_name_val."' AND pro_stu_id != '".$row."'";
        $query_ck_update = mysqli_query($conn,$sql_ck_update);
        $num = mysqli_num_rows($query_ck_update);
        
        if($num > 0){
            $mgs = "ไม่สามารถแก้ไขข้อมูลได้ !! เนื่องจากข้อมูลถูกซ้ำ.";
            $_SESSION['mgs'] = $mgs;
        }
        else{
            mysqli_query($conn,"UPDATE product_status SET pro_stu_name='".$pro_stu_name_val."' where pro_stu_id='".$row."'");
            $mgs = "ทำการแก้ไขข้อมูลแล้ว!";
            $_SESSION['mgs'] = $mgs;
        }
        exit();
    }    

    if(isset($_POST['delete_row'])){
        $row = $_POST['row_id'];
        
        $sql_delete = "DELETE FROM product_status WHERE pro_stu_id = '".$row."'";
        
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
        $pro_stu_name = $_POST['pro_stu_name'];
        
        $sql_ck_add = "SELECT * FROM product_status WHERE pro_stu_name = '".$pro_stu_name."'";
        $query_ck_add = mysqli_query($conn,$sql_ck_add);
        $num = mysqli_num_rows($query_ck_add);
        
        if($num > 0){
            $mgs = "ไม่สามารถเพิ่มข้อมูลได้ !! เนื่องจากข้อมูลซ้ำ.";
            $_SESSION['mgs'] = $mgs;
        }
        else{
           $sql_add = "INSERT INTO product_status VALUES('','".$pro_stu_name."')";
            mysqli_query($conn,$sql_add);         
            $mgs = "ทำการเพิ่มข้อมูลแล้ว!";
            $_SESSION['mgs'] = $mgs;
        }        
        exit();
    }
?>
<html>
<head>
<title>การจัดการข้อมูลสถานะสินค้า</title>

  <meta http-equiv=Content-Type content="text/html; charset=utf-8">
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
  <script type="text/javascript" src="modify_product_status.js"></script>
  
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
                            "sSearch": "ค้นหา :",
                            "oPaginate": {
                                "sFirst":    "หน้าแรก",
                                "sPrevious": "ก่อนหน้า",
                                "sNext":     "ถัดไป",
                                "sLast":     "หน้าสุดท้าย"
                            }
                    }
    });    
  });
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
        การจัดการข้อมูลสถานะสินค้า
        <!--<small>advanced tables</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#">ข้อมูลพื้นฐาน</a></li>
        <li class="active">สถานะสินค้า</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">ตารางข้อมูลสถานะสินค้า</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="pro_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>รหัสสถานะสินค้า</th>
                        <th>สถานะสินค้า</th>
                        <th>การจัดการข้อมูล</th>
                    </tr>
                </thead>
                <tbody>
                <?php
					while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
					{
                ?>
                    <tr id="row<?php echo $row['pro_stu_id'];?>">
                        <td id="pro_stu_id_val<?php echo $row['pro_stu_id'];?>"><?php echo $row['pro_stu_id'];?></td>
                        <td id="pro_stu_name_val<?php echo $row['pro_stu_id'];?>"><?php echo $row['pro_stu_name'];?></td>
                        <td>
                            <button class="btn btn-warning" data-toggle="modal" data-target="#myModal2" id="edit_button<?php echo $row['pro_stu_id'];?>" onclick="edit_row('<?php echo $row['pro_stu_id'];?>');"><i class="fa fa-fw fa-pencil-square-o"></i></button>
                            <button class="btn btn-danger" id="delete_button<?php echo $row['pro_stu_id'];?>" onclick="delete_row('<?php echo $row['pro_stu_id'];?>');"><i class="fa fa-fw fa-trash-o"></i></button>
                        </td>                        
                    </tr>
                <?php
					}
				?>
                </tbody>
              </table>
            </div>
          </div>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">เพิ่มข้อมูลสถานะสินค้า</button>
                 
                <div class="modal fade" id="myModal" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">เพิ่มข้อมูลสถานะสินค้า</h4>
                            </div>
                            <div class="modal-body">
                                        <div class="form-group">
                                            <label>สถานะสินค้า</label>
                                            <input type="text" class="form-control" id="new_pro_stu_name" placeholder="สถานะสินค้า">
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
                                <h4 class="modal-title">แก้ไขข้อมูลสถานะการสินค้า</h4>
                            </div>
                            <div class="modal-body">
                                        <div class="form-group">
                                            <label>รหัสสถานะสินค้า</label>
                                            <input type="text" class="form-control" id="edit_pro_stu_id" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>สถานะสินค้า</label>
                                            <input type="text" class="form-control" id="edit_pro_stu_name">
                                        </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                                <button class="btn btn-success" onclick="save_row();">บันทึก</button>
                            </div>
                        </div>
                    </div>
                </div>
          </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
</div>
</body>
</html>