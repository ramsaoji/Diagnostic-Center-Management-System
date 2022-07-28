<?php
session_start();
include('db.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../index.php');
}
else{

    $val = $_GET['selectvalue'];

    // $file = 'http://localhost/hospital/admin/json/sub_scan_type_data.json';
    // $file_content = file_get_contents($file);
    $array_encode = $_SESSION['sub_scan_type_json'];

    $array_decode = json_decode($array_encode, true);
    $length = count($array_decode);

    for($i = 0; $i < $length; $i++){

        if($val == $array_decode[$i]["sub_id"]){

            $srate = $array_decode[$i]["scan_sub_rate"];
            echo $srate; 
        }    
  
    }

}
?>
