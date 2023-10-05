<?php
session_start();
if (!isset($_SESSION['u_email']))
{
header("location: loginpage.php");
}
?>