<?php
session_start();
include('db.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../index.php');
}
else{
date_default_timezone_set('Asia/Kolkata');
?>

<?php 
include 'db.php'; 
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Record</title>
    <!-- Bootstrap Styles-->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="../assets/css/custom-styles.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
        integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
        crossorigin="anonymous" />

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <link href="../assets/css/custom-styles.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="../scripts/newpatient_script.js"></script>

</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <!-- <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button> -->
                <a class="navbar-brand" href="newpatient.php">Admin</a>
            </div>

            <!-- <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                    
                        <li><a href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
                        </li>
                    </ul>
                  
                </li>
              
            </ul> -->
        </nav>

        <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <a href="newpatient.php"><i class="fa fa-plus"></i> New</a>
                    </li>

                    <li>
                        <a href="reports.php"><i class="far fa-file-alt"></i> Reports</a>
                    </li>

                    <li>
                        <a  href="record-manage-show.php"><i class="fa fa-database"></i> Manage</a>
                    </li>

                    <li>
                        <a href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
                    </li>
                </ul>
            </div>

        </nav>
        <!-- /. NAV SIDE  -->


        <?php 
            if(!isset($_GET["uid"]))
            {
               header("location:index.php");
            }
            else {
                // $curdate=date("Y/m/d");
                include ('db.php');
                $uid = $_GET['uid'];
                               
                $query = "call manage('$uid');";
                $re = mysqli_query($con,$query);
                while($row=mysqli_fetch_array($re))
                {
                  $PId = $row['PId'];
                  $R_date = $row['R_date'];
                  $Doc_Id = $row['Doc_Id'];
                  $Doc_Name = $row['Doc_Name'];
                  $Doc_City = $row['City_Name'];
                  $Master_Type_Id = $row['Master_Type_Id'];
                  $Master_Type = $row['Master_Type'];
                  $Sub_Master_Type_Id = $row['Sub_Master_Type_Id'];
                  $Sub_Master_Type = $row['Sub_Master_Type'];
                  $Final_Type_Id = $row['Final_Type_Id'];
                  $Final_Type = $row['Final_Type'];
                  $Original_Price = $row['Original_Price'];
                  $Discounted_Price = $row['Discounted_Price'];
                //   $Last_Updated = $row['Last_Updated'];
                }

              }

            ?>             


        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                        
                        <?php echo "Manage Patient Id - <span>$PId</span>";
                        ?>
                        <!-- <div id="sub_title">
                            <h3>
                                <?php echo "Manage Patient Id - <span></span>";
                                ?>
                            </h3>
                        </div> -->
                        <div id="sub_title">
                            <h4>
                                <?php
                                    include 'db.php';
                                    $query = "select DATE_FORMAT(`last_updated`, '%Y-%m-%d %H:%i:%s') as `last_updated` from patient where id = '$uid'"; 
                                    $result = mysqli_query($con, $query);
                                    $rows = mysqli_fetch_array($result);
                                    $last_updated = $rows['last_updated'];
                                ?>
                                
                                <?php 
                                if(is_null($last_updated) != 1){
                                    echo "Last Updated - <span>$last_updated</span>";
                                }
                                
                                ?>
                            </h4>
                        </div>
                        </h1>
                    </div>
                </div>


                <table class="row">

                    <div class="col-md-6 col-sm-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                PATIENT INFORMATION - (MANDATORY)
                            </div>
                            <div class="panel-body">

                                <form name="form" method="post" action="">

                                <div class="form-group">
                                    <label>Date*</label>
                    
                                    <!-- <input name="r_date" type="date" class="form-control" max="<?php echo date("Y-m-d"); ?>" value="<?php  echo $R_date;?>" required> -->

                                    <input type="text" name="r_date" id="r_date" class="form-control dateFilter" autocomplete="off" value="<?php echo date('Y-m-d'); ?>" required readonly/>

                                </div>

                                <div class="form-group">
                                    <label>Refered By*</label>
                    

                                    <input id='search_dr' name='search_dr' class="form-control" autocomplete="off" placeholder="Search doctor name..." value="<?php  echo $Doc_Name . ' ('.$Doc_City.')';?>" required>
                                    <div id="drList"></div>

                                </div>

                                <!-- <div class="form-group">
                                    <label>Dr. City</label>
                                    <input id="doc_city" name="city" type="text" maxlength="20" class="form-control" readonly>

                                </div> -->

                                <div class="form-group">
                                    <label>Master Scan Type*</label>
                                    <select id="sub_master_type" name="scan" class="form-control" onchange="scan_master_sub(this.value)" data-toggle="tooltip"  required >
                                        <option disabled value="<?php echo $Master_Type_Id;?>" selected><?php  echo $Master_Type;?> - Select again if want to change scan types</option>
                                        <!-- <option value selected></option> -->

                                        <?php
                                        include 'db.php';
                                        $query = "select scan_id,scan_type_master from scan_rates";
                                        $result = mysqli_query($con, $query);
                                        ?>
                                        <?php while ($rows = mysqli_fetch_array($result)) {
                                            $sr_id=$rows['scan_id'];
                                            $sr_type = $rows['scan_type_master']; ?>
                                        <?php echo "<option value=$sr_id> $sr_type </option>";
                                        } ?>

                                    </select>
                                </div>

                

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                PATIENT INFORMATION - (MANDATORY)
                            </div>
                            <div class="panel-body">

                                <div class="form-group">
                                    <label>Sub Scan Type*</label>
                                    <select id="sub_master_scan" name="sub_master_scan" class="form-control" onchange="scan_sub_child(this.value)" data-toggle="tooltip" required >
                                        <option value="<?php echo  $Sub_Master_Type_Id;?>" selected><?php  echo $Sub_Master_Type;?></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Type*</label>
                                    <select id="sub_child_scan" name="sub_child_scan" class="form-control" onchange="original_price(this.value)" data-toggle="tooltip"  required>
                                        <option value="<?php echo  $Final_Type_Id;?>" selected><?php echo $Final_Type;?></option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <span style="display : inline-block; width:47%;";>
                                        <label>Original Price</label>
                                        <input id="oprice" name="oprice" value="<?php echo $Original_Price;?>" class="form-control"  readonly >
                                    </span>
                                    
                                    <span style="display : inline-block; width:47%; float:right;";>
                                        <label>New Price (Optional)</label>
                                        <input id="dprice" name="dprice" 
                                        value="<?php 
                                        if($Original_Price != $Discounted_Price){
                                            echo $Discounted_Price;
                                        }
                                        ?>" class="form-control" placeholder="Enter New Price or Leave Empty" autocomplete="off" type = "number" >
                                    </span>
                                </div>                             
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-sm-6" >

                        <button id="sub-btn" name="update" class="btn btn-primary" style="width: 100px;"><i class="fas fa-sync"></i>  Update</button>

                        <button id="sub-btn-delete"  name="delete" class="btn btn-danger" style="width: 100px; margin-left: 20px;"><i class="fa fa-trash"></i>  Delete</button>

                    <?php

                      if(isset($_POST['update']))
                      {
                        
                        // $file = 'http://localhost/hospital/admin/json/dr_data.json';
                        // $file_content = file_get_contents($file);
                        $current_timestamp = date('Y-m-d H:i:s');
                        $array_encode = $_SESSION['dr_json'];
                        $array_decode = json_decode($array_encode, true);
                        $length = count($array_decode);

                        $dr_search = $_POST["search_dr"];
                        $r_date = $_POST['r_date'];
                        $flag_name = 0;
                        $sql_check = 0;
                    
                        for($i = 0; $i < $length; $i++){

                            $dr_name = $array_decode[$i]["doc_name"] .' ('.$array_decode[$i]["city_name"].')';
                            if($_POST['search_dr'] === $dr_name){

                                $doc_id = $array_decode[$i]["doc_id"];
                                $flag_name = 1;
                             
                            }
                        }
                    

                        if($flag_name == 1) {

                            if($_POST["dprice"] == ''){

                                $newUser="UPDATE `patient` SET `Record_date` = '$r_date',`sub_id` = '$_POST[sub_child_scan]',`doc_id` = '$doc_id',`discounted_price` = '$_POST[oprice]',`last_updated` = '$current_timestamp' WHERE id = '$uid'";

                                $sql_check = 1;

                            }else{

                                $newUser="UPDATE `patient` SET `Record_date` = '$r_date',`sub_id` = '$_POST[sub_child_scan]',`doc_id` = '$doc_id',`discounted_price` = '$_POST[dprice]',`last_updated` = '$current_timestamp' WHERE id = '$uid'";

                                $sql_check = 1;

                            }

                        }else{

                            echo '<script type="text/javascript">
                            swal({
                                title: "Invalid Doctor Name.",
                                text: "Please select from search results only!!"
                                });
                            </script>';
                        }
                        if($sql_check == 1){

                            if (mysqli_query($con,$newUser))
                            {
                        
                            echo '<script type="text/javascript">
                            swal({
                                title: "Successfully Updated!"         
                                }).then(function() {
                                    window.location = "record-manage-show.php";
                                    });

                            </script>';

                            }
                            else
                            {
                            echo '<script type="text/javascript">
                            swal({
                                title: "Error adding details in database"
                                });
                            </script>';
                            
                            }

                        }
                      }
                      
                      if(isset($_POST['delete']))
                      {

                        echo '<script type="text/javascript">
                        swal({
                            title: "Are you sure?",
                            text: "Once deleted, you will not be able to recover it!",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        }).then((willDelete) => {
                            if (willDelete) {
                            swal({
                                title: "Record deleted!",
                                icon: "success"
                            }).then(function(){
                                window.location = "delete-record.php?selectvalue='.$uid.'";
                            });
                            } else {
                                window.location = "record-manage-actual.php?uid='.$uid.'";
                            }
                        });

                        </script>';
                      }
                           
                     ?>
                     </div>
                        </form>

                        <!-- /. PAGE INNER  -->
                    </div>
                    <!-- /. PAGE WRAPPER  -->
            </div>
            <!-- /. WRAPPER  -->
            
</body>

</html>

<?php } ?>