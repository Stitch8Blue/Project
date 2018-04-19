<?php
    session_start();

    /*unset($_SESSION['UserID']);
    unset($_SESSION['UserName']);*/
    session_destroy();
    
    //echo "<script type='JavaScript'>setTimeout(function() { alert('Test'); }, 5000);</script>";

   echo "<script type='text/javascript'>window.location.href = 'login.php';</script>";
?>