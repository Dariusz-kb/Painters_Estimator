<?php
session_start();
require_once('authorisation.php');
require("fpdf181/fpdf.php");
include("dbconnect.php");
 //Array to store validation errors
    $errmsg_arr = array();
    //Validation error flag
    $errflag = false;
	
// function to prevent escape characters being injected into a string 
    function escape($str, $connection) {		
        return $connection-> real_escape_string($str);
    }
	//  remove slashes, any HTML from, strip HTML entirely
	// stripp whitespace from the beginning and end 
	function sanitize($str)
	{
	if (get_magic_quotes_gpc())
	$str = stripslashes($str);
	$str = htmlentities($str);
	$str = strip_tags($str);
	$str = @trim($str); 
	return $str;
	}
	// function to clean inputs 
	function clean($str, $connection)
	{	
	$str= escape($str, $connection);
	$str = sanitize($str);
	return $str;
	}
	
    //Sanitize the POST values
	$user_id = $_SESSION['SESS_USER_ID'];
    $project_id = clean($_POST['project_id'],$conn);
 	$vat_rate = clean($_POST['vat_rate'],$conn);
	
	// validate that invoice number is adigit
	if(ctype_digit($_POST['invoice_number'])){
		$invoice_number = clean($_POST['invoice_number'],$conn);
		} 
		else{
			$errmsg_arr[] = "Invoice must be a digit";
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			$errflag = true;
			} 
	// validate that tax number is alphanumeric
	if (ctype_alnum(clean($_POST['tax_number'],$conn))) {
        $tax_number = clean($_POST['tax_number'],$conn);
    } else {
        $errmsg_arr[] = "Tax number must be alphanumeric";
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		$errflag = true;
    }
	
	 //If there are input validations, redirect back to the invoice form
    if($errflag) {
        $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
        session_write_close();
        header("location: index.php?page=invoice_form&data=$project_id");
        exit();
    }
	

// get the painter details
$qry = "SELECT name, surname, phone_number, email, user_addr FROM registered_users WHERE id_num='$user_id' ";
$result = $conn->query($qry);
if(!$result)die($conn->error);	
	$rows = $result->num_rows;
	for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$name = ucfirst($row['name']);
		$surname = ucfirst($row['surname']);
		$phone_number = $row['phone_number'];
		$email = $row['email'];
		$user_addr = $row['user_addr'];
	}
// get the user details
$qry = "SELECT first_name, surname, number, street, city, county FROM costumers_db WHERE project_id='$project_id'";
$result = $conn->query($qry);
if(!$result)die($conn->error);	
	$rows = $result->num_rows;
	for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$first_name = ucfirst($row['first_name']);
		$cstsurname = ucfirst($row['surname']);
		$number = $row['number'];
		$street = ucfirst($row['street']);
		$city = ucfirst($row['city']);
		$county = ucfirst($row['county']);
	}
// get project details	
$qry = "SELECT number, street, city, county, description FROM projects WHERE project_id='$project_id'";
$result = $conn->query($qry);
if(!$result)die($conn->error);	
	$rows = $result->num_rows;
	for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$prnumber = $row['number'];
		$prstreet = ucfirst($row['street']);
		$prcity = ucfirst($row['city']);
		$prcounty = ucfirst($row['county']);
		$pdescription = ucfirst($row['description']);
	}
// price from estimate

$total_price_no_vat = 0;
$qry = "SELECT total_price FROM estimates where estimate_id='$project_id' and user_id='$user_id'";
$result = $conn->query($qry);
if (!$result) die ("Database access failed: ". $conn->error);
	$rows = $result->num_rows;
	for($j=0; $j< $rows; ++$j)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$item_price = $row['total_price'];
		$total_price_no_vat += $item_price;
	

	}
	
	// user data 
$fullname = $name.' '.$surname;
$split_addr = explode(",",$user_addr);
$num_road = $split_addr[0]." ".ucfirst($split_addr[1]);
$town_county = ucfirst($split_addr[2]).", co. ".ucfirst($split_addr[3]);
$date = date("Y/m/d");

	// client data

$Cfullname = $first_name.' '.$cstsurname;
$Cnum_road = $number.' '.$street;
$Ctown_county = $city.', co. '.$county;

// project data

$prnum_road = $prnumber.' '.$prstreet;
$prtown_county = $prcity.', co. '.$prcounty;	
$pdescription;	
	
$total_price_no_vat = round($total_price_no_vat, 2);	





$vat_string="";
$vat_price = 0;
if($vat_rate == "N/A"){
	$vat_price=0;
	$vat_string=" - N/A";
	}
	else{
	$vat_price = round(($total_price_no_vat*$vat_rate), 2);
	$vat_string =" - ".($vat_rate*100)."%";
	}

	$total_price_inc_vat = 0;
	$total_price_inc_vat = round(($vat_price + $total_price_no_vat), 2);


// start of pdf
define('EURO', chr(128));

$pdf = new FPDF( 'P', 'mm', 'A4' );
$pdf->AddPage();
$pdf->SetFont( 'Times', '', 12 );
$pdf->SetTextColor( 0, 0, 0 );
$pdf->SetFillColor( 184, 207, 229);
$pdf->Ln(15);
$pdf->Cell( 190, 5, $fullname, 0, 0, 'L' );
$pdf->Ln(5);
$pdf->Cell( 190, 5, $num_road, 0, 0, 'L' );
$pdf->Ln(5);
$pdf->Cell( 190, 5, $town_county, 0, 0, 'L' );
$pdf->Ln(5);
$pdf->Cell( 190, 5, "Phone: ".$phone_number, 0, 0, 'L' );
$pdf->Ln(5);
$pdf->Cell( 190, 5, "Email: ".$email, 0, 0, 'L' );
$pdf->Ln(5);
$pdf->Cell( 190, 5, "Tax nummber: ".$tax_number, 0, 0, 'L' );
$pdf->Ln(5);
$pdf->Cell( 180, 5, "Invoice number: ".$invoice_number, 0, 0, 'R' );
$pdf->Ln(5);
$pdf->Cell( 180, 5, "Date: ".$date, 0, 0, 'R' );
$pdf->Ln(15);
$pdf->SetFont( 'Times', 'B', 12 );
$pdf->Write( 6, "Invoice for: " );
$pdf->SetFont( 'Times', '', 12 );
$pdf->Ln(10);
$pdf->Cell( 190, 5, $Cfullname, 0, 0, 'L' );
$pdf->Ln(5);
$pdf->Cell( 190, 5, $Cnum_road, 0, 0, 'L' );
$pdf->Ln(5);
$pdf->Cell( 190, 5, $Ctown_county, 0, 0, 'L' );
$pdf->Ln(15);
$pdf->SetXY(35, 130);
$pdf->Cell( 100, 10, "Description", 'LT', 0, 'C', true );
$pdf->Cell( 35, 10, "Amount", 'RT', 0, 'C', true );
$pdf->Ln(10);
$pdf->SetXY(35, 140);
$pdf->Cell( 100, 10,"" .$prnum_road , 'LR', 0, 'C', false );
$pdf->Cell( 35, 10, "", 'R', 0, 'C', false );
$pdf->Ln(10);
$pdf->SetXY(35, 145);
$pdf->Cell( 100, 10,"" .$prtown_county , 'LR', 0, 'C', false );
$pdf->Cell( 35, 10, "" , 'R', 0, 'C', false );
$pdf->Ln(10);
$pdf->SetXY(35, 155);
$pdf->Cell( 100, 10,"".$pdescription, 'LR', 0, 'C', false );
$pdf->Cell( 35, 10, EURO.$total_price_no_vat, 'R', 0, 'C', false );
$pdf->Ln(10);
$pdf->SetXY(35, 160);
$pdf->Cell( 100, 10,"", 'LR', 0, 'C', false );
$pdf->Cell( 35, 10, "", 'R', 0, 'C', false );
$pdf->Ln(10);
$pdf->SetXY(35, 170);
$pdf->SetFillColor( 205, 222, 249);
$pdf->Cell( 100, 10,"VAT ".$vat_string , 'LT', 0, 'C', true );
$pdf->Cell( 35, 10, EURO.$vat_price, 'RT', 0, 'C', true );
$pdf->Ln(10);
$pdf->SetXY(35, 180);
$pdf->Cell( 100, 10,"Summary", 1, 0, 'C', false );
$pdf->Cell( 35, 10, EURO.$total_price_inc_vat, 1, 0, 'C', false );

$pdf->Output("invoice_".$invoice_number.".pdf", "I");

?>
	