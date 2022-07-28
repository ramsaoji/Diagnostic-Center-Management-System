<?php
// session_start();
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../index.php');
}
else{

      function dr_table(){

            include('db.php');

            $query = "SELECT dm.doc_id, dm.doc_name, c.city_name FROM doctor_master dm INNER JOIN city c ON dm.city_city_id = c.city_id;";
            $result = mysqli_query($con, $query);
            $json_array = array();
            
            if(mysqli_num_rows($result) > 0)  
            {  
                  while($row = mysqli_fetch_assoc($result))  
                  {    
                        $json_array[] = $row;
                  }  
            }  
            else  
            {  
                  $output = "Error";
                  echo $output;
            } 

            $array_encode = json_encode($json_array,true);

            $_SESSION['dr_json'] = $array_encode;

            // $fo = fopen("../json/dr_data.json","w");
            // $fr = fwrite($fo,$array_encode);

      }

      function sub_master_type_table(){

            include('db.php');

            $query = "SELECT * FROM sub_master_type;";
            $result = mysqli_query($con, $query);
            $json_array = array();
            
            if(mysqli_num_rows($result) > 0)  
            {  
                  while($row = mysqli_fetch_assoc($result))  
                  {    
                        $json_array[] = $row;
                  }  
            }  
            else  
            {  
                  $output = "Error";
                  echo $output;
            } 

            $array_encode_sub_master_type = json_encode($json_array,true);

            $_SESSION['sub_master_type_json'] = $array_encode_sub_master_type;

            // $fo = fopen("../json/sub_master_type_data.json","w");
            // $fr = fwrite($fo,$array_encode_sub_master_type);

      }

      function sub_scan_type_table(){

            include('db.php');

            $query = "SELECT * FROM sub_scan_type;";
            $result = mysqli_query($con, $query);
            $json_array = array();
            
            if(mysqli_num_rows($result) > 0)  
            {  
                  while($row = mysqli_fetch_assoc($result))  
                  {    
                        $json_array[] = $row;
                  }  
            }  
            else  
            {  
                  $output = "Error";
                  echo $output;
            } 

            $array_encode_sub_scan_type = json_encode($json_array,true);

            $_SESSION['sub_scan_type_json'] = $array_encode_sub_scan_type;

            // $fo = fopen("../json/sub_scan_type_data.json","w");
            // $fr = fwrite($fo,$array_encode_sub_scan_type);

      }


      function city_table(){

            include('db.php');

            $query = "SELECT * FROM city;";
            $result = mysqli_query($con, $query);
            $json_array = array();
            
            if(mysqli_num_rows($result) > 0)  
            {  
                  while($row = mysqli_fetch_assoc($result))  
                  {    
                        $json_array[] = $row;
                  }  
            }  
            else  
            {  
                  $output = "Error";
                  echo $output;
            } 

            $array_encode_city = json_encode($json_array,true);

            $_SESSION['city_json'] = $array_encode_city;

            // $fo = fopen("../json/city_data.json","w");
            // $fr = fwrite($fo,$array_encode_city);

      }

      dr_table();
      sub_master_type_table();
      sub_scan_type_table();
      city_table();

      
}

?>