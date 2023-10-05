<?php
session_start();
session_destroy(); //destroy the session
header("location: loginpage.php");
exit();
?>