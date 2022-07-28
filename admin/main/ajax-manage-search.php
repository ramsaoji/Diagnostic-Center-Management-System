<?php
session_start();
include('db.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../index.php');
}
else{
 
if(isset($_POST["from_date"], $_POST["to_date"])) {

    $from_date = $_POST["from_date"];
    $to_date = $_POST["to_date"];
    //ALL IN ONE

    $reportData = "";
    $totalct = 0;
    $totalsono = 0;
    $totalxray = 0;
    $totalpatient = 0;
    $totalcommission = 0;
    $totalincome = 0;


    $query = "SELECT p.id as PId,\n"

    . "sub.scan_sub_types AS Scan_Types,\n"

    . "d.doc_name AS Doctor,\n"

    . "c.city_name AS City,\n"

    . "p.discounted_price AS Price\n"

    . "FROM patient p INNER JOIN sub_scan_type sub \n"

    . "ON p.sub_id = sub.sub_id INNER JOIN doctor_master d \n"

    . "ON d.doc_id = p.doc_id INNER JOIN city c\n"

    . "ON c.city_id = d.city_city_id\n"

    . "WHERE date_format(p.record_date, '%Y-%m-%d') between '$from_date' and '$to_date'"

    . "ORDER BY p.id DESC;";
    
    $result = mysqli_query($con, $query);
 
    if(mysqli_num_rows($result) > 0)
    {

            $reportData .='
            <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th><span>Id</span></th>
                        <th><span>Scan Types</span></th>
                        <th><span>Doctor</span></th>
                        <th><span>Price</span></th>
                        <th><span>Manage</span></th>
                    </tr>
                </thead>';

            while($row = mysqli_fetch_array($result))
            {
                // $totalct = $row["CT"] + $totalct;
                
                $reportData .='

                <tr>
                <td>'.$row["PId"].'</td>
                <td>'.$row["Scan_Types"].'</td>
                <td>'.$row["Doctor"].' ('.$row["City"].')</td>
                <td>'.$row["Price"].'</td>
                <td>
                    <form name="form" action="record-manage-actual.php">
                        <button type="submit" name="uid" id="btn_search" value='.$row["PId"].' class="btn btn-primary"><i class="fas fa-edit"></i> Edit</button>
                      
                    </form>
                       
                </td>
                </tr>';

                // $totalct = $row["CT"] + $totalct;

            }

            $reportData .= '</table>
            </div>
            
        
            <script src="../assets/js/jquery.metisMenu.js"></script>
            <!-- DATA TABLE SCRIPTS -->
            <script src="../assets/js/dataTables/jquery.dataTables.js"></script>
            <script src="../assets/js/dataTables/dataTables.bootstrap.js"></script>
            <script>
            $(document).ready(function() {
                $("#dataTables-example").dataTable({
                    "ordering" : false,
                    "lengthMenu": [ [15, 25, 50, -1], [15, 25, 50, "All"] ],
                    "language": {
                        "search": "Search Id " 
                    },
                    "columnDefs": [{
                        "targets": [1,2,3,4],
                        "searchable": false
                    }]
                    });
            });
            </script>';
    }
    else
    {
        $reportData .= '<div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
        <tr>
            <td colspan="12">No Data Found. Please select proper date.</td>
        </tr>
        </table>
        </div>';
    }
    
    echo $reportData;
}
}
?>