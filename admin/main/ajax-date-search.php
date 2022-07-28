<?php
session_start();
include('db.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../index.php');
}
else{
date_default_timezone_set('Asia/Kolkata');
 
if(isset($_POST["from_date"], $_POST["to_date"])) {

    $from_date = $_POST["from_date"];
    $to_date = $_POST["to_date"];
    $scan_id = $_POST["scan_id"];
    // $city_id = $_POST["search_city_id"];
    $city_name = $_POST["search_city_name"];
    $dtToday = date('Y-m-d h:i:sa');
    // $dtTime = date("h:i:sa");

    // echo '<script type="text/javascript">alert("'.$from_date.'");</script>';

    if($scan_id == 1){
        $scan_type = 'CT';
    }
    elseif($scan_id == 2){
        $scan_type = "Sonography";
    }
    elseif($scan_id == 3){
        $scan_type = "X-Ray";
    }

    $output = "";

    if($city_name != ""){

        // $file = 'http://localhost/hospital/admin/json/city_data.json';
        // $file_content = file_get_contents($file);
        $array_encode = $_SESSION['city_json'];
        $array_decode = json_decode($array_encode, true);
        $length = count($array_decode);

        for($i = 0; $i < $length; $i++){

            if($city_name == $array_decode[$i]["city_name"]){

                $output = $array_decode[$i]["city_name"];

            }

        }
        if($city_name != $output){

            echo '<script type="text/javascript">
                    swal({
                        title: "Invalid City.",
                        text: "Please select from search results only!!"
                        });
                    </script>';
            
        }
        
    }
 
    //ALL IN ONE

    $reportData = "";
    $totalct = 0;
    $totalsono = 0;
    $totalxray = 0;
    $totalpatient = 0;
    $totalcommission = 0;
    $totalincome = 0;


    if($scan_id != '' && $city_name != ''){
        $query = "call final_report_both_including('$from_date','$to_date','$scan_id','$city_name');";
    }
    else if($scan_id != '' && $city_name == ''){
        $query = "call final_report_sort('$from_date','$to_date','$scan_id');";
    }else if($scan_id == '' && $city_name != ''){
        $query = "call final_report_city('$from_date','$to_date','$city_name');";
    }else{
        $query = "call final_report('$from_date','$to_date');";
    }
    
    $result = mysqli_query($con, $query);
 
    if(mysqli_num_rows($result) > 0)
    {
        if($scan_id == '' && $city_name == ''){

            $reportData .='
            <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
 
                <thead>
                <tr>
                    <td>#</td>
                    <td>Reffered By</td>
                    <td>Dr.City</td>
                    <td>CT Scan</td>
                    <td>Sonography</td>
                    <td>X-Ray</td>
                    <td>Total Patients</td>
                    <td>Income</td>
                    <td>Commision</td>
                </tr>
                </thead>';

            while($row = mysqli_fetch_array($result))
            {
            
                $reportData .='
                
                <tr>
                <td>'.$row["Id"].'</td>
                <td><a href="invoice.php?from_date='.$from_date.'&to_date='.$to_date.'&dr_id='.$row["Doc_id"].'&dr_name='.$row["Doctor"].'" target="_blank">'.$row["Doctor"].'</a></td>
                <td>'.$row["City"].'</td>
                <td>'.$row["CT"].'</td>
                <td>'.$row["Sonography"].'</td>
                <td>'.$row["X-Ray"].'</td>
                <td>'.$row["Total_Patients"].'</td>
                
                <td>'.preg_replace('/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i', "$1,", $row["Income"]).'</td>
                <td>'.preg_replace('/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i', "$1,", $row["Commission"]).'</td>
                </tr>';

                $totalct = $row["CT"] + $totalct;
                $totalsono = $row["Sonography"] + $totalsono;
                $totalxray = $row["X-Ray"] + $totalxray;
                $totalpatient = $row["Total_Patients"] + $totalpatient;
                $totalcommission = $row["Commission"] + $totalcommission;
                $totalincome = $row["Income"] + $totalincome;
                
            }
            $totalincome = preg_replace('/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i', "$1,", $totalincome);
            $totalcommission = preg_replace('/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i', "$1,", $totalcommission);
            
            $reportData .='
            <tfoot>
            <tr>
                <td style="font-weight: bold;">'."#".'</td>
                <td style="font-weight: bold;">'."All Total".'</td>
                <td style="font-weight: bold;">'."-".'</td>
                <td style="font-weight: bold;">'.$totalct.'</td>
                <td style="font-weight: bold;">'.$totalsono.'</td>
                <td style="font-weight: bold;">'.$totalxray.'</td>
                <td style="font-weight: bold;">'.$totalpatient.'</td>        
                <td style="font-weight: bold;">'.$totalincome.'</td>
                <td style="font-weight: bold;">'.$totalcommission.'</td>
            </tr>
            </tfoot>';

            // <!-- DATA TABLE SCRIPTS -->
            
            $reportData .='

            <script>
            
            $(document).ready(function() {

                $("#dataTables-example").DataTable({
                    "searching": true,
                    "ordering" : false,
                    pageLength: 15,
                    lengthMenu: [ [15, 25, 50, -1], [15, 25, 50, "All"] ],
                    dom: "Blfrtip",
                    "language": {
                        "search": "Search Dr : " 
                    },
                    "columnDefs": [
                        { "targets": [0,2,3,4,5,6,7,8], "searchable": false }
                    ],
                    buttons: [

                        {
                            extend: "pdfHtml5",
                            title: "Saoji Imaging Center - Report",
                            messageTop: "(From '.$from_date.' to '.$to_date.')",
                            messageBottom:"\n(Generated On - '.$dtToday.')",
                            footer: true,
                            orientation: "protrait",
                            pageSize: "A4",
                            filename: "All Report - '.$dtToday.'",
                            customize: function(doc) {
                                doc.styles.message = {
                                  alignment: "center"
                                },
                                doc.styles.tableHeader = {
                                    fillColor: "#223B52",
                                    alignment: "left",
                                    bold:!0,
                                    fontSize:11,
                                    color: "#fff"
                                },
                                doc.styles.tableBodyOdd = {
                                    fillColor: "#E6E6E6"
                                }
                                doc.pageMargins = [30,20,20,0]; 
                                doc.defaultStyle.fontSize = 11;
                                                        
                            }

                        },
                        {
                            extend: "excelHtml5",
                            title: "Saoji Imaging Center - Report",
                            messageTop: "(From '.$from_date.' to '.$to_date.')",
                            messageBottom:"(Generated On - '.$dtToday.')",
                            footer: true,
                            filename: "All Report - '.$dtToday.'",
                            exportOptions: {
                                columns: ":not(:last-child)"
                            }
                        }
                        ]
                    });
                });
                </script>';

        }else if($scan_id != '' && $city_name == ''){

            $reportData .='
            <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr>
                    <th><span>#</span></th>
                    <th><span>Reffered By - (for '.$scan_type.')</span></th>
                    <th><span>Dr.City</span></th>
                    <th><span>Total Patients</span></th>
                    <th><span>Income</span></th>
                    <th><span>Commision</span></th>
                </tr>
            </thead>';

            while($row = mysqli_fetch_array($result))
            {
                $reportData .='
                
                <tr>
                <td>'.$row["Id"].'</td>
                <td><a href="invoice.php?from_date='.$from_date.'&to_date='.$to_date.'&dr_id='.$row["Doc_id"].'&dr_name='.$row["Doctor"].'" target="_blank">'.$row["Doctor"].'</a></td>
                <td>'.$row["City"].'</td>
                <td>'.$row["Total_Patients"].'</td>
                <td>'.preg_replace('/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i', "$1,", $row["Income"]).'</td>
                <td>'.preg_replace('/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i', "$1,", $row["Commission"]).'</td>
                </tr>';

                $totalpatient = $row["Total_Patients"] + $totalpatient;
                $totalcommission = $row["Commission"] + $totalcommission;
                $totalincome = $row["Income"] + $totalincome;
                
            }
            $totalincome = preg_replace('/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i', "$1,", $totalincome);
            $totalcommission = preg_replace('/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i', "$1,", $totalcommission);

            $reportData .='
            <tfoot>
            <tr>
                <td style="font-weight: bold;">'."#".'</td>
                <td style="font-weight: bold;">'."All Total".'</td>
                <td style="font-weight: bold;">'."-".'</td>
                <td style="font-weight: bold;">'.$totalpatient.'</td>
                <td style="font-weight: bold;">'.$totalincome.'</td>
                <td style="font-weight: bold;">'.$totalcommission.'</td>
            </tr>
            </tfoot>';

            // <!-- DATA TABLE SCRIPTS -->
            
            $reportData .='

            <script>
            
            $(document).ready(function() {

                $("#dataTables-example").DataTable({
                    "searching" : true,
                    "ordering" : false,
                    pageLength: 15,
                    lengthMenu: [ [15, 25, 50, -1], [15, 25, 50, "All"] ],
                    dom: "Blfrtip",
                    "language": {
                        "search": "Search Dr : " 
                    },
                    "columnDefs": [
                        { "targets": [0,2,3,4,5], "searchable": false }
                    ],
                    buttons: [

                        {
                            extend: "pdfHtml5",
                            title: "Saoji Imaging Center - Report",
                            messageTop: "Only '.$scan_type.' (From '.$from_date.' to '.$to_date.')",
                            messageBottom:"\n(Generated On - '.$dtToday.')",
                            footer: true,
                            orientation: "protrait",
                            pageSize: "A4",
                            filename: "'.$scan_type.' Report - '.$dtToday.'",
                            customize: function(doc) {
                                doc.styles.message = {
                                  alignment: "center"
                                },
                                doc.styles.tableHeader = {
                                    fillColor: "#223B52",
                                    alignment: "left",
                                    bold:!0,
                                    fontSize:11,
                                    color: "#fff"
                                },
                                doc.styles.tableBodyOdd = {
                                    fillColor: "#E6E6E6"
                                }
                                doc.pageMargins = [120,20,100,20]; 
                                doc.defaultStyle.fontSize = 11;
                                                             
                            }
                               
                        },
                        {
                            extend: "excelHtml5",
                            title: "Saoji Imaging Center - Report",
                            messageTop: "Only '.$scan_type.' (From '.$from_date.' to '.$to_date.')",
                            messageBottom:"(Generated On - '.$dtToday.')",
                            footer: true,
                            filename: "'.$scan_type.' Report - '.$dtToday.'"
                        }
                        ]
                    });
                });
                </script>';

          
        }
        else if($scan_id == '' && $city_name != ''){


            $reportData .='
            <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr>
                    <th><span>#</span></th>
                    <th><span>Reffered By</span></th>
                    <th><span>Dr.City</span></th>
                    <th><span>Total Patients</span></th>
                    <th><span>Income</span></th>
                    <th><span>Commision</span></th>
                </tr>
            </thead>';

            while($row = mysqli_fetch_array($result))
            {
                $reportData .='
                
                <tr>
                <td>'.$row["Id"].'</td>
                <td><a href="invoice.php?from_date='.$from_date.'&to_date='.$to_date.'&dr_id='.$row["Doc_id"].'&dr_name='.$row["Doctor"].'" target="_blank">'.$row["Doctor"].'</a></td>
                <td>'.$row["City"].'</td>
                <td>'.$row["Total_Patients"].'</td>
                <td>'.preg_replace('/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i', "$1,", $row["Income"]).'</td>
                <td>'.preg_replace('/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i', "$1,", $row["Commission"]).'</td>
                </tr>';

                $totalpatient = $row["Total_Patients"] + $totalpatient;
                $totalcommission = $row["Commission"] + $totalcommission;
                $totalincome = $row["Income"] + $totalincome;
                
            }
            $totalincome = preg_replace('/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i', "$1,", $totalincome);
            $totalcommission = preg_replace('/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i', "$1,", $totalcommission);

            $reportData .='
            <tfoot>
            <tr>
                <td style="font-weight: bold;">'."#".'</td>
                <td style="font-weight: bold;">'."All Total".'</td>
                <td style="font-weight: bold;">'."-".'</td>
                <td style="font-weight: bold;">'.$totalpatient.'</td>
                <td style="font-weight: bold;">'.$totalincome.'</td>
                <td style="font-weight: bold;">'.$totalcommission.'</td>
            </tr>
            </tfoot>';



            // <!-- DATA TABLE SCRIPTS -->
            
            $reportData .='

            <script>
            
            $(document).ready(function() {

                $("#dataTables-example").DataTable({
                    "searching" : true,
                    "ordering" : false,
                    pageLength: 15,
                    lengthMenu: [ [15, 25, 50, -1], [15, 25, 50, "All"] ],
                    dom: "Blfrtip",
                    "language": {
                        "search": "Search Dr : " 
                    },
                    "columnDefs": [
                        { "targets": [0,2,3,4,5], "searchable": false }
                    ],
                    buttons: [

                        {
                            extend: "pdfHtml5",
                            title: "Saoji Imaging Center - Report",
                            messageTop: "Only '.$city_name.' (From '.$from_date.' to '.$to_date.')",
                            messageBottom:"\n(Generated On - '.$dtToday.')",
                            footer: true,
                            orientation: "protrait",
                            pageSize: "A4",
                            filename: "'.$city_name.' Report - '.$dtToday.'",
                            customize: function(doc) {
                                doc.styles.message = {
                                  alignment: "center"
                                },
                                doc.styles.tableHeader = {
                                    fillColor: "#223B52",
                                    alignment: "left",
                                    bold:!0,
                                    fontSize:11,
                                    color: "#fff"
                                },
                                doc.styles.tableBodyOdd = {
                                    fillColor: "#E6E6E6"
                                }
                                doc.pageMargins = [130,20,100,0]; 
                                doc.defaultStyle.fontSize = 11;
                                                             
                            }
                               
                        },
                        {
                            extend: "excelHtml5",
                            title: "Saoji Imaging Center - Report",
                            messageTop: "Only '.$city_name.' (From '.$from_date.' to '.$to_date.')",
                            messageBottom:"(Generated On - '.$dtToday.')",
                            footer: true,
                            filename: "'.$city_name.' Report - '.$dtToday.'"
                        }
                        ]
                    });
                });
                </script>';
                

        }else{

            $reportData .='
            <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr>
                    <th><span>#</span></th>
                    <th><span>Reffered By - (for '.$scan_type.')</span></th>
                    <th><span>Dr.City</span></th>
                    <th><span>Total Patients</span></th>
                    <th><span>Income</span></th>
                    <th><span>Commision</span></th>
                </tr>
            </thead>';

            while($row = mysqli_fetch_array($result))
            {
                $reportData .='
                
                <tr>
                <td>'.$row["Id"].'</td>
                <td><a href="invoice.php?from_date='.$from_date.'&to_date='.$to_date.'&dr_id='.$row["Doc_id"].'&dr_name='.$row["Doctor"].'" target="_blank">'.$row["Doctor"].'</a></td>
                <td>'.$row["City"].'</td>
                <td>'.$row["Total_Patients"].'</td>
                <td>'.preg_replace('/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i', "$1,", $row["Income"]).'</td>
                <td>'.preg_replace('/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i', "$1,", $row["Commission"]).'</td>
                </tr>';

                $totalpatient = $row["Total_Patients"] + $totalpatient;
                $totalcommission = $row["Commission"] + $totalcommission;
                $totalincome = $row["Income"] + $totalincome;
                
            }
            $totalincome = preg_replace('/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i', "$1,", $totalincome);
            $totalcommission = preg_replace('/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i', "$1,", $totalcommission);

            $reportData .='
            <tfoot>
                <tr>
                <td style="font-weight: bold;">'."#".'</td>
                <td style="font-weight: bold;">'."All Total".'</td>
                <td style="font-weight: bold;">'."-".'</td>
                <td style="font-weight: bold;">'.$totalpatient.'</td>
                <td style="font-weight: bold;">'.$totalincome.'</td>
                <td style="font-weight: bold;">'.$totalcommission.'</td>
                </tr>
            </tfoot>';


            // <!-- DATA TABLE SCRIPTS -->
            
            $reportData .='

            <script>
            
            $(document).ready(function() {

                $("#dataTables-example").DataTable({
                    "searching" : true,
                    "ordering" : false,
                    pageLength: 15,
                    lengthMenu: [ [15, 25, 50, -1], [15, 25, 50, "All"] ],
                    dom: "Blfrtip",
                    "language": {
                        "search": "Search Dr : " 
                    },
                    "columnDefs": [
                        { "targets": [0,2,3,4,5], "searchable": false }
                    ],
                    buttons: [

                        {
                            extend: "pdfHtml5",
                            title: "Saoji Imaging Center - Report",
                            messageTop: "Only '.$city_name.' '.$scan_type.' (From '.$from_date.' to '.$to_date.')",
                            messageBottom:"\n(Generated On - '.$dtToday.')",
                            footer: true,
                            orientation: "protrait",
                            pageSize: "A4",
                            filename: "'.$city_name.' '.$scan_type.' Report - '.$dtToday.'",
                            customize: function(doc) {
                                doc.styles.message = {
                                  alignment: "center"
                                },
                                doc.styles.tableHeader = {
                                    fillColor: "#223B52",
                                    alignment: "left",
                                    bold:!0,
                                    fontSize:11,
                                    color: "#fff"
                                },
                                doc.styles.tableBodyOdd = {
                                    fillColor: "#E6E6E6"
                                }
                                doc.pageMargins = [120,20,100,20]; 
                                doc.defaultStyle.fontSize = 11;
                                                             
                            }
                               
                        },
                        {
                            extend: "excelHtml5",
                            title: "Saoji Imaging Center - Report",
                            messageTop: "Only '.$city_name.' '.$scan_type.' (From '.$from_date.' to '.$to_date.')",
                            messageBottom:"(Generated On - '.$dtToday.')",
                            footer: true,
                            filename: "'.$city_name.' '.$scan_type.' Report - '.$dtToday.'"
                        }
                        ]
                    });
                });
                </script>';

        }

        $reportData .='

        </table>
        </div>';   
    }   
    else
    {
        $reportData .= '<div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
        <tr>
            <td colspan="12">No Data Found.</td>
        </tr>
        </table>
        </div>';
        
    }
    echo $reportData;


}
}
?>