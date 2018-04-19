<?php
    session_start();
    include("connect.php");

    if(isset($_POST['submit'])){
        $user = $_POST['user'];
        $pass = md5($_POST['pass']);
        $pass = substr($pass,0,20);
        
        $sql = "SELECT * FROM employee WHERE emp_user = '".$user."' AND emp_pass = '".$pass."'";
        
        //echo $sql;
        $query = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
        
        if(!$row){
            echo "<script>alert('ชื่อผู้ใช้ หรือ รหัสผ่าน ไม่ถูกต้อง !!');</script>";
        }
        else{
            
            $_SESSION['UserID'] = $row['emp_id'];
            $_SESSION['UserName'] = $row['emp_name'];
            $_SESSION['UserStatus'] = $row['emp_status'];

            echo "<script type='text/javascript'>window.location.href = 'home.php';</script>";
	   }  
    }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
    
  <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="dist/css/styleFont.css" />
    
  <script src="dist/js/app.min.js"></script>
  <script src="dist/js/demo.js"></script>
  
  <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <script src="plugins/fastclick/fastclick.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
  <script src="plugins/iCheck/icheck.min.js"></script>
    
  <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue', 
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
</script>
    
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Microscience</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">

    <form action="login.php" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="user" placeholder="ชื่อผู้ใช้" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="pass" placeholder="รหัสผ่าน" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <!--<div class="checkbox icheck">
            <label>
              <input type="checkbox"> จำไว้ในระบบ
            </label>
          </div>-->
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat">เข้าสู่ระบบ</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <a href="#">ลืมรหัสผ่าน</a><br>
  </div>
</div>
</body>
</html>
