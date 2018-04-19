<?php
    session_start();
	include("connect.php");  

	$sql = "SELECT * FROM product JOIN product_unit ON product.pro_unit_id = product_unit.pro_unit_id JOIN product_type ON product_type.pro_type_id = product.pro_type_id";
	$query = mysqli_query($conn,$sql);

    if(isset($_POST['edit_row'])){
        $row = $_POST['row_id'];
        $pro_type_val = $_POST['pro_type_val'];
        $pro_name_val = $_POST['pro_name_val'];
        $pro_detail_val = $_POST['pro_detail_val'];
        $pro_price_val = $_POST['pro_price_val'];
        $pro_amount_val = $_POST['pro_amount_val'];
        $pro_unit_val = $_POST['pro_unit_val'];
        $pro_discount_val = $_POST['pro_discount_val'];
        //$pro_picture_val = $_POST['pro_picture_val'];
        $pro_annotation_val = $_POST['pro_annotation_val'];
        
        $sql_ck_update = "SELECT * FROM product WHERE pro_name = '".$pro_name_val."' AND pro_id != '".$row."'";
        $query_ck_update = mysqli_query($conn,$sql_ck_update);
        $num = mysqli_num_rows($query_ck_update);
        
        if($num > 0){
            $mgs = "ไม่สามารถแก้ไขข้อมูลได้ !! เนื่องจากข้อมูลถูกซ้ำ.";
            $_SESSION['mgs'] = $mgs;
        }
        else{
            $sql_edit = "UPDATE product SET pro_type_id='".$pro_type_val."',pro_name='".$pro_name_val."',pro_detail='".$pro_detail_val."',pro_price='".$pro_price_val."',pro_amount='".$pro_amount_val."',pro_unit_id='".$pro_unit_val."',pro_discount='".$pro_discount_val."',pro_annotation='".$pro_annotation_val."' WHERE pro_id='".$row."'";
            mysqli_query($conn,$sql_edit);
            $mgs = "ทำการแก้ไขข้อมูลแล้ว!";
            $_SESSION['mgs'] = $mgs;
        }        
        exit();
    }    

    if(isset($_POST['delete_row'])){
        $pro_id = $_POST['row_id'];
        
        $sql_delete = "DELETE FROM product WHERE pro_id = '".$pro_id."'";
        
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
        $pro_type = $_POST['pro_type_val'];
        $pro_name = $_POST['pro_name_val'];
        $pro_detail = $_POST['pro_detail_val'];
        $pro_price = $_POST['pro_price_val'];
        $pro_amount = $_POST['pro_amount_val'];
        $pro_unit = $_POST['pro_unit_val'];
        $pro_discount = $_POST['pro_discount_val'];
        $pro_annotation = $_POST['pro_annotation_val'];
        
        $sql_add = "INSERT INTO product VALUES('','".$pro_type."','".$pro_name."','".$pro_detail."','".$pro_price."','".$pro_amount."','".$pro_unit."','".$pro_discount."','','".$pro_annotation."')";
        mysqli_query($conn,$sql_add);
        $mgs = "ทำการเพิ่มข้อมูลแล้ว!";
        $_SESSION['mgs'] = $mgs;
        exit();
    }

    /*if(isset($_FILES["file"]))
        {
            foreach($_FILES['file']['tmp_name'] as $key => $val)
            { 
                $file_name = $_FILES['file']['name'][$key];
                $file_size =$_FILES['file']['size'][$key];
                $file_tmp =$_FILES['file']['tmp_name'][$key];
                $file_type=$_FILES['file']['type'][$key];  
                move_uploaded_file($file_tmp,"image_product/".$file_name);
        
            }
            $new_file = "image_product/".$file_name;
            echo "Copy/Upload Complete";
        }*/ 
?>
<html>
<head>
<title>การจัดการสินค้า</title>
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
  <script type="text/javascript" src="modify_product.js"></script>
  
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
    /*$("#upload").on("click", function() {
    var file_data = $("#file").prop("f iles")[0];   
    var form_data = new FormData();
    form_data.append("file", file_data);
    alert(form_data);
    $.ajax({
        url: "/product_page.php",
        dataType: 'script',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(){
            alert("works"); 
        }
    });
});*/
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
        การจัดการข้อมูลสินค้า
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#"></a>การจัดการข้อมูล</li>
        <li class="active">สินค้า</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">ตารางข้อมูลสินค้า</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="pro_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>รหัสสินค้า</th>
                        <th>ประเภทสินค้า</th>
                        <th>ชื่อสินค้า</th>
                        <th>ราคาสินค้า/หน่วย (บาท)</th>
                        <th>จำนวนสินค้า</th>
                        <th>หน่วยของสินค้า</th>
                        <th>การจัดการข้อมูล</th>
                    </tr>
                </thead>
                <tbody>
                <?php
					while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
					{
                ?>
                    <tr id="row<?php echo $row['pro_id'];?>">
                        <td id="pro_id_val<?php echo $row['pro_id'];?>"><?php echo "MCS-".sprintf("%04d",$row['pro_id']);?></td>
                        <td id="pro_type_val<?php echo $row['pro_id'];?>"><?php echo $row['pro_type_name'];?></td>
                        <td id="name_val<?php echo $row['pro_id'];?>"><?php 
                        if (strlen($row['pro_name']) > 50)
                        {
                            echo substr($row['pro_name'], 0, 50)."<font color='blue'> ...</font>";
                        }
                        else
                        {
                            echo $row['pro_name'];
                        }?></td>
                        <td id="price_val<?php echo $row['pro_id'];?>" align="right"><?php echo number_format($row['pro_price'],2);?></td>
                        <td id="pro_amount_val<?php echo $row['pro_id'];?>" align="right"><?php echo $row['pro_amount'];?></td>
                        <td id="pro_unit_val<?php echo $row['pro_id'];?>"><?php echo $row['pro_unit_name'];?></td>     
                        <input type="hidden" value="<?php echo $row['pro_type_id'];?>" id="pro_type_id_val<?php echo $row['pro_id'];?>">
                        <input type="hidden" value="<?php echo $row['pro_name'];?>" id="pro_name_val<?php echo $row['pro_id'];?>">
                        <input type="hidden" value="<?php echo $row['pro_detail'];?>" id="pro_detail_val<?php echo $row['pro_id'];?>">
                        <input type="hidden" value="<?php echo $row['pro_unit_id'];?>" id="pro_unit_id_val<?php echo $row['pro_id'];?>">
                        <input type="hidden" value="<?php echo $row['pro_price'];?>" id="pro_price_val<?php echo $row['pro_id'];?>">
                        <input type="hidden" value="<?php echo $row['pro_discount'];?>" id="pro_discount_val<?php echo $row['pro_id'];?>">
                        <input type="hidden" value="<?php echo $row['pro_picture'];?>" id="pro_picture_val<?php echo $row['pro_id'];?>">
                        <input type="hidden" value="<?php echo $row['pro_annotation'];?>" id="pro_annotation_val<?php echo $row['pro_id'];?>">
                        <td>
                            <button class="btn btn-warning" data-toggle="modal" data-target="#myModal2" id="edit_button<?php echo $row['pro_id'];?>" onclick="edit_row('<?php echo $row['pro_id'];?>');"><i class="fa fa-fw fa-pencil-square-o"></i></button>
                            <button class="btn btn-info" data-toggle="modal" data-target="#myModal3" id="view_button<?php echo $row['pro_id'];?>" onclick="view_row('<?php echo $row['pro_id'];?>');"><i class="fa fa-fw fa-search-plus"></i></button>
                            <button class="btn btn-danger" id="delete_button<?php echo $row['pro_id'];?>" onclick="delete_row('<?php echo $row['pro_id'];?>');"><i class="fa fa-fw fa-trash-o"></i></button>
                        </td> 
                    </tr>
                <?php
					}
				?>
                </tbody>
              </table>
            </div>
          </div>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">เพิ่มข้อมูลสินค้า</button>
                <!--<form id="formUpload" method="post" enctype="multipart/form-data">-->
                <div class="modal fade" id="myModal" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">เพิ่มข้อมูลสินค้า</h4>
                            </div>
                            <div class="modal-body">
                                        <div class="form-group">
                                            <label>ประเภทสินค้า<font color="red"> *</font></label>
                                            <select class="form-control select2" style="width: 100%;" id="new_pro_type">
                                                <option value="">เลือกประเภทสินค้า</option>
                                                <?php
                                                    $sql_type = "SELECT * FROM product_type";
                                                    $query_type = mysqli_query($conn,$sql_type);
                                                
                                                    while($row = mysqli_fetch_array($query_type,MYSQLI_ASSOC))
                                                    {
                                                ?>
                                                        <option value="<?php echo $row['pro_type_id'];?>"><?php echo $row['pro_type_name'];?></option>
                                                <?php                                                
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>ชื่อสินค้า<font color="red"> *</font></label>
                                            <input type="text" class="form-control" id="new_pro_name">
                                        </div>
                                        <div class="form-group">
                                            <label>รายละเอียดสินค้า</label>
                                            <textarea class="form-control" row="3" id="new_pro_detail"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>ราคาสินค้า/หน่วย (บาท)<font color="red"> *</font></label>
                                            <input type="number" class="form-control" id="new_pro_price">
                                        </div>
                                        <div class="form-group">
                                            <label>จำนวน<font color="red"> *</font></label>
                                            <input type="number" class="form-control" id="new_pro_amount">
                                        </div>
                                        <div class="form-group">
                                            <label>หน่วยของสินค้า<font color="red"> *</font></label>
                                            <select class="form-control select2" style="width: 100%;" id="new_pro_unit">
                                                <option value="">เลือกหน่วยของสินค้า</option>
                                                <?php
                                                    $sql_unit = "SELECt * FROM product_unit";
                                                    $query_unit = mysqli_query($conn,$sql_unit);
                                                
                                                    while($row = mysqli_fetch_array($query_unit,MYSQLI_ASSOC))
                                                    {
                                                ?>
                                                        <option value="<?php echo $row['pro_unit_id'];?>"><?php echo $row['pro_unit_name'];?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>ส่วนลด (%)</label>
                                            <input type="number" class="form-control" id="new_pro_discount">
                                        </div>
                                        <!--<div class="form-group">
                                            <label>รูปภาพ</label>
                                            <input type="file" id="new_pro_picture" name="file[]" multiple="multiple">
                                        </div>-->
                                        <div class="form-group">
                                            <label>หมายเหตุ</label>
                                            <input type="text" class="form-control" id="new_pro_annotation">
                                        </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                                <button class="btn btn-success" onclick="insert_row()">เพิ่ม</button>
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
                                <h4 class="modal-title">แก้ไขข้อมูลสินค้า</h4>
                            </div>
                            <div class="modal-body">
                                        <div class="form-group">
                                            <label>รหัสสินค้า</label>
                                            <input type="text" class="form-control" id="edit_pro_id" readonly>
                                            <input type="hidden" id="edit_id">
                                        </div>
                                         <div class="form-group">
                                            <label>ประเภทสินค้า<font color="red"> *</font></label>
                                            <select class="form-control select2" style="width: 100%;" id="edit_pro_type" required>
                                                <option value="">เลือกประเภทสินค้า</option>
                                                <?php
                                                    $sql_type = "SELECT * FROM product_type";
                                                    $query_type = mysqli_query($conn,$sql_type);
                                                
                                                    while($row = mysqli_fetch_array($query_type,MYSQLI_ASSOC))
                                                    {
                                                ?>
                                                        <option value="<?php echo $row['pro_type_id'];?>"><?php echo $row['pro_type_name'];?></option>
                                                <?php                                                
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>ชื่อสินค้า<font color="red"> *</font></label>
                                            <input type="text" class="form-control" id="edit_pro_name" required>
                                        </div>
                                        <div class="form-group">
                                            <label>รายละเอียดสินค้า</label>
                                            <textarea class="form-control" row="3" id="edit_pro_detail"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>ราคาสินค้า/หน่วย (บาท)<font color="red"> *</font></label>
                                            <input type="number" class="form-control" id="edit_pro_price" required>
                                        </div>
                                        <div class="form-group">
                                            <label>จำนวน<font color="red"> *</font></label>
                                            <input type="number" class="form-control" id="edit_pro_amount" required>
                                        </div>
                                        <div class="form-group">
                                            <label>หน่วยของสินค้า<font color="red"> *</font></label>
                                            <select class="form-control select2" style="width: 100%;" id="edit_pro_unit" required>
                                                <option value="">เลือกหน่วยของสินค้า</option>
                                                <?php
                                                    $sql_unit = "SELECt * FROM product_unit";
                                                    $query_unit = mysqli_query($conn,$sql_unit);
                                                
                                                    while($row = mysqli_fetch_array($query_unit,MYSQLI_ASSOC))
                                                    {
                                                        
                                                ?>
                                                        <option value="<?php echo $row['pro_unit_id'];?>"><?php echo $row['pro_unit_name'];?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>ส่วนลด (%)</label>
                                            <input type="number" class="form-control" id="edit_pro_discount">
                                        </div>
                                        <!--<div class="form-inline">
                                            <label>รูปภาพ</label>
                                            <input type="file" class="form-control" id="edit_pro_picture">
                                            <button class="btn" id="upload_edit">Upload</button>
                                        </div>-->
                                        <div class="form-group">
                                            <label>หมายเหตุ</label>
                                            <input type="text" class="form-control" id="edit_pro_annotation">
                                        </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                                <button class="btn btn-success" onclick="save_row()">บันทึก</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModal3" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">ดูข้อมูลสินค้าเพิ่มเติม</h4>
                            </div>
                            <div class="modal-body">
                                        <div class="form-group">
                                            <label>รหัสสินค้า</label>
                                            <input type="text" class="form-control" id="view_pro_id" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>ประเภทสินค้า</label>
                                            <select class="form-control select2" style="width: 100%;" id="view_pro_type" disabled>
                                                <option value="">เลือกประเภทสินค้า</option>
                                                <?php
                                                    $sql_type = "SELECT * FROM product_type";
                                                    $query_type = mysqli_query($conn,$sql_type);
                                                
                                                    while($row = mysqli_fetch_array($query_type,MYSQLI_ASSOC))
                                                    {
                                                ?>
                                                        <option value="<?php echo $row['pro_type_id'];?>"><?php echo $row['pro_type_name'];?></option>
                                                <?php                                                
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>ชื่อสินค้า</label>
                                            <input type="text" class="form-control" id="view_pro_name" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>รายละเอียดสินค้า</label>
                                            <textarea class="form-control" row="3" id="view_pro_detail" readonly></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>ราคาสินค้า/หน่วย (บาท)</label>
                                            <input type="text" class="form-control" id="view_pro_price" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>จำนวน</label>
                                            <input type="number" class="form-control" id="view_pro_amount" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>หน่วยของสินค้า</label>
                                            <select class="form-control select2" style="width: 100%;" id="view_pro_unit" disabled>
                                                <option value="">เลือกหน่วยของสินค้า</option>
                                                <?php
                                                    $sql_unit = "SELECt * FROM product_unit";
                                                    $query_unit = mysqli_query($conn,$sql_unit);
                                                
                                                    while($row = mysqli_fetch_array($query_unit,MYSQLI_ASSOC))
                                                    {
                                                ?>
                                                        <option value="<?php echo $row['pro_unit_id'];?>"><?php echo $row['pro_unit_name'];?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>ส่วนลด (%)</label>
                                            <input type="number" class="form-control" id="view_pro_discount" readonly>
                                        </div>
                                        <!--<div class="form-group">
                                            <label>รูปภาพ</label>
                                            <input type="file" id="view_pro_picture" name="file[]" multiple="multiple" disabled>
                                        </div>-->
                                        <div class="form-group">
                                            <label>หมายเหตุ</label>
                                            <input type="text" class="form-control" id="view_pro_annotation" readonly>
                                        </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                            </div>
                        </div>
                    </div>
                </div>
          </div>
          <!-- /.box -->
        </div>
    </section>
    <!-- /.content -->
  </div>
</div>
</body>
</html>