<?php
    session_start();
    unset($_SESSION['item_store']);
    session_write_close();

	include("connect.php");

    $sql_id = "SELECT MAX(po_id) AS id FROM purchase_order";
    $query_id = mysqli_query($conn,$sql_id);
    $row = mysqli_fetch_array($query_id,MYSQLI_ASSOC);

    $sql_com = "SELECT * FROM company";
    $query_com = mysqli_query($conn,$sql_com);

    $sql_pro = "SELECT * FROM product";
    $query_pro = mysqli_query($conn,$sql_pro);

    $new_po_id ;

    if($row['id'] != null){
        $new_po_id = $row['id']+1;
    }
    else{
        $new_po_id = 1;
    }  

    if(isset($_POST['delete_row'])){
        $row = $_POST['row_id'];
        
        $sql_delete = "DELETE FROM purchase_order WHERE po_id = '".$row."'";
        mysqli_query($conn,$sql_delete);
        $sql_delete_pod = "DELETE FROM purchase_order_detail WHERE po_id = '".$row."'";
        mysqli_query($conn,$sql_delete_pod);
        exit();
    }
        
    if(isset($_POST['insert_po'])){
        $sql_add_po = "UPDATE purchase_order SET po_price_total = '".$_POST['total_price']."',po_annotation = '".$_POST['po_annotation']."' WHERE po_id = '".$_SESSION['po_id']."'";
        mysqli_query($conn,$sql_add_po);
        unset($_SESSION['po_id']);
        exit();
    }

    if(isset($_POST['approve'])){
        $sql_sele_app = "SELECT * FROM purchase_order WHERE po_id = '".$_POST['row_id']."'";
        $query_sele_app = mysqli_query($conn,$sql_sele_app);
        $app = mysqli_fetch_array($query_sele_app,MYSQLI_ASSOC);
        
        if($app['po_stu_id'] == "1"){
            $sql_app = "UPDATE purchase_order SET po_stu_id = '2' WHERE po_id = '".$_POST['row_id']."'";
            mysqli_query($conn,$sql_app);
        }
        else if($app['po_stu_id'] == "2"){
            $sql_app = "UPDATE purchase_order SET po_stu_id = '1' WHERE po_id = '".$_POST['row_id']."'";
            mysqli_query($conn,$sql_app);
        }    
        exit();
    }

    if(isset($_POST['cancel'])){
        $sql_app = "UPDATE purchase_order SET po_stu_id = '3' WHERE po_id = '".$_POST['row_id']."'";
        mysqli_query($conn,$sql_app);
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
  <script type="text/javascript" src="modify_purchase.js"></script>
  
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
            },
    });

    document.getElementById("new_po_date").valueAsDate = new Date()
   
  });
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
        การจัดการข้อมูลการสั่งซื้อสินค้า
        <!--<small>advanced tables</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">ตารางข้อมูลการสั่งซื้อสินค้า</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="pro_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>รหัสการสั่งซื้อสินค้า</th>
                        <th>วันที่การสั่งซื้อ</th>
                        <th>บริษัทจัดจำหน่าย</th>
                        <th>ราคารวม (บาท)</th>
                        <th>สถานะการสั่งซื้อ</th>
                        <th>พนักงาน</th>
                        <th>การจัดการข้อมูล</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $sql = "SELECT * FROM purchase_order JOIN company ON purchase_order.com_id = company.com_id JOIN employee ON purchase_order.emp_id = employee.emp_id JOIN purchase_order_status ON purchase_order.po_stu_id = purchase_order_status.po_stu_id ORDER BY purchase_order.po_date DESC";
	               $query = mysqli_query($conn,$sql);
                    
					while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
					{
                ?>
                    <tr id="row<?php echo $row['po_id'];?>">
                        <td id="po_id_val<?php echo $row['po_id'];?>"><?php echo "PO-".sprintf("%04d",$row['po_id']);?></td>
                        <td id="po_date_val<?php echo $row['po_id'];?>"><?php echo $row['po_date'];?></td>
                        <td id="com_name_val<?php echo $row['po_id'];?>"><?php echo $row['com_name'];?></td>
                        <td id="po_price_total_val<?php echo $row['po_id'];?>" align="right"><?php echo number_format($row['po_price_total'],2);?></td>
                        <?php
                            if($row['po_stu_id'] == 1){
                                $color = "#FFC300";
                            }
                            else if($row['po_stu_id'] == 2){
                                $color = "#34B71B";
                            }
                            else if($row['po_stu_id'] == 3){
                                $color = "red";
                            }
                        ?>
                        <td id="po_stu_name_val<?php echo $row['po_id'];?>"><font color="<?php echo $color;?>"><?php echo $row['po_stu_name'];?></font></td>
                        <td id="emp_name_val<?php echo $row['po_id'];?>"><?php echo $row['emp_name'];?></td>
                        <!--<td id="po_annotation_val<?php echo $row['po_id'];?>"><?php echo $row['po_annotation'];?></td>-->
                        <td>
                            <?php
                                $lock = "";
                                if($row['po_stu_id'] != 1){
                                    $lock = "disabled";
                                }
                            ?>
                            <button class="btn btn-warning" data-toggle="modal" data-target="#myModal2" id="edit_button<?php echo $row['po_id'];?>" onclick="edit_po('<?php echo $row['po_id'];?>');" <?php echo $lock;?>><i class="fa fa-fw fa-pencil-square-o"></i></button>
                            <button class="btn btn-danger" id="delete_button<?php echo $row['po_id'];?>" onclick="delete_row('<?php echo $row['po_id'];?>');" <?php echo $lock;?>><i class="fa fa-fw fa-trash-o"></i></button>
                            <button class="btn btn" id="approve_button<?php echo $row['po_id'];?>" onclick="approve('<?php echo $row['po_id'];?>');"><i class="fa fa-fw fa-key"><i class="fa fa-fw fa-check"></i></i></button>
                            <button class="btn btn" id="cancel_button<?php echo $row['po_id'];?>" onclick="cancel('<?php echo $row['po_id'];?>');"><i class="fa fa-fw fa-key"><i class="fa fa-fw fa-remove"></i></i></button>

                        </td>
                        <input type="hidden" id="com_id_val<?php echo $row['po_id'];?>" value="<?php echo $row['com_id'];?>">
                        <input type="hidden" id="emp_id_val<?php echo $row['po_id'];?>" value="<?php echo $row['emp_id'];?>">
                    </tr>
                <?php
					}
				?>
                </tbody>
              </table>
            </div>
          </div>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">เพิ่มข้อมูลการสั่งซื้อสินค้า</button>
             <form action="purchase_page2.php" method="post">
                <div class="modal fade" id="myModal" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">เพิ่มข้อมูลการสั่งซื้อสินค้า</h4>
                            </div>
                            <div class="modal-body">
                                        <div class="form-group">
                                            <label>รหัสการสั่งซื้อสินค้า</label>
                                            <input type="text" class="form-control" value="<?php echo "PO-".sprintf("%04d",$new_po_id);?>" readonly>
                                            <input type="hidden" class="form-control" name="new_po_id" id="new_po_id" value="<?php echo $new_po_id;?>">
                                        </div>
                                        <div class="form-group">
                                            <label>วันที่การสั่งซื้อ</label>
                                            <input type="date" class="form-control" name="new_po_date" id="new_po_date">
                                        </div>
                                        <div class="form-group">
                                            <label>บริษัทจัดจำหน่าย</label>
                                            <select class="form-control select2" style="width: 100%;" name="new_com_id" id="new_com_id">
                                                <?php
                                                    while($row = mysqli_fetch_array($query_com,MYSQLI_ASSOC))
                                                    {
                                                ?>
                                                      <option value="<?php echo $row['com_id'];?>"><?php echo $row['com_name'];?></option>  
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>พนักงาน</label>
                                            <input type="text" class="form-control" id="new_emp" value="<?php echo $_SESSION['UserName'];?>" readonly>
                                        </div>                              
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                                <input type="submit" name="submit" class="btn btn-success" value="เพิ่มข้อมูลการสั่งซื้อ">
                             </div>
                        </div>
                    </div>
                </div>
            </form>            
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.3.5
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
<!-- ./wrapper -->
</body>
</html>