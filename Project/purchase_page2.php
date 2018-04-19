<?php
    session_start();
    include("connect.php"); 

	$sql_pro_type = "SELECT * FROM product_type ORDER BY pro_type_name ASC";
    $query_pro_type = mysqli_query($conn,$sql_pro_type);

    $edit_po_ck = false;

    if(isset($_POST['submit'])){
        $_SESSION['po_id'] = $_POST['new_po_id'];
        
        $sql_add_po = "INSERT INTO purchase_order VALUES ('".$_POST['new_po_id']."','".$_POST['new_com_id']."','0','".$_POST['new_po_date']."','1','".$_SESSION['UserID']."','')";
        mysqli_query($conn,$sql_add_po);   
    }

    if(isset($_POST['edit_po'])){   
        unset($_SESSION['po_id']);
        $_SESSION['po_id'] = $_POST['row_id'];
        $edit_po_ck = true;
    }

    if(isset($_POST['pro_type_id'])) {
        $sql_pro_id = "SELECT * FROM product JOIN product_type ON product.pro_type_id = product_type.pro_type_id AND product_type.pro_type_id = '".$_POST['pro_type_id']."' WHERE product.pro_id NOT IN (SELECT pro_id FROM purchase_order_detail WHERE po_id = '".$_SESSION['po_id']."')";
        $sql_pro_id = mysqli_query($conn,$sql_pro_id);
    ?>
	   <option value="">เลือกรหัสสินค้า</option>
    <?php
	   while($row2 = mysqli_fetch_array($sql_pro_id,MYSQLI_ASSOC)){
    ?>
	   <option value="<?php echo $row2["pro_id"]; ?>"><?php echo "MCS-".sprintf("%04d",$row2['pro_id'])?> : <?php echo $row2['pro_name'];?></option>
    <?php
	   }
        exit();
    }

    if(isset($_POST['pro_id'])){
        $sql_pro_unit = "SELECT * FROM product JOIN product_unit ON product.pro_unit_id = product_unit.pro_unit_id AND pro_id = '".$_POST['pro_id']."'";
        $query_pro_unit = mysqli_query($conn,$sql_pro_unit);

	   while($row2 = mysqli_fetch_array($query_pro_unit,MYSQLI_ASSOC)){
    ?>
	   <option value="<?php echo $row2["pro_unit_id"]; ?>"><?php echo $row2['pro_unit_name'];?></option>
    <?php
	   }
        exit();
    }    

    if(isset($_POST['edit_row'])){
        $sql_edit_item = "UPDATE purchase_order_detail SET pod_amount = '".$_POST['pro_amount_val']."',pod_price = '".$_POST['pro_price_val']."' WHERE pod_id = '".$_POST['pod_id']."'";
        mysqli_query($conn,$sql_edit_item);
        exit();
    }

    if(isset($_POST['delete_row'])){
        $sql_del_item = "DELETE FROM purchase_order_detail WHERE pod_id = '".$_POST['row_id']."' ";
        mysqli_query($conn,$sql_del_item);
        exit();
    }

    if(isset($_POST['add_item'])){
        $po_id = $_POST['po_id'];
        $pro_id = $_POST['pro_id'];
        $po_amount = $_POST['pro_amount'];
        $pro_price = $_POST['pro_price'];
        
        $sql_add_item = "INSERT INTO purchase_order_detail VALUES ('','".$po_id."','".$pro_id."','".$po_amount."','".$pro_price."')";
        mysqli_query($conn,$sql_add_item);
        
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
  <script type="text/javascript" src="modify_purchase2.js"></script>
      
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
  <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <script src="plugins/fastclick/fastclick.js"></script>
  <script src="plugins/select2/select2.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
  
  <script>
      
    $(function () {
 
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
      <h1>เพิ่มรายละเอียดการสั่งซื้อสินค้า</h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">การจัดการข้อมูล</a></li>
        <li class="active">รายละเอียดการสั่งซื้อสินค้า</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="col-xs-3">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">รายละเอียดการสั่งซื้อสินค้า</h3>
                    </div>
                        <div class="box-body">
                            <?php
                                $sql_po1 = "SELECT * FROM purchase_order JOIN company ON purchase_order.com_id = company.com_id JOIN employee ON purchase_order.emp_id = employee.emp_id AND purchase_order.po_id = '".$_SESSION['po_id']."'";
                                $query_po1 = mysqli_query($conn,$sql_po1);
                            
                                while($row = mysqli_fetch_array($query_po1,MYSQLI_ASSOC))
                                {
                            ?>
                            <div class="form-group">
                                <label>รหัสการสั่งซื้อสินค้า</label>
                                <input type="text" class="form-control" id="po_id" value="<?php echo "PO-".sprintf("%04d",$row['po_id']);?>" readonly>
                                <input type="hidden" id="new_po_id" value="<?php echo $row['po_id'];?>">
                            </div>
                            <div class="form-group">
                                <label>วันที่การสั่งซื้อ</label>
                                <?php
                                    if(!$edit_po_ck ){
                                ?>
                                    <input type="date" class="form-control" id="new_po_date" value="<?php echo $row['po_date']?>" readonly>
                                <?php
                                    }
                                    else{
                                ?>
                                    <input type="date" class="form-control" id="new_po_date" value="<?php echo $row['po_date']?>">
                                <?php
                                    }
                                ?>                                
                            </div>
                            <div class="form-group">
                                <label>บริษัทจัดจำหน่าย</label>
                                <input type="text" class="form-control" id="new_com_name" value="<?php echo $row['com_name'];?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>พนักงาน</label>
                                <input type="text" class="form-control" id="new_emp_name" value="<?php echo $row['emp_name'];?>" readonly>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                </div>
                <button class="btn btn-success" data-toggle="modal" data-target="#myModal">เพิ่มสินค้าสั่งซื้อ</button>

                <div class="modal fade" id="myModal" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">เพิ่มข้อมูลการสั่งซื้อสินค้า</h4>
                            </div>
                            <div class="modal-body">
                                        <div class="form-group">
                                            <label>ประเภทสินค้า</label>
                                            <select class="form-control select2" style="width: 100%;" id="new_pro_type" onChange="getProduct(this.value);">
                                                <option value="">เลือกประเภทสินค้า</option>
                                            <?php                                                
                                                while($row = mysqli_fetch_array($query_pro_type,MYSQLI_ASSOC))
                                                {
                                            ?>
                                                    <option value="<?php echo $row['pro_type_id'];?>"><?php echo $row['pro_type_name'];?></option>
                                            <?php
                                                }
                                            ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>รหัสสินค้า</label>
                                            <select class="form-control select2" style="width: 100%;" id="new_pro_id" onChange="getProductID(this.value);">
                                                <!--<option value="">เลือก</option>-->
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>จำนวนสินค้า </label>
                                            <input type="number" class="form-control" id="new_pro_amount">
                                        </div>
                                        <label>หน่วยของสินค้า</label>
                                        <select class="form-control select2" style="width: 100%;" id="new_pro_unit" disabled>
                                        </select>
                                        <!--<input type="text" class="form-control" id="new_pro_unit" readonly>-->
                                        <div class="form-group">
                                            <label>ราคาสินค้า</label>
                                            <div class="form-inline">
                                            <input type="number" class="form-control" id="new_pro_price">
                                            <label>บาท</label>
                                            </div>
                                        </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                                <button class="btn btn-success" onclick="add_item()">เพิ่มสินค้า</button>
                             </div>
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
                                    <th>จำนวนสินค้า</th>
                                    <th>หน่วยของสินค้า</th>
                                    <th>ราคาสินค้า/หน่วย (บาท)</th>
                                    <th>ราคารวม (บาท)</th>
                                    <th>การจัดการข้อมูล</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $sql_ck_empty_item = "SELECT * FROM purchase_order_detail WHERE po_id = '".$_SESSION['po_id']."'";
                                $query_ck_empty_item = mysqli_query($conn,$sql_ck_empty_item);
                                $obj2 = mysqli_fetch_array($query_ck_empty_item,MYSQLI_ASSOC);
                                
                                if(!empty($obj2)){
                                    
                                    $sql = "SELECT * FROM purchase_order_detail JOIN purchase_order ON purchase_order.po_id = purchase_order_detail.po_id JOIN product ON purchase_order_detail.pro_id = product.pro_id JOIN product_type ON product_type.pro_type_id = product.pro_type_id JOIN product_unit ON product_unit.pro_unit_id = product.pro_unit_id AND purchase_order_detail.po_id = '".$_SESSION['po_id']."'";
	                                $query = mysqli_query($conn,$sql);
                                    
                                    while($row = mysqli_fetch_array($query,MYSQLI_ASSOC)){
                            ?>
                                <tr id="row<?php echo $row['pod_id'];?>">
                                    <td id="pro_id_val<?php echo $row['pod_id'];?>"><?php echo "MCS-".sprintf("%04d",$row['pro_id'])?></td>
                                    <td id="pro_type_id_val<?php echo $row['pod_id'];?>"><?php echo $row['pro_type_name'];?></td>
                                    <td id="name_val<?php echo $row['pod_id'];?>"><?php
                                    if (strlen($row['pro_name']) > 20)
                                    {
                                        echo substr($row['pro_name'], 0, 20)."<font color='blue'> ...</font>";
                                    }
                                    else
                                    {
                                        echo $row['pro_name'];
                                    }?>
                                    <input type="hidden" id="pro_name_val<?php echo $row['pod_id'];?>" value="<?php echo $row['pro_name']?>">
                                    </td>
                                    <td id="pro_amount_val<?php echo $row['pod_id'];?>" align="right"><?php echo $row['pod_amount'];?></td>
                                    <td id="pro_unit_val<?php echo $row['pod_id'];?>"><?php echo $row['pro_unit_name'];?></td>
                                    <td id="pro_price_val<?php echo $row['pod_id'];?>" align="right"><?php echo number_format($row['pod_price'],2);?></td>
                                    <td id="pro_price_total_val<?php echo $row['pod_id'];?>" align="right"><?php echo number_format($row['pod_amount']*$row['pod_price'],2);?></td>
                                    <td>
                                        <button class="btn btn-warning" data-toggle="modal" data-target="#myModal2" id="edit_button<?php echo $row['pod_id'];?>" onclick="edit_row('<?php echo $row['pod_id'];?>');"><i class="fa fa-fw fa-pencil-square-o"></i></button>
                                        <button class="btn btn-danger" id="delete_button<?php echo $row['pro_id'];?>" onclick="delete_row('<?php echo $row['pod_id'];?>');"><i class="fa fa-fw fa-trash-o"></i></button>
                                    </td>
                                    <input type="hidden" id="price_val<?php echo $row['pod_id'];?>" value="<?php echo $row['pod_price'];?>">
                                </tr>
                            <?php
                                    }
                                }
                            ?>
                            </tbody>
                          </table>
                    </div>
                </div>
                
                <div class="modal fade" id="myModal2" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">แก้ไขข้อมูลการสั่งซื้อสินค้า</h4>
                            </div>
                            <div class="modal-body">
                                        <div class="form-group">
                                            <label>ประเภทสินค้า</label>
                                            <input type="text" class="form-control" id="edit_pro_type" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>รหัสสินค้า</label>
                                            <input type="text" class="form-control" id="edit_pro_id" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>จำนวนสินค้า </label>
                                            <input type="number" class="form-control" id="edit_pro_amount"> 
                                        </div>
                                        <div class="form-group">
                                            <label>หน่วยของสินค้า</label>
                                            <input type="text" class="form-control" id="edit_pro_unit" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>ราคาสินค้า</label>
                                            <div class="form-inline">
                                            <input type="number" class="form-control" id="edit_pro_price">
                                            <label>บาท</label>
                                            </div>
                                        </div>
                                        <input type="hidden" id="edit_new_pod_id">
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                                <input type="submit" class="btn btn-success" value="แก้ไขสินค้า" onclick="save_row();">
                             </div>
                        </div>
                    </div>
                </div>
                
                <button class="btn btn-success pull-right" name="" onclick="javascript:location.href='purchase_page3.php'">สรุปการสั่งซื้อสินค้า</button> 
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