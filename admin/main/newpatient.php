<?php
session_start();
include('db.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../index.php');
}
else{
include_once 'get_json.php';
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>New Patient</title>
    <!-- Bootstrap Styles-->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />

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
                <a class="navbar-brand" href="newpatient.php">Admin</a>
            </div>
        </nav>

        <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu" style="z-index: -1;">

                    <li>
                        <a class="active-menu" href="newpatient.php"><i class="fa fa-plus"></i> New</a>
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

        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                        <?php
                            include 'db.php';
                            $query = "select count(id) as `cnt` from patient where date_format(record_date, '%Y-%m-%d') = current_date";
                            $result = mysqli_query($con, $query);
                            $rows = mysqli_fetch_assoc($result);
                            $count = $rows['cnt'];
                        ?>
                        <?php echo "TODAY'S PATIENTS - <span>$count</span>";
                        ?>
                        <div id="sub_title">
                            <h3>
                                <?php
                                    include 'db.php';
                                    $query = "select max(id)+1 as `cnt` from patient"; 
                                    $result = mysqli_query($con, $query);
                                    $rows = mysqli_fetch_assoc($result);
                                    $count = $rows['cnt'];
                                ?>
                                <?php echo "Current Patient Id - <span>$count</span>";
                                ?>
                            </h3>
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

                                    <input type="text" name="r_date" id="r_date" class="form-control dateFilter" autocomplete="off" value="<?php echo date('Y-m-d'); ?>" required readonly/>

                                    

                                </div>

                                <div class="form-group">
                                    <label>Refered By*</label>

                                    <input id='search_dr' name='search_dr' class="form-control" autocomplete="off" placeholder="Search doctor name..." required>
                                    <div id="drList"></div>

                                </div>

                                <div class="form-group">
                                    <label>Master Scan Type*</label>
                                    <select name="scan" class="form-control" onchange="scan_master_sub(this.value)" data-toggle="tooltip" required >
                                        <option value="" disabled selected>Select master scan type</option>

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
                                        <option value="" disabled selected>Select sub scan type</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Type*</label>
                                    <select id="sub_child_scan" name="sub_child_scan" class="form-control" onchange="original_price(this.value)" data-toggle="tooltip" required>
                                        <option value="" disabled selected>Select type</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <span style="display : inline-block; width:47%;";>
                                        <label>Original Price</label>
                                        <input id="oprice" name="oprice" value='' class="form-control"  readonly >
                                    </span>
                                    
                                    <span style="display : inline-block; width:47%; float:right;";>
                                        <label>New Price (Optional)</label>
                                        <input id="dprice" name="dprice" class="form-control" placeholder="Enter New Price or Leave Empty" autocomplete="off" type = "number" >
                                    </span>
                                </div>
                               
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12 col-sm-12">

                        <input id="sub-btn" type="submit" name="submit" class="btn btn-primary" />

                    <?php

                      if(isset($_POST['submit']))
                      {

                        // $file = 'http://localhost/hospital/admin/json/dr_data.json';
                        // $file_content = file_get_contents($file);
                        $array_encode = $_SESSION['dr_json'];
                        $array_decode = json_decode($array_encode, true);
                        $length = count($array_decode);

                        $dr_search = $_POST["search_dr"];
                        $flag_name = 0;
                        $sql_check = 0;
                    
                        for($i = 0; $i < $length; $i++){

                            $dr_name = $array_decode[$i]["doc_name"] .' ('.$array_decode[$i]["city_name"].')';

                            if($_POST['search_dr'] === $dr_name){

                                $doc_id = $array_decode[$i]["doc_id"];
                                $flag_name = 1;
                                break;
                             
                            }
                            
                        }
                        // print_r($doc_id);
                    
                        $r_date = $_POST['r_date'];
                        
                        $p_tableid = "SELECT max(id)+1 as `cnt` FROM patient";
                        $rsp = mysqli_query($con,$p_tableid);
                        $rows = mysqli_fetch_assoc($rsp);
                        $countp = $rows['cnt'];

                        if($flag_name == 1) {

                            if($_POST["dprice"] == ''){

                                $newUser="INSERT INTO `patient`(`id`,`Record_date`,`sub_id`,`doc_id`,`discounted_price`) 
                            VALUES ('$countp','$r_date','$_POST[sub_child_scan]','$doc_id','$_POST[oprice]')";

                                $sql_check = 1;

                            }else{

                                $newUser="INSERT INTO `patient`(`id`,`Record_date`,`sub_id`,`doc_id`,`discounted_price`) 
                            VALUES ('$countp','$r_date','$_POST[sub_child_scan]','$doc_id','$_POST[dprice]')";

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
                                title: "Successfully Submitted!"         
                                }).then(function() {
                                    window.location = "newpatient.php";
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
                           
                     ?>

                        </form>
                        <!-- /. PAGE INNER  -->
                    </div>
                    <!-- /. PAGE WRAPPER  -->
            </div>

            

</body>

</html>

<?php } ?>