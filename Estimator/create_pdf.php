<?php
session_start();
require_once('authorisation.php');
require("fpdf181/fpdf.php");
include("dbconnect.php");

    if(isset($_GET["data"]))
    {
       $project_id = $_GET["data"];
        
    }

$user_id = $_SESSION['SESS_USER_ID'];

$qry = "SELECT name, surname, phone_number, email, user_addr FROM registered_users WHERE id_num='$user_id' ";
$result = $conn->query($qry);
if(!$result)die($conn->error);	
	$rows = $result->num_rows;
	for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$name = $row['name'];
		$surname = $row['surname'];
		$phone_number = $row['phone_number'];
		$email = $row['email'];
		$user_addr = $row['user_addr'];
	}

$qry = "SELECT first_name, surname, number, street, city, county FROM costumers_db WHERE project_id='$project_id'";
$result = $conn->query($qry);
if(!$result)die($conn->error);	
	$rows = $result->num_rows;
	for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$first_name = $row['first_name'];
		$cstsurname = $row['surname'];
		$number = $row['number'];
		$street = $row['street'];
		$city = $row['city'];
		$county = $row['county'];
	}
	
$qry = "SELECT number, street, city, county, description FROM projects WHERE project_id='$project_id'";
$result = $conn->query($qry);
if(!$result)die($conn->error);	
	$rows = $result->num_rows;
	for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$prnumber = $row['number'];
		$prstreet = $row['street'];
		$prcity = $row['city'];
		$prcounty = $row['county'];
		$pdescription = $row['description'];
	}
	
	
$estimate_items=array();
$end_price = 0;
$qry = "SELECT * FROM estimates where estimate_id='$project_id'";
$result = $conn->query($qry);
if (!$result) die ("Database access failed: ". $conn->error);
	$rows = $result->num_rows;
	for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$estimate_items[$j] = $row; 
	

	}

	$total_time = 0;
	$total_painting_price = 0;
	$total_price=0;
	$all_prep = "";
	$all_material="";
	$total_material_price = 0;
	$total_prep_price = 0;
	$final_price = 0;
	$total_project_time = 0;
	
	foreach( $estimate_items as $item ) {
		//$count_item = count($item);
	
	
	
		$item_material = $item['materials'];
		$all_material .= $item_material;
		$item_material_price = $item['materials_price'];
		$total_material_price = $total_material_price + $item_material_price;
		
		$item_prep = $item['prep'];
		$all_prep .= $item_prep;
		
		$total_prep_price = $total_prep_price + $item['prep_price'];
		
		$total_item_time = $item['total_time'];
		$total_time = $total_time + $total_item_time;
		
		$total_project_time = 
		$total_painting_price = $total_painting_price + $item['painting_price'];	
		
		$total_price = $item['total_price'];
		$end_price = $end_price + $total_price;
		$final_price = $final_price + $total_price;
		}
	//echo $addr_item.'<br>';
//}
	
	
		/*
		$item_name = $row['item_name'];
		$total_area = $row['total_area'];
		$no_coats = $row['no_coats'];	
		$total_time = $row['total_time'];
		$total_price = $row['total_price'];
		$end_price = $end_price + $total_price;
		*/
	
	

	// project data
	
	
	
	// user data
$pname = $name;
$pname = ucfirst($pname);
$psurname =$surname;
$psurname = ucfirst($psurname);  
$fullname = $pname.' '.$psurname;
$split_addr = explode(",",$user_addr);
$num_road = $split_addr[0]." ".ucfirst($split_addr[1]);
$town_county = ucfirst($split_addr[2]).", co. ".ucfirst($split_addr[3]);
$date = date("Y/m/d");

	// client data

$Cname = $first_name;
$Cname = ucfirst($Cname);
$Csurname = $cstsurname;
$Csurname = ucfirst($Csurname);  
$Cfullname = $Cname.' '.$Csurname;
$Cnum_road = $number.' '.ucfirst($street);
$Ctown_county = ucfirst($city).', co. '.ucfirst($county);

// project data

$prnum_road = $prnumber.' '.ucfirst($prstreet);
$prtown_county = ucfirst($prcity).', co. '.ucfirst($prcounty);


$end_price = round($end_price, 2);
$total_painting_price = round($total_painting_price, 2);


$split_allprep = explode(",",$all_prep);
$uqe_prep = array_unique($split_allprep);

// get the preparation works description and put them into an array
$prep_descr = array();
$i =0;
foreach( $uqe_prep as $item ) {
	$qry = "SELECT prep_description FROM preparation_works where prep_name = '$item' and user_id ='$user_id' ";
			$result = $conn->query($qry);
			if (!$result) die ("Database access failed: " . $conn->error);
			$rows = $result->num_rows;
				for($j=0; $j< $rows; ++$j)
				{
				$result->data_seek($j);
				$row = $result->fetch_array(MYSQLI_ASSOC);
				$prep_descr[$i] = $row;
				}
		++$i;
	}
	
$count_prep_descr = count($prep_descr);
	
$count_prep = count($uqe_prep);

$total_prep_price = round($total_prep_price, 2);


$split_all_material = explode(",",$all_material);
$uqe_materials = array_unique($split_all_material);
$count_materials = count($uqe_materials);


//array 
$trim_town_county = trim($town_county);


$all_paints = array();
$total_paint_price = 0;
$qry = "SELECT paint_brand, finish_type, paint_base, paint_amount, paint_price FROM estimates where estimate_id='$project_id' and include_paint='yes'";
$result = $conn->query($qry);
if (!$result) die ("Database access failed: ". $conn->error);
	$rows = $result->num_rows;
	for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$all_paints[$j] = $row;
		}
$count_all_paints = count($all_paints);

$all_primers = array();
$total_primer_price = 0;
$qry = "SELECT primer_name, primer_price FROM estimates where estimate_id='$project_id' and include_primer='yes'";
$result = $conn->query($qry);
if (!$result) die ("Database access failed: ". $conn->error);
	$rows = $result->num_rows;
	for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$all_primers[$j] = $row;
		
	}
$count_all_primers = count($all_primers);

// start of pdf
define('EURO', chr(128));

$pdf = new FPDF( 'P', 'mm', 'A4' );
$pdf->AddPage();
$pdf->SetFont( 'Times', '', 12 );
$pdf->SetTextColor( 0, 0, 0 );
$pdf->SetFillColor( 184, 207, 229);
$pdf->Cell( 190, 5, $fullname, 0, 0, 'L' );
$pdf->Ln(5);
$pdf->Cell( 190, 5, $num_road, 0, 0, 'L' );
$pdf->Ln(5);
$pdf->Cell( 190, 5, $trim_town_county, 0, 0, 'L' );
$pdf->Ln(5);
$pdf->Cell( 190, 5, "Phone: ".$phone_number, 0, 0, 'L' );
$pdf->Ln(15);
$pdf->Cell( 180, 5, "Date: ".$date, 0, 0, 'R' );
$pdf->Ln(15);
$pdf->SetFont( 'Times', 'B', 12 );
$pdf->Write( 6, "Quotation for: " );
$pdf->SetFont( 'Times', '', 12 );
$pdf->Ln(10);
$pdf->Cell( 190, 5, $Cfullname, 0, 0, 'L' );
$pdf->Ln(5);
$pdf->Cell( 190, 5, $Cnum_road, 0, 0, 'L' );
$pdf->Ln(5);
$pdf->Cell( 190, 5, $Ctown_county, 0, 0, 'L' );
$pdf->Ln(15);
$pdf->SetFont( 'Times', 'B', 12 );
$pdf->Cell( 190, 5, "Re: Quotation for work at: ", 0, 0, 'C' );
$pdf->Ln(5);
$pdf->Cell( 190, 5, "".$prnum_road.", ".$prtown_county, 0, 0, 'C' );
$pdf->Ln(10);
$pdf->SetFont( 'Times', '', 12 );
$pdf->Write( 6, "Dear ".$Cname."," );
$pdf->Ln( 5 );
$pdf->Write( 6, "Thank you for oportunity to quote. I am pleased to quote as follows: " );
$pdf->Ln( 5 );
//$pdf->SetLineWidth(0.5);
//$pdf->Line(10,105,200,105);
$pdf->Ln( 5 );
$pdf->SetFont( 'Times', 'B', 12 );
$pdf->Write( 6, "Details of items to be painted: " );
$pdf->SetFont( 'Times', '', 12 );
$pdf->Ln( 10 );
$pdf->Cell( 75, 10, "Item name", 0, 0, 'C', true);
$pdf->Cell( 35, 10, "m2/units/m", 0, 0, 'C', true );
$pdf->Cell( 35, 10, "Coats", 0, 0, 'C', true );
$pdf->Cell( 35, 10, "Price", 0, 0, 'C', true );
$pdf->Ln(10);
foreach( $estimate_items as $item ) {
		
		$pdf->Cell( 75, 10, ucfirst($item['item_name']), 1, 0, 'C' );
		$pdf->Cell( 35, 10, $item['total_area'], 1, 0, 'C' );
		$pdf->Cell( 35, 10, $item['no_coats'], 1, 0, 'C' );
		$pdf->Cell( 35, 10, $item['painting_price'], 1, 0, 'C' );
		$pdf->Ln(10);
		}
 $pdf->SetFillColor( 143, 173, 204);
$pdf->SetFont( 'Times', 'B', 12 ); 
$pdf->Cell( 145, 10, "Total painting price ", 0, 0, 'R', true );
$pdf->Cell( 35, 10, EURO.$total_painting_price, 0, 0, 'C', true );
$pdf->Ln(15);

if($count_prep_descr > 0) {	

$pdf->Write( 6, "Preparation works will include: " );
$pdf->SetFont( 'Times', '', 12 );
$pdf->SetFillColor( 239, 242, 247);
$pdf->Ln( 10 );

foreach( $prep_descr as $prep ){
	if($prep['prep_description'] != ""){
$pdf->Write( 6, " - ".ucfirst($prep['prep_description']) );		
$pdf->Ln( 5 );
	}

}
$pdf->Ln( 10 );
$pdf->SetFont( 'Times', 'B', 12 );
 $pdf->SetFillColor( 143, 173, 204);
$pdf->Cell( 145, 10, "Total preparation price ", 0, 0, 'R', true );
$pdf->Cell( 35, 10, EURO.$total_prep_price, 0, 0, 'C', true );
$pdf->Ln(15);
}
else{
	$pdf->Write( 6, "Price does not include any preparation works." );
	$pdf->Ln( 10 );
}



if($count_materials > 1) {

$pdf->Write( 6, "Price will include following materials: " );
$pdf->SetFont( 'Times', '', 12 );
$pdf->Ln( 10 );
foreach( $uqe_materials as $material ){
	if($material != ""){
$pdf->Write( 6, " - ".ucfirst($material) );
$pdf->Ln( 5 );
	}

}
$pdf->Ln( 10 );
$pdf->SetFont( 'Times', 'B', 12 );
$pdf->Cell( 145, 10, "Total materials price ", 0, 0, 'R', true );
$pdf->Cell( 35, 10, EURO.$total_material_price, 0, 0, 'C', true );
$pdf->Ln(15);
}
else{
	$pdf->Write( 6, "Price does not include any materials." );
	$pdf->Ln( 10 );
}


if($count_all_paints > 0) {

$pdf->Write( 6, "Price will include following paints: " );
$pdf->SetFont( 'Times', '', 12 );
$pdf->SetFillColor( 184, 207, 229);
$pdf->Ln( 10 );
$pdf->Cell( 36, 10, "Paint brand", 0, 0, 'C', true );
$pdf->Cell( 36, 10, "Finish", 0, 0, 'C', true );
$pdf->Cell( 36, 10, "Base", 0, 0, 'C', true );
$pdf->Cell( 36, 10, "Amount", 0, 0, 'C', true );
$pdf->Cell( 36, 10, "Price", 0, 0, 'C', true );

$pdf->Ln(10);

foreach( $all_paints as $item ) {
	if($item['paint_brand'] != ""){
	$pdf->Cell( 36, 10, ucfirst($item['paint_brand']) , 1, 0, 'C' );
	$pdf->Cell( 36, 10, ucfirst($item['finish_type']), 1, 0, 'C' );
	$pdf->Cell( 36, 10, ucfirst($item['paint_base']), 1, 0, 'C' );
	$pdf->Cell( 36, 10, $item['paint_amount']." l", 1, 0, 'C' );
	$pdf->Cell( 36, 10, EURO.$item['paint_price'], 1, 0, 'C' );
	$total_paint_price = $item['paint_price'] + $total_paint_price;
	$pdf->Ln(10);
	}
}
$pdf->SetFont( 'Times', 'B', 12 );
 $pdf->SetFillColor( 143, 173, 204);
$pdf->Cell( 144, 10, "Total paint price ", 0, 0, 'R', true );
$pdf->Cell( 36, 10, EURO.$total_paint_price, 0, 0, 'C', true );
$pdf->Ln(15);

}
else {
	$pdf->Write( 6, "Price does not include any paints." );
	$pdf->Ln( 10 );
}

if($count_all_primers > 0) {
	
$pdf->SetFillColor( 184, 207, 229);
$pdf->Write( 6, "Price will include following primers: " );
$pdf->SetFont( 'Times', '', 12 );
$pdf->Ln( 10 );
$pdf->Cell( 144, 10, "Primer name", 0, 0, 'C', true );
$pdf->Cell( 36, 10, "Primer price", 0, 0, 'C', true );


$pdf->Ln(10);

foreach( $all_primers as $item ) {
	if($item['primer_name'] != ""){
	$pdf->Cell( 144, 10, ucfirst($item['primer_name']) , 1, 0, 'C' );	
	$pdf->Cell( 36, 10, EURO.$item['primer_price'], 1, 0, 'C' );
	$total_primer_price = $item['primer_price'] + $total_primer_price;
	$pdf->Ln(10);
	}
}
$pdf->SetFont( 'Times', 'B', 12 );
$pdf->SetFillColor( 143, 173, 204);
$pdf->Cell( 144, 10, "Total primers price ", 0, 0, 'R', true );
$pdf->Cell( 36, 10, EURO.$total_primer_price, 0, 0, 'C', true );
$pdf->Ln(15);
}
else {
	$pdf->Write( 6, "Price does not include any primers." );
	$pdf->Ln( 10 );
}

$pdf->Ln( 5 );
$pdf->SetFillColor( 123, 154, 201);
$pdf->Cell( 144, 10, "Total price ", 0, 0, 'R',true );
$pdf->Cell( 36, 10, EURO.$final_price, 0, 0, 'C',true );
$pdf->Ln(15);
$pdf->SetFont( 'Times', '', 12 );
$pdf->Cell( 180, 5, "It will take aproximately ".$total_time." working hours, to fully compleate the job."  , 0, 0, 'L' );
$pdf->Ln(5);
$pdf->Cell( 180, 5, "Please contact me should you have any questions at all."  , 0, 0, 'L' );
$pdf->Ln( 10 );
$pdf->Write( 6, "Regards" );
$pdf->Ln( 5 );
$pdf->Cell( 50, 10, $fullname , 0, 0, 'L' );

$pdf->Output("estimate_".$project_id.".pdf", "I");

?>