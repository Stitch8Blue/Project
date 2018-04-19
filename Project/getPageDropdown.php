<?php
include("connect.php");

if(isset($_POST['pro_type_id'])) {
	$sql ="SELECT * FROM product JOIN product_type ON product.pro_type = product_type.pro_type_name AND product_type.pro_type_id = '".$_POST['pro_type_id']."'";
	$query = mysqli_query($conn,$sql);
?>
	<option value="">เลือกสินค้า</option>
<?php
	while($row = mysqli_fetch_array($query,MYSQLI_ASSOC)){
?>
	<option value="<?php echo $row["pro_id"]; ?>"><?php echo $row["pro_id"]; ?></option>
<?php
	}
}
?>