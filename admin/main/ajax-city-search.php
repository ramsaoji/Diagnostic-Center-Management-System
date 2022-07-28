<?php
session_start();
include('db.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../index.php');
}
else{
if(isset($_POST["query"],$_POST["search"])){  

     // $file = 'http://localhost/hospital/admin/json/city_data.json';
     // $file_content = file_get_contents($file);
     
     $array_encode = $_SESSION['city_json'];

     $array_decode = json_decode($array_encode, true);
     $length = count($array_decode);

     $output = '';
     $search = $_POST["query"];
     $search = strtolower($search);
     
     $output = '<ul style= "overflow-y: auto; max-height: 180px;" class="list-unstyled">';

      $max_result = 300;

    function startsWith ($string, $startString)
    {
         $len = strlen($startString);
         return (substr($string, 0, $len) === $startString);
    }
    
    $first_name_list = array();
    $last_name_list = array();
    $contains_name_list = array();
    $main_list = array();
    

    for($i = 0; $i < $length; $i++){

         $city_name = $array_decode[$i]["city_name"];
         $city_name = strtolower($city_name);
         $name_array = explode(' ',$city_name);
         $temp = '<li>'.$array_decode[$i]["city_name"].'</li>';

         if(startsWith($name_array[0], $search)){

              array_push($first_name_list, $temp);

         }elseif(count($name_array) > 1 && startsWith($name_array[1], $search)){

          array_push($last_name_list, $temp);

          }elseif(str_contains($city_name, $search)){


              array_push($contains_name_list, $temp);
         }
  
    }
    sort($first_name_list);
    sort($last_name_list);
    sort($contains_name_list);

    $main_list = array_merge($main_list,$first_name_list);

    if(count($main_list) < $max_result ){

     $main_list = array_merge($main_list,$last_name_list);

     }

     if(count($main_list) < $max_result ){

          $main_list =  array_merge($main_list,$contains_name_list);
     }

    for($j = 0; $j < count($main_list) && $j < $max_result ; $j++){

              $output .= $main_list[$j]; 
    }

    if(count($main_list) == 0){
         $output .= '<li>City Not Found</li>';
    }

     $output .= '</ul>';
     
     echo $output;

     }

 } 
 ?>
