<?php 
if(!isset($_SESSION['username'])){
 header("Location:login.php");
$_SESSION['error']='Please login to access !!!!' ;
}
?>