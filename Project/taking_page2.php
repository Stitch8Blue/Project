<?php
    session_start();
    include("connect.php");

    $sql = "SELECT * FROM taking JOIN purchase_order ON taking.po_id = purchase_order.po_id JOIN company ON purchase_order.com_id = company.com_id JOIN purchase_order_status ON purchase_order.po_stu_id = purchase_order_status.po_stu_id JOIN employee ON taking.emp_id = employee.emp_id AND taking.po_id = '".$_GET['id']."' GROUP BY taking.po_id";
    $query = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($query,MYSQLI_ASSOC);

    if(isset($_POST['edit_row'])){
        
        /*$sql_edit1 = "UPDATE taking SET tak_amount='".$_POST['tak_amount']."',tak_stu_id='2' WHERE tak_id ='".$_POST['tak_id']."'";
        mysqli_query($conn,$sql_edit1);*/    
        
        $sql_ck_amount = "SELECT * FROM taking WHERE tak_id = '".$_POST['tak_id']."'";
        $query_ck_amount = mysqli_query($conn,$sql_ck_amount);
        $row = mysqli_fetch_array($query_ck_amount,MYSQLI_ASSOC);
        /*$row[]*/
        
        if($_POST['tak_amount'] < $row['tak_total_amount']){
            $sql_edit1 = "UPDATE taking SET tak_amount='".$_POST['tak_amount']."',tak_stu_id='2' WHERE tak_id = '".$_POST['tak_id']."'";
            mysqli_query($conn,$sql_edit1);
            
            /*$sql_insert = "SELECT * FROM product WHERE pro_id = '".$pro_id."'";*/
        }
        else{
            $sql_edit2 = "UPDATE taking SET tak_amount='".$_POST['tak_amount']."',tak_stu_id='3' WHERE tak_id = '".$_POST['tak_id']."'";
            mysqli_query($conn,$sql_edit2);
        }
        exit();
    }

    if(isset($_POST['take_all'])){
        $po_id = $_POST['po_id'];
        
        $sql_take_select = "SELECT pro_id,tak_total_amount FROM taking JOIN purchase_order ON taking.po_id = purchase_order.po_id AND taking.po_id = '".$po_id."'";
        $query_take_select = mysqli_query($conn,$sql_take_select);
        
        while($row = mysqli_fetch_array($query_take_select,MYSQLI_ASSOC)){
            $take = $row['tak_total_amount'];
            $pro_id = $row['pro_id'];
            
            $sql_take_all = "UPDATE taking SET tak_amount='".$take."',tak_stu_id='3' WHERE po_id = '".$po_id."' AND pro_id ='".$pro_id."'";
            mysqli_query($conn,$sql_take_all);
            
            $sql_pro_select = "SELECT * FROM product WHERE pro_id = '".$pro_id."'";
            $query_pro_select = mysqli_query($conn,$sql_pro_select);
            
            while($row2 = mysqli_fetch_array($query_pro_select,MYSQLI_ASSOC)){
                $pro_amount = $row2['pro_amount'];
                $amount = $take + $pro_amount;
            }
            $sql_pro_insert = "UPDATE product SET pro_amount='".$amount."' WHERE pro_id = '".$pro_id."'";
            mysqli_query($conn,$sql_pro_insert);
        }        
        exit();
    }
?>
<html>
<head>
<title>การสั่งซื้อสินค้า</title>
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
  <link rel="stylesheet" type="text/css" href="dist/css/styleFont.css"/>
    
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
                "sZeroRecords": 'ไม่ข้อมูลสินค้า',
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
            },
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
   
  });
      
  function edit_row(id){

     var tak_id = document.getElementById("tak_id_val"+id).value;
     var pro_id = document.getElementById("pro_id_val"+id).innerHTML;
     var pro_type = document.getElementById("pro_type_name_val"+id).innerHTML;
     var pro_name = document.getElementById("pro_name_val"+id).value;
     var tak_total_amount_val = document.getElementById("tak_total_amount_val"+id).innerHTML;
     var tak_amount_val = document.getElementById("tak_amount_val"+id).innerHTML;
     var amount = 0;
      
     amount = tak_total_amount_val - tak_amount_val;

     document.getElementById("edit_tak_id").value = tak_id;
     document.getElementById("edit_pro_id").value = pro_id;
     document.getElementById("edit_pro_type").value = pro_type;
     document.getElementById("edit_pro_name").value = pro_id + " : " + pro_name;
     document.getElementById("edit_tak_amount").value = amount;
  }

  function save_row(){
      var tak_id = document.getElementById("edit_tak_id").value;
      var tak_amount = document.getElementById("edit_tak_amount").value;
      
     $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการแก้ไขรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                          type:'post',
                          url:'taking_page2.php',
                          data:{
                           edit_row:'edit_row',
                           tak_id:tak_id,
                           tak_amount:tak_amount},
                           success:function(response) {
                               //alert(pro_id + " " + tak_amount);
                               $.alert('ทำการแก้ไขแล้ว!');
                               setTimeout("location.reload(false)",1500);
                          }
                    });
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการแก้ไขแล้ว!');
                    setTimeout("location.reload(false)",1500);
                }
            }
    });
  }
      
  function save_all(){
      var po_id = document.getElementById("edit_po_id").value;
      var tak_date = document.getElementById("edit_tak_date").value;
      var tak_annotation = document.getElementById("edit_tak_annotation").value;
      
     $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการบันทึกรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                          type:'post',
                          url:'taking_page.php',
                          data:{
                           save_all:'save_all',
                           po_id:po_id,
                           tak_date:tak_date,
                           tak_annotation:tak_annotation},
                           success:function(response) {
                               //alert(pro_id + " " + tak_amount);
                               $.alert('ทำการบันทึกแล้ว!');
                               window.location.href = "taking_page.php";
                          }
                    });
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการบันทึกแล้ว!');
                    setTimeout("location.reload(false)",1500);
                }
            }
    });
  }
      
  function take_all(){
      var edit_po_id = document.getElementById("edit_po_id").value;
      
      $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการรับรายการสินค้าทั้งหมดใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                          type:'post',
                          url:'taking_page2.php',
                          data:{
                           take_all:'take_all',
                           po_id:edit_po_id},
                           success:function(response) {
                               //alert(pro_id + " " + tak_amount);
                               $.alert('ทำการรับสินค้าทั้งหมดแล้ว!');
                               setTimeout("location.reload(false)",1500);
                          }
                    });
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการรับสินค้าทั้งหมดแล้ว!');
                    setTimeout("location.reload(false)",1500);
                }
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
      <h1>แสดงรายละเอียดการรับสินค้า</h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">การจัดการข้อมูล</a></li>
        <li class="active">รายละเอียดการรับสินค้า</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="col-xs-3">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">รายละเอียดการรับสินค้า</h3>
                    </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>รหัสการสั่งซื้อสินค้า</label>
                                <input type="text" class="form-control" id="po_id" value="<?php echo "PO-".sprintf("%04d",$row['po_id']);?>" readonly>
                                <input type="hidden" id="edit_po_id" value="<?php echo $row['po_id'];?>">
                            </div>
                            <div class="form-group">
                                <label>วันที่รับ</label>
                                <input type="date" class="form-control" id="edit_tak_date" value="<?php echo $row['tak_date'];?>">
                            </div>
                            <div class="form-group">
                                <label>บริษัทจัดจำหน่าย</label>
                                <input type="text" class="form-control" value="<?php echo $row['com_name'];?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>พนักงานรับสินค้า</label>
                                <input type="text" class="form-control" value="<?php echo $row['emp_name'];?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>สภานะการสั่งซื้อ</label>
                                <input type="text" class="form-control" value="<?php echo $row['po_stu_name'];?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>หมายเหตุการรับสินค้า</label>
                                <input type="text" class="form-control" id="edit_tak_annotation" value="<?php echo $row['tak_annotation'];?>">
                            </div>
                        </div>
                </div>
            </div>
            <div class="col-xs-9">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">รายการสินค้าสั่งซื้อ</h3>
                    </div>
                    <div class="box-body">
                        <table id="pro_table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>รหัสสินค้า</th>
                                    <th>ประเภทสินค้า</th>
                                    <th>ชื่อสินค้า</th>
                                    <th>จำนวนสินค้าที่สั่งทั้งหมด</th>
                                    <th>จำนวนสินค้าที่รับ</th>
                                    <th>สถานะการรับ</th>
                                    <th>การจัดการข้อมูล</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $sql_tak_pro = "SELECT * FROM taking JOIN product ON product.pro_id = taking.pro_id JOIN product_type ON product_type.pro_type_id = product.pro_type_id JOIN taking_status ON taking_status.tak_stu_id = taking.tak_stu_id AND po_id = '".$_GET['id']."'";
                                $query_tak_pro = mysqli_query($conn,$sql_tak_pro);
                                
                                while($row = mysqli_fetch_array($query_tak_pro,MYSQLI_ASSOC))
                                {           
                            ?>
                                <tr id="row<?php echo $row['tak_id'];?>">
                                    <td id="pro_id_val<?php echo $row['tak_id'];?>"><?php echo $row['pro_id'];?></td>
                                    <td id="pro_type_name_val<?php echo $row['tak_id'];?>"><?php echo $row['pro_type_name'];?></td>
                                    <td id="name_val<?php echo $row['tak_id'];?>"><?php
                                    if (strlen($row['pro_name']) > 50){
                                        echo substr($row['pro_name'], 0, 50)."<font color='blue'> ...</font>";
                                    }
                                    else{
                                        echo $row['pro_name'];
                                    }?></td>
                                    <td id="tak_total_amount_val<?php echo $row['tak_id'];?>" align="right"><?php echo $row['tak_total_amount'];?></td>
                                    <td id="tak_amount_val<?php echo $row['tak_id'];?>" align="right"><?php echo $row['tak_amount'];?></td>
                                    <td id="tak_stu_name_val<?php echo $row['tak_id'];?>"><?php echo $row['tak_stu_name'];?></td>
                                    <td><button class="btn btn-warning" data-toggle="modal" data-target="#myModal" id="edit_button<?php echo $row['tak_id'];?>" onclick="edit_row('<?php echo $row['tak_id'];?>');"><i class="fa fa-fw fa-pencil-square-o"></i></button>
                                    </td>
                                    <input type="hidden" id="tak_id_val<?php echo $row['tak_id'];?>" value="<?php echo $row['tak_id'];?>">
                                    <input type="hidden" id="pro_name_val<?php echo $row['tak_id'];?>" value="<?php echo $row['pro_name'];?>">
                                </tr>
                            <?php
                                }
                            ?>
                            </tbody>
                          </table>
                    </div>
                </div>
                
                <div class="modal fade" id="myModal" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">ระบุจำนวนข้อมูลการรับสินค้า</h4>
                            </div>
                            <div class="modal-body">
                                        <div class="form-group">
                                            <label>ประเภทสินค้า</label>
                                            <input type="text" class="form-control" id="edit_pro_type" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>รหัสสินค้า</label>
                                            <input type="text" class="form-control" id="edit_pro_name" readonly>
                                            <input type="hidden" id="edit_pro_id">
                                        </div>                                        
                                        <div class="form-group">
                                            <label>จำนวนสินค้าที่จะรับ</label>
                                            <input type="number" class="form-control" id="edit_tak_amount" maxlength="">
                                        </div>
                                        <input type="hidden" id="edit_tak_id">
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                                <input type="submit" class="btn btn-success" value="แก้ไขสินค้า" onclick="save_row()">
                             </div>
                        </div>
                    </div>
                </div>
                
                <!--<button class="btn btn-success pull-right" onclick="javascript:location.href='taking_page.php'">บันทึกการรับสินค้า</button>--> 
                <button class="btn btn-primary pull-left" onclick="take_all()">การรับสินค้าทั้งหมด</button>
                <button class="btn btn-success pull-right" onclick="save_all()">บันทึกการรับสินค้า</button>
            </div>
        </div>
      </div>
        
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
    </div>
</body>
</html>