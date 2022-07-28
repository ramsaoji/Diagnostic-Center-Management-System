<?php
session_start();
include('db.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:../index.php');
}
else{
?>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo $_GET['dr_name'] ?></title>
        
<style>
		/* reset */

*
{
	border: 0;
	box-sizing: content-box;
	color: inherit;
	font-family: inherit;
	font-size: inherit;
	font-style: inherit;
	font-weight: inherit;
	/* line-height: inherit; */
	list-style: none;
	margin: 0;
	padding: 0;
	text-decoration: none;
	vertical-align: top;
}

/* content editable */

*[contenteditable] {  min-width: 1em; outline: 0; }

*[contenteditable] { cursor: pointer; }

*[contenteditable]:hover, *[contenteditable]:focus, td:hover *[contenteditable], td:focus *[contenteditable], img.hover { background: #DEF; box-shadow: 0 0 1em 0.5em #DEF; }

span[contenteditable] { display: inline-block; }

/* heading */

h1 { font: bold 100% sans-serif; letter-spacing: 0.5em; text-align: center; text-transform: uppercase; }

/* table */
table { font-size: 75%; table-layout: fixed; width: 100%; }
table { border-collapse: collapse; border-spacing: 2px; }
th, td { border-width: 1px; padding: 0.5em; position: relative; text-align: left; }
th, td { border-style: solid; }
th { border-color: #BBB; }
td { border-color: #BBB; }

/* page */

html { font: 16px/1 'Open Sans', sans-serif; overflow: auto; padding: 0.5in; }
html { background: #999; cursor: default; }

body { box-sizing: border-box; height: auto; margin: 0 auto; overflow: hidden; padding: 0.5in; width: 8.5in; }
body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }

/* header */

header { margin: 0 0 3em; }
header:after { clear: both; content: ""; display: table; }

header h1 { background: #CD96FA; border-radius: 0.25em; color: #FFF; margin: 0 0 1em; padding: 0.5em 0; box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;}
header address { float: left; font-size: 75%; font-style: normal; line-height: 1.25; margin: 0 1em 1em 0; }
header address p { margin: 0 0 0.25em; }
header span, header img { display: block; float: right; }
header span { margin: 0 0 1em 1em; max-height: 25%; max-width: 60%; position: relative; }
header img { max-height: 100%; max-width: 100%; }
header input { cursor: pointer; -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; height: 100%; left: 0; opacity: 0; position: absolute; top: 0; width: 100%; }

/* article */

article, article address, table.meta, table.inventory { margin: 0 0 3em; }
article:after { clear: both; content: ""; display: table; }
article h1 { clip: rect(0 0 0 0); position: absolute; }

article address { float: left; font-size: 125%; font-weight: bold; }

/* table meta & balance */

table.meta, table.balance { float: right; width: 36%; box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;}
table.meta:after, table.balance:after { clear: both; content: ""; display: table; }

/* table meta */

table.meta th { width: 40%; }
table.meta td { width: 60%; }

/* table items */

table.inventory { clear: both; width: 100%; box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;}
table.inventory th { font-weight: bold; text-align: left;}

table.inventory th.title {
    font: bold 100% sans-serif;
    letter-spacing: 0.3em;
    font-size: 14px;
    background : #CD96FA;
    text-align: center !important; 
    color: whitesmoke;

}

/* table.inventory td:nth-child(1) { width: 26%; }
table.inventory td:nth-child(2) { text-align: right; width: 12%; }
table.inventory td:nth-child(3) { text-align: right; width: 12%; }
table.inventory td:nth-child(4) { text-align: right; width: 12%; }
table.inventory td:nth-child(5) { text-align: right; width: 12%; } */

/* table balance */

table.balance th, table.balance td { width: 50%; }
table.balance td { text-align: left; font-weight: bold; }

/* aside */

aside h1 { border: none; border-width: 0 0 1px; margin: 0 0 1em; }
aside h1 { border-color: #999; border-bottom-style: solid; }

/* javascript */

.add, .cut
{
	border-width: 1px;
	display: block;
	font-size: .8rem;
	padding: 0.25em 0.5em;	
	float: left;
	text-align: center;
	width: 0.6em;
}

.add, .cut
{
	background: #9AF;
	box-shadow: 0 1px 2px rgba(0,0,0,0.2);
	background-image: -moz-linear-gradient(#00ADEE 5%, #0078A5 100%);
	background-image: -webkit-linear-gradient(#00ADEE 5%, #0078A5 100%);
	/* border-radius: 0.5em; */
	border-color: #0076A3;
	color: #FFF;
	cursor: pointer;
	font-weight: bold;
	text-shadow: 0 -1px 2px rgba(0,0,0,0.333);
}

.add { margin: -2.5em 0 0; }

.add:hover { background: #00ADEE; }

.cut { opacity: 0; position: absolute; top: 0; left: -1.5em; }
.cut { -webkit-transition: opacity 100ms ease-in; }

tr:hover .cut { opacity: 1; }

tfoot th{
    background: none;
    text-align: left !important; 
}
thead, tfoot{
    background: #EDD7FF;
}
address, div p.generated{
    text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.24);
}

@media print {
	* { -webkit-print-color-adjust: exact; }
	html { background: none; padding: 0; }
	body { box-shadow: none; margin: 0; }
	span:empty { display: none; }
	.add, .cut { display: none; }
}

@page {
        
        margin-bottom: 95px;
    }
</style>
		
</head>
<body>
	
	
	<?php
	ob_start();	
	include ('db.php');
    date_default_timezone_set('Asia/Kolkata');

    $from_date = $_GET['from_date'];
    $to_date = $_GET['to_date'];
	$dr_id = $_GET['dr_id'];
    $dtToday = date('Y-m-d h:i:sa');
    $report_CT = '';
    $report_Sono = '';
    $report_Xray = '';
    $total_patient_CT = 0;
    $total_comm_CT = 0;
    $total_patient_Sono = 0;
    $total_comm_Sono = 0;
    $total_patient_Xray = 0;
    $total_comm_Xray = 0;

    $total_patient_overall = 0;
    $total_commission_overall = 0;

	// $cnt = 0;
	$sql = "call invoice('$from_date','$to_date','$dr_id');";
	$re = mysqli_query($con,$sql);

    if(mysqli_num_rows($re) > 0)
    {
        while($row=mysqli_fetch_array($re))
        {
            $doc_id = $row['Doc_id'];
            $doc_name = $row['Doc_name'];
            $price = $row['Price'];
            $city = $row['City'];
            $main_type = $row['Main_type'];
            $child_type = $row['Child_type'];
            $commission = $row['Commission'];
            $total_patient = $row['Total_patient'];

            if($main_type == '1) CT'){

            $report_CT .=
            '<tr>
                <td><span >'.substr($child_type,3).'</span></td>
                <td><span >'.$price.'</span></td>
                <td><span >'.$commission.'</span></td>
                <td><span >'.$total_patient.'</span></td>  
            </tr>';

            $total_patient_CT = $total_patient + $total_patient_CT;
            $total_comm_CT = $commission + $total_comm_CT;

            }elseif($main_type == '2) Sonography'){
               
                $report_Sono .=
                '<tr>
                    <td><span >'.substr($child_type,3).'</span></td>
                    <td><span >'.$price.'</span></td>
                    <td><span >'.$commission.'</span></td>
                    <td><span >'.$total_patient.'</span></td>   
                </tr>';

                $total_patient_Sono = $total_patient + $total_patient_Sono;
                $total_comm_Sono= $commission + $total_comm_Sono;

            }else{

                $report_Xray .=
                '<tr>
                    <td><span >'.substr($child_type,3).'</span></td>
                    <td><span >'.$price.'</span></td>
                    <td><span >'.$commission.'</span></td>
                    <td><span >'.$total_patient.'</span></td>   
                </tr>';

                $total_patient_Xray = $total_patient + $total_patient_Xray;
                $total_comm_Xray = $commission + $total_comm_Xray;

            }

            $total_patient_overall = $row["Total_patient"] + $total_patient_overall;
            $total_commission_overall = $row["Commission"] + $total_commission_overall;

            

        }
    }

	?>

		<header>
			<h1>Details</h1>
			<address >
				<p>Saoji Imaging Center,</p>
				<p>D.P Road,<br>Near Bustand, Chikhli.</p>
				<p>(+91)9876543210</p>
			</address>
			<!-- <span><img alt="" src="assets/img/sun.png"></span> -->
		</header>
		<article>
			<!-- <h1>Recipient</h1> -->
			<address >
				<p><?php echo $doc_name ?> <br></p>
                <p style = "font-size: 14px; margin-top: 5px; font-weight: 600" >City - <?php echo $city ?> <br></p>
			</address>
			<table class="meta">
				<tr>
					<th><span >From Date</span></th>
					<td><span ><?php echo $from_date; ?> </span></td>
				</tr>
				<tr>
					<th><span >To Date</span></th>
					<td><span ><?php echo $to_date; ?> </span></td>
				</tr>

			</table>

            <?php 

            if($report_CT != ''){

               echo '<table class="inventory">
				<thead>
                    <tr>
                        <th colspan="4" class="title"><span>CT-SCAN</span></th>
                    </tr>
					<tr>
						<th><span >Sub Type</span></th>
						<th><span >Price</span></th>
						<th><span >Commission</span></th>
                        <th><span >Total Patient</span></th>
					</tr>
				</thead>
				<tbody>
                    
                    '.$report_CT.'

				</tbody>
                <tfoot>
                    <tr>
                        <th><span >All Total</span></th>
                        <th ><span >-</span></th>
                        <th><span >'.$total_comm_CT.'</span></th>
                        <th><span >'.$total_patient_CT.'</span></th>
                    </tr>
                </tfoot>
			</table>';

            }

            ?>

            <?php 

            if($report_Sono != ''){

            echo '<table class="inventory">
                <thead>
                    <tr>
                        <th colspan="4" class="title"><span >SONOGRAPHY</span></th>
                    </tr>
                    <tr>
                        <th><span >Sub Type</span></th>
                        <th><span >Price</span></th>
                        <th><span >Commission</span></th>
                        <th><span >Total Patient</span></th>
                    </tr>
                </thead>
                <tbody>
                    
                    '.$report_Sono.'

                </tbody>
                <tfoot>
                    <tr>
                        <th><span >All Total</span></th>
                        <th><span >-</span></th>
                        <th><span >'.$total_comm_Sono.'</span></th>
                        <th><span >'.$total_patient_Sono.'</span></th>
                    </tr>
                </tfoot>
            </table>';

            }

            ?>

            <?php 

            if($report_Xray != ''){

            echo '<table class="inventory">
                <thead>
                    <tr>
                        <th colspan="4" class="title"><span>X-RAY</span></th>
                    </tr>
                    <tr>
                        <th><span >Sub Type</span></th>
                        <th><span >Price</span></th>
                        <th><span >Commission</span></th>
                        <th><span >Total Patient</span></th>
                    </tr>
                </thead>
                <tbody>
                    
                    '.$report_Xray.'

                </tbody>
                <tfoot>
                    <tr>
                        <th ><span >All Total</span></th>
                        <th ><span >-</span></th>
                        <th><span >'.$total_comm_Xray.'</span></th>
                        <th><span >'.$total_patient_Xray.'</span></th>
                    </tr>
                </tfoot>
                
            </table>';

            }

            ?>
			
			<table class="balance">
				<tr>
					<th><span >Overall Patient's</span></th>
					<td><span><?php echo $total_patient_overall ?></span></td>
				</tr>
				<tr>
					<th><span >Overall Commission</span></th>
					<td><span><?php echo $total_commission_overall ?></span></td>
				</tr>
				
			</table>
		</article>
		<aside>
			<!-- <h1><span >Contact us</span></h1> -->
			<div >
				<p class="generated" style = "text-align:center; font-size: 14px" >(Generated On - <?php echo $dtToday ?>)</p>
			</div>
		</aside>
	</body>
</html>

<?php 

ob_end_flush();
}
?>