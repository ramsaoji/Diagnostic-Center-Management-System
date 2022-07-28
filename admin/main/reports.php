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
<!-- <html xmlns="http://www.w3.org/1999/xhtml"> -->

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reports Search</title>
    <!-- Bootstrap Styles-->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />  

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
        integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
        crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> -->
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
   
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" />

    <!-- Custom Styles-->
    <link href="../assets/css/custom-styles.css" rel="stylesheet" />
    <link href="../assets/css/datepicker.css" rel="stylesheet" />

    <link href="../assets/css/custom-datatables.css" rel="stylesheet" />

 
        
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
                        <a class="active-menu" href="reports.php"><i class="far fa-file-alt"></i> Reports</a>
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
                            Report Details
                        </h1>
                    </div>
                </div>
                
                <form name="form" action='print.php' target="_blank">
                    
                    <div id="structure" class="form-group" class="date">

                        <label class="from-label1">From</label>
                        <input type="text" name="from_date" id="from_date" class="form-control dateFilter" placeholder="From Date" autocomplete="off" value="<?php echo date('Y-m-d'); ?>" required readonly/>


                        <label class="from-label2">To</label>
                        <input type="text" name="to_date" id="to_date" class="form-control dateFilter" placeholder="To Date" autocomplete="off" value="<?php echo date('Y-m-d'); ?>" required readonly/>

                        <label class="from-label3">Type</label>
                        <select type="text" name="scan_id" id="scan_id" class="form-control type" placeholder="Search Scan Type" autocomplete="off">

                        <option value="" selected>Select scan type</option>
                        <option value=1>CT</option>
                        <option value=2>Sonography</option>
                        <option value=3>X-ray</option>
                        </select>

                        <label class="from-label4">City</label>
                        <!-- <input id="search_city_id" name="search_city_id" class="form-control" style="display: none" readonly> -->

                        
                        <div>
                            <input id='search_city' name='search_city' class="form-control" autocomplete="off" placeholder="Search City">
                            <div id="cityList" class="cityList"></div>
                        </div>



                        <button type="button" name="search" id="btn_search" value="Search" class="btn btn-primary" ><i class="fa fa-search"></i> Search</button>
                  
                        <!-- <button type="submit" name="print" id="btn_print" class="btn btn-primary" >Preview</button> -->
                        
                    </div>
                </form>

                             
                <div class="row">
                    <div class="col-md-10 col-sm-12">
                        
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div id="report_data">
                                    
                                    <p id="msg">Please select date range for report. (Scan type & City - Optional) </p>
        
                                </div>
                            </div>
                        </div>
                    </div>

                    

                <!-- </form> -->
                </div>
                <!-- /. PAGE INNER  -->
            </div>
            <!-- /. PAGE WRAPPER  -->
            <!-- /. WRAPPER  -->

            <script>
                $(document).ready(function() {
                $(window).keydown(function(event){
                    if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                    }
                });
                });
            </script>

            <script>  

                var active ;

                $(document).ready(function () { 

                    $("#search_city").keyup(function (e) {
                                      
                    var code = e.which;
                    if (code == 40) { //key down
                        active++;

                        if (active >= $('#cityList ul li').length)
                            active = 0;//$('#drList ul li').length;

                        switchActiveElement();
                        
                    } else if (code == 38) { //key up
                        active--;
                        if (active < 0)
                            active = $('#cityList ul li').length - 1;

                        switchActiveElement();
                    } else if (code == 13) { //enter key
                        selectOption($('.active'));
 
                
                    } else {
                        var query = $("#search_city").val();

                        if (query.length > 0) {
                            $.ajax(
                                {
                                    url: 'ajax-city-search.php',
                                    method: 'POST',
                                    data: {
                                        search: 1,
                                        query: query
                                    },
                                    success: function (data) {
                                        $('#cityList').fadeIn(100);
                                        $('#cityList').html(data);
                                        active = -1;
                                        
                                        if (code = 38)
                                        active = $('#cityList ul li').length;
                                    },
                                    dataType: 'text'
                                }
                            );
                        }
                        else{
                            $('#cityList').fadeOut("fast"); 
                        }  
                    }
                    
                });

                $(document).on('click', '#cityList li', function(){

                        $('#search_city').val($(this).text());
                        $('#search_city_id').val($(this).attr('value'));
                        $('#cityList').fadeOut("fast");
                    });
                    $(document).on('click', function(){ 
                        $('#cityList').fadeOut("fast");  
                    });
                    
            });

            function switchActiveElement() {
                $('.active').removeAttr('class');
                $('#cityList ul li:eq('+active+')').attr('class', 'active');
                
            }

            function selectOption(caller) {
                var country = caller.text();
                $("#search_city").val(country);
                $("#cityList").html("");
                // $('#cityList').fadeOut(); 
                    
            }
            </script> 
               
            <script>
                
                const todayDate = new Date();
                var todayM = todayDate.getMonth();
                var todayD = todayDate.getDate();
                var pastM = todayM - 3;
                var todayY = todayDate.getFullYear();
                var x = 1;

                $(document).ready(function () {
                
                    $(".dateFilter").datepicker({ maxDate: todayDate, minDate: new Date(todayY, pastM), dateFormat: "yy-mm-dd"});
                   
                
                    $('#btn_search').click(function () {
                    var from_date = $('#from_date').val();
                    var to_date = $('#to_date').val();
                    var scan_id = $('#scan_id').val();
                    // var search_city_id = $('#search_city_id').val();
                    var search_city_name = $('#search_city').val();

                    if (from_date != '' && to_date != '') {
                        $.ajax({
                        url: "ajax-date-search.php",
                        method: "POST",
                        data: { from_date: from_date, to_date: to_date, scan_id:scan_id, search_city_name: search_city_name},
                        success: function (data) {
                            $('#report_data').html(data);
                 
                            if (x <= 1){
                                $("#structure").append('<button type="submit" name="print" id="btn_print" class="btn btn-primary"><i class="far fa-file"></i> Preview</button>');
                                x++;
                            }
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