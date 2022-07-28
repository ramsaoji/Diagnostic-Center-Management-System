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
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Records Search</title>
    <!-- Bootstrap Styles-->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="../assets/css/custom-styles.css" rel="stylesheet" />
    <link href="../assets/css/datepicker.css" rel="stylesheet" />
    <!-- TABLE STYLES-->
    <link href="../assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
        integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
        crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        
</head>

<body>
    <div id="wrapper">

        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="newpatient.php">Admin</a>
            </div>

           
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
                        <a class="active-menu" href="record-manage-show.php"><i class="fa fa-database"></i> Manage</a>
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
                            Manage Details
                        </h1>
                    </div>
                </div>
                
                <!-- <form name="form" action='print.php'> -->
                    
                    <div class="form-group" class="date">

                        <label class="from-label1">From</label>
                        <input type="text" name="from_date" id="from_date" class="form-control dateFilter" placeholder="From Date" autocomplete="off" value="<?php echo date('Y-m-d'); ?>" required readonly/>


                        <label class="from-label2">To</label>
                        <input type="text" name="to_date" id="to_date" class="form-control dateFilter" placeholder="To Date" autocomplete="off" value="<?php echo date('Y-m-d'); ?>" required readonly/>

                        <!-- <label class="from-label3">Type</label>
                        <select type="text" name="scan_id" id="scan_id" class="form-control type" placeholder="Search Scan Type" autocomplete="off">

                        <option value="" selected>Select scan type</option>
                        <option value=1>CT</option>
                        <option value=2>Sonography</option>
                        <option value=3>X-ray</option>
                        </select> -->


                        <button type="button" name="search" id="btn_search" value="Search" class="btn btn-primary" ><i class="fa fa-search"></i> Search</button>
                  
                        
                    </div>
                <!-- </form> -->
                

                
                <div class="row">
                    <div class="col-md-10 col-sm-12">
                        
                        <div class="panel panel-default">
                            <div class="panel-body">
                         
                                <div id="report_data">
                                
                                    <p id="msg">Please select date range.</p>

                                </div>
                              
                                
                            </div>
                        </div>
                    </div>
                </div>


                <!-- /. PAGE INNER  -->
            </div>
            <!-- /. PAGE WRAPPER  -->
            <!-- /. WRAPPER  -->

            <script>

                const todayDate = new Date();
                var todayM = todayDate.getMonth();
                var todayD = todayDate.getDate();
                var pastD = todayD - 3;
                var todayY = todayDate.getFullYear();

                $(document).ready(function () {
                
                    $(".dateFilter").datepicker({ maxDate: todayDate, minDate: new Date(todayY, todayM, pastD), dateFormat: "yy-mm-dd"});
                
                    $('#btn_search').click(function () {
                    var from_date = $('#from_date').val();
                    var to_date = $('#to_date').val();
                    var scan_id = $('#scan_id').val();

                    if (from_date != '' && to_date != '') {
                        $.ajax({
                        url: "ajax-manage-search.php",
                        method: "POST",
                        data: { from_date: from_date, to_date: to_date, scan_id:scan_id},
                        success: function (data) {
                            $('#report_data').html(data);
                        }
                        });
                    }
                    else {
                        
                        alert("Please Select the Date");
                    }
                    });
                });

            </script>


</body>

</html>
<?php } ?>