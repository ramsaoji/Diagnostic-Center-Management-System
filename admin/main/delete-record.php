<?php
session_start();
include('db.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../index.php');
}
else{
ob_start();	
?>

<?php

$pid = $_GET['selectvalue'];

$delsql= "DELETE FROM `patient` WHERE id='$pid' ";


if(mysqli_query($con,$delsql))
{                            
	header("Location: record-manage-show.php");
}


?>

<?php 

ob_end_flush();
}
?>