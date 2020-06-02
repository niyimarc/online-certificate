<?php 
session_start();
        
if(!isset($_SESSION['user_certificate'])) 
    header('location:view.php');   
$cert_id=$_SESSION['certificate_id'];

require("pdflib.php");

function certificate_print_text($pdf, $x, $y, $align, $font='freeserif', $style, $size = 10, $text, $width = 0) {
    $pdf->setFont($font, $style, $size);
    $pdf->SetXY($x, $y);
    $pdf->writeHTMLCell($width, 0, '', '', $text, 0, 0, 0, true, $align);
}

$pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle("Hack With Drey Certificate");
$pdf->SetProtection(array('modify'));
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(false, 0);
$pdf->AddPage();

    $cerx = 137;
    $cery = 23;
    
    $rcx = 137;
    $rcy = 17;
    
    $logox = 88;
    $logoy = 18;
    $logo = realpath("./images/logo1.png");
    
    $x = 10;
    $y = 58;

    $sealx = 150;
    $sealy = 220;
    $seal = realpath("./images/seal.png");

    $sigx = 30;
    $sigy = 230;
    $sig = realpath("./images/signature.png");

    $custx = 30;
    $custy = 230;

    $wmarkx = 26;
    $wmarky = 58;
    $wmarkw = 158;
    $wmarkh = 170;
    $wmark = realpath("./images/seal.png");

    $brdrx = 0;
    $brdry = 0;
    $brdrw = 210;
    $brdrh = 297;
    $codey = 250;


$fontsans = 'courier';
$fontserif = 'times';

// border
$pdf->SetLineStyle(array('width' => 1.5, 'color' => array(34,139,34)));
$pdf->Rect(10, 10, 190, 277);
// create middle line border
$pdf->SetLineStyle(array('width' => 0.2, 'color' => array(34,139,34)));
$pdf->Rect(13, 13, 184, 271);
// create inner line border
$pdf->SetLineStyle(array('width' => 1.0, 'color' => array(50,205,50)));
$pdf->Rect(16, 16, 178, 265);


// Set alpha to semi-transparency
if (file_exists($wmark)) {
    $pdf->SetAlpha(0.2);
    $pdf->Image($wmark, $wmarkx, $wmarky, $wmarkw, $wmarkh);
}

$pdf->SetAlpha(1);
if (file_exists($seal)) {
    $pdf->Image($seal, $sealx, $sealy, '', '');
}
if (file_exists($sig)) {
    $pdf->Image($sig, $sigx, $sigy, '', '');
}
if (file_exists($logo)) {
    $pdf->Image($logo, $logox, $logoy, '', '');
}
//connect database 

include 'db/dbcon.php';
//select all values from application table
$sql="SELECT UPPER(full_name), email, address, UPPER(reference) FROM application WHERE email='$cert_id'";
                $result= mysqli_query($conn, $sql) or die(mysqli_error());
                $rws= mysqli_fetch_array($result);
                
                $addr= $rws[2];
                $name= $rws[0];
                $email= $rws[1];
                $reference= $rws[3];

date_default_timezone_set('Australia/Melbourne');
$date = date('m/d/Y', time());
// Add text
certificate_print_text($pdf, $cerx, $cery + 2, 'C', $fontsans, '', 20,  "$date");
certificate_print_text($pdf, $rcx, $rcy, 'C', $fontserif, '', 20, "RC: $reference");
$pdf->SetTextColor(50,205,50);
certificate_print_text($pdf, $x, $y -6, 'C', $fontsans, '', 30, "HACK WITH DREY");
$pdf->SetTextColor(0, 0, 0);
certificate_print_text($pdf, $x, $y + 23, 'C', $fontserif, '', 20, "This certificate of HWD is a demo certificate and it's");
certificate_print_text($pdf, $x, $y + 30, 'C', $fontserif, '', 20, "is proudly presented to");
$pdf->SetTextColor(50,205,50);
certificate_print_text($pdf, $x, $y + 58, 'C', $fontsans, '', 30, "$name");
$pdf->SetTextColor(0, 0, 0);


certificate_print_text($pdf, $x, $y + 90, 'C', $fontserif, '', 20, "This certificate is issued free of charge and");
certificate_print_text($pdf, $x, $y + 97, 'C', $fontserif, '', 20, "the certificate in question has legal status with drey.org.ng ");


header ("Content-Type: application/pdf");
echo $pdf->Output('', 'S');