<?php
include("connect.php");

if(isset($_POST['edit_row']))
{
 $row=$_POST['row_id'];
 $name=$_POST['name_val'];
 $age=$_POST['age_val'];

 mysqli_query($conn,"update user_detail set name='$name',age='$age' where id='$row'");
 echo "success";
 exit();
}

if(isset($_POST['delete_row']))
{
 $row_no=$_POST['row_id'];
 mysqli_query($conn,"delete from user_detail where id='$row_no'");
 echo "success";
 exit();
}

if(isset($_POST['insert_row']))
{
 $name=$_POST['name_val'];
 $age=$_POST['age_val'];
 mysqli_query($conn,"insert into user_detail values('','$name','$age')");
 echo mysqli_insert_id();
 exit();
}
?>