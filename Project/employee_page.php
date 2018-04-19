<?php
    session_start();
	include("connect.php");

    $sql = "SELECT * FROM employee JOIN title ON employee.tle_id = title.tle_id";
	$query = mysqli_query($conn,$sql);

    if(isset($_POST['edit_row'])){
        $row = $_POST['row_id'];
        $tle = $_POST['tle_id'];
        $emp_name_val = $_POST['emp_name_val'];
        $emp_user_val = $_POST['emp_user_val'];
        
        $sql_ck_update = "SELECT * FROM employee WHERE emp_id != '".$row."' AND (emp_name = '".$emp_name_val."' OR emp_user = '".$emp_user_val."')";
        $query_ck_update = mysqli_query($conn,$sql_ck_update);
        $num = mysqli_num_rows($query_ck_update);
        
        if($num > 0){
            $mgs = "ไม่สามารถแก้ไขข้อมูลได้ !! เนื่องจากข้อมูลถูกซ้ำ.";
            $_SESSION['mgs'] = $mgs;
        }
        else{
            mysqli_query($conn,"UPDATE employee SET tle_id='".$tle."',emp_name='".$emp_name_val."',emp_user='".$emp_user_val."' where emp_id='".$row."'");  
            $mgs = "ทำการแก้ไขข้อมูลแล้ว!";
            $_SESSION['mgs'] = $mgs;
        }        
        exit();
    }    

    if(isset($_POST['delete_row'])){
        $row = $_POST['row_id'];
        
        $sql_delete = "DELETE FROM employee WHERE emp_id = '".$row."'";
        
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
        $tle_id = $_POST['tle_id'];
        $emp_name = $_POST['emp_name'];
        $emp_user = $_POST['emp_user'];
        $emp_pass = $_POST['emp_pass'];
        $emp_pass = md5($emp_pass);
        $emp_status = $_POST['emp_status'];
        
        $sql_ck_add = "SELECT * FROM employee WHERE emp_name = '".$emp_name."' OR emp_user = '".$emp_user."'";
        $query_ck_add = mysqli_query($conn,$sql_ck_add);
        $num = mysqli_num_rows($query_ck_add);
        
        if($num > 0){
            $mgs = "ไม่สามารถเพิ่มข้อมูลได้ !! เนื่องจากข้อมูลซ้ำ.";
            $_SESSION['mgs'] = $mgs;
        }
        else{
            $sql_add = "INSERT INTO employee VALUES('','".$tle_id."','".$emp_name."','".$emp_user."','".$emp_pass."','".$emp_status."')";
            mysqli_query($conn,$sql_add);
            $mgs = "ทำการเพิ่มข้อมูลแล้ว!";
            $_SESSION['mgs'] = $mgs;        
        } 
        exit();
    }

    if(isset($_POST['resetpass'])){
        $pass = md5("0000");
        $sql_resetpass = "UPDATE employee SET emp_pass='".$pass."' WHERE emp_id = '".$_POST['id']."'";
        mysqli_query($conn,$sql_resetpass);
        exit();
    }

    if(isset($_POST['approve'])){
        if($_POST['status'] == ADMIN){
            $status = "USER";
        }
        else{
           $status = "ADMIN"; 
        }
        
        $sql_approve = "UPDATE employee SET emp_status='".$status."' WHERE emp_id = '".$_POST['id']."'";
        mysqli_query($conn,$sql_approve);
        exit();
    }
    
    if(isset($_POST['confirmPass'])){
        $pass = md5($_POST['name']);
        $pass = substr($pass,0,20);
        $sql_con_pass = "SELECT * FROM employee WHERE emp_id = '".$_POST['id']."' AND emp_pass = '".$pass."'";
        $query_con_pass = mysqli_query($conn,$sql_con_pass);
        $num = mysqli_num_rows($query_con_pass);
        
    }
?>
<html>
<head>
<title>การจัดการพนักงาน</title>
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
  <script type="text/javascript" src="modify_employee.js"></script>
  
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
  <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <script src="plugins/fastclick/fastclick.js"></script>
  <script src="plugins/select2/select2.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
  <script src="http://malsup.github.com/jquery.form.js"></script>
    
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
        การจัดการข้อมูลพนักงาน
        <!--<small>advanced tables</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#">การจัดการข้อมูล</a></li>
        <li class="active">พนักงาน</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">ตารางข้อมูลพนักงาน</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="pro_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>รหัสพนักงาน</th>
                        <th>คำนำหน้าชื่อ</th>
                        <th>ชื่อพนักงาน</th>
                        <th>ชื่อผู้ใช้</th>
                        <th>รหัสผ่าน</th>
                        <th>สถานะ</th>
                        <th>การจัดการข้อมูล</th>
                    </tr>
                </thead>
                <tbody>
                <?php
					while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
					{ 
                ?>
                    <tr id="row<?php echo $row['emp_id'];?>">
                        <td id="emp_id_val<?php echo $row['emp_id'];?>"><?php echo $row['emp_id'];?></td>
                        <td id="tle_name_val<?php echo $row['emp_id'];?>"><?php echo $row['tle_name'];?></td>
                        <td id="emp_name_val<?php echo $row['emp_id'];?>"><?php echo $row['emp_name'];?></td>
                        <td id="emp_user_val<?php echo $row['emp_id'];?>"><?php echo $row['emp_user'];?></td>
                        <td id="emp_pass_word_val<?php echo $row['emp_id'];?>" class="pull-right"><?php echo substr($row['emp_pass'],0,20);?></td>
                        <td id="emp_status_val<?php echo $row['emp_id'];?>"><?php echo $row['emp_status'];?></td>
                        <input type="hidden" id="tle_id_val<?php echo $row['emp_id'];?>" value="<?php echo $row['tle_id'];?>">
                        <input type="hidden" id="emp_pass_val<?php echo $row['emp_id'];?>" value="<?php echo $row['emp_pass'];?>">
                        <td>                            
                            <button class="btn btn-warning" data-toggle="modal" data-target="#myModal2" id="edit_button<?php echo $row['emp_id'];?>" onclick="edit_row('<?php echo $row['emp_id'];?>');"><i class="fa fa-fw fa-pencil-square-o"></i></button>
                            <?php
                                $lock = "";
                                if($_SESSION['UserID'] == $row['emp_id']){ 
                                    $lock = "disabled";
                                }
                            ?>
                            <button class="btn btn-danger" id="delete_button<?php echo $row['emp_id'];?>" <?php echo $lock;?> onclick="delete_row('<?php echo $row['emp_id'];?>');"><i class="fa fa-fw fa-trash-o"></i></button>                     
                            <button class="btn btn-primary" id="resetpass_button<?php echo $row['emp_id'];?>" onclick="confirmPass('<?php echo $row['emp_id'];?>');"><i class="fa fa-fw fa-refresh"></i></button>
                            <button class="btn btn" id="approve_button<?php echo $row['emp_id'];?>" onclick="approve('<?php echo $row['emp_id'];?>');"><i class="fa fa-fw fa-exchange"></i></button>
                        </td>                        
                    </tr>                    
                <?php
					}
				?>
                </tbody>
              </table>
            </div>
          </div>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">เพิ่มข้อมูลพนักงาน</button>
                <!--<form id="formAdd">-->
                <div class="modal fade" id="myModal" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">เพิ่มข้อมูลพนักงาน</h4>
                            </div>
                            <div class="modal-body">
                                        <div class="form-group">
                                            <label>คำนำหน้าชื่อ <font color="red"> *</font></label>
                                            <select class="form-control select2" style="width: 100%;" id="new_tle_id" required>
                                                <option value="">เลือกคำนำหน้าชื่อ</option>
                                            <?php
                                                $sql_tle = "SELECT * FROM title";
                                                $query_tle = mysqli_query($conn,$sql_tle);
                                                
                                                while($row = mysqli_fetch_array($query_tle,MYSQLI_ASSOC)){
                                            ?>
                                                <option value="<?php echo $row['tle_id']?>"><?php echo $row['tle_name']?></option>
                                            <?php                                
                                                }
                                            ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>ชื่อพนักงาน<font color="red"> *</font></label>
                                            <input type="text" class="form-control" id="new_emp_name" required>
                                        </div>
                                        <div class="form-group">
                                            <label>ชื่อผู้ใช้งาน<font color="red"> *</font></label>
                                            <input type="text" class="form-control" id="new_emp_user" required>
                                        </div>
                                        <div class="form-group">
                                            <label>รหัสผ่าน<font color="red"> *</font></label>
                                            <input type="password" class="form-control" id="new_emp_pass" required>
                                        </div>
                                        <div class="form-group">
                                            <label>ยืนยันรหัสผ่าน<font color="red"> *</font></label>
                                            <input type="password" class="form-control" id="new_emp_pass_con" required>
                                        </div>
                                        <div class="form-group">
                                            <label>สถานะ<font color="red"> *</font></label>
                                            <select class="form-control select2" style="width: 100%;" id="new_emp_status" required>
                                                <option value="0">เลือกสถานะผู้ใช้</option>
                                                <option value="1">USER</option>
                                                <option value="2">ADMIN</option>
                                            </select>
                                        </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                                <button type="submit" class="btn btn-success" onclick="insert_row()">เพิ่ม</button>
                            </div>
                        </div>
                    </div>
                </div>
            <!--</form>-->
                <div class="modal fade" id="myModal2" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">แก้ไขข้อมูลพนักงาน</h4>
                            </div>
                            <div class="modal-body">
                                        <div class="form-group">
                                            <label>รหัสพนักงาน</label>
                                            <input type="text" class="form-control" id="edit_emp_id" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>คำนำหน้าชื่อ<font color="red"> *</font></label>
                                            <select class="form-control select2" style="width: 100%;" id="edit_tle_id" required>
                                                <option value="">เลือกคำนำหน้าชื่อ</option>
                                            <?php
                                                $sql_tle = "SELECT * FROM title";
                                                $query_tle = mysqli_query($conn,$sql_tle);
                                                
                                                while($row = mysqli_fetch_array($query_tle,MYSQLI_ASSOC)){
                                            ?>
                                                <option value="<?php echo $row['tle_id']?>"><?php echo $row['tle_name']?></option>
                                            <?php                                
                                                }
                                            ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>ชื่อพนักงาน<font color="red"> *</font></label>
                                            <input type="text" class="form-control" id="edit_emp_name" required>
                                        </div>
                                        <div class="form-group">
                                            <label>ชื่อผู้ใช้งาน<font color="red"> *</font></label>
                                            <input type="text" class="form-control" id="edit_emp_user" required>
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