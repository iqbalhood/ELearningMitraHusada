<?php
require('pdf/fpdf.php');
$pdf=new FPDF();
$pdf->AddPage('L');



  // Logo
  $pdf->Cell(10,7,'',0,1);
  $pdf->Cell(10,7,'',0,1);
  $pdf->SetLineWidth(1);
  $pdf->Image('header.png',20,10,'C',50);
  $pdf->Cell(10,7,'',0,1);
  $pdf->Cell(10,7,'',0,1);
  $pdf->Line(10000,0,0,60);
  $pdf->SetLineWidth(0.5);
  $pdf->Line(10000,0,0,62);
  $pdf->SetLineWidth(0);
  $pdf->Cell(10,7,'',0,1);
  $pdf->Cell(10,7,'',0,1);
  $pdf->Cell(10,7,'',0,1);
  $pdf->Cell(10,7,'',0,1);
  $pdf->Cell(10,7,'',0,1);



// setting jenis font yang akan digunakan
$pdf->SetFont('Arial','B',12);
$pdf->Cell(270,7,'DAFTAR NILAI',0,1,'C');
 
// Memberikan space kebawah agar tidak terlalu rapat
$pdf->Cell(10,7,'',0,1);
 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,6,'No',1,0);
$pdf->Cell(40,6,'Waktu',1,0);
$pdf->Cell(40,6,'Npm',1,0);
$pdf->Cell(40,6,'Nama',1,0);
$pdf->Cell(60,6,'Aktivitas',1,0);


/*
	//  get by event
	$result = mysql_query("SELECT * FROM `log_mahasiswa` WHERE `waktu` BETWEEN '$awal' AND '$akhir' ") or die(mysql_error());
        // cek
        $no = 1;
		if (mysql_num_rows($result) > 0) {
		    // looping hasil
		    // event node
            $response["event"] = array();
      
	     while ($row = mysql_fetch_array($result)) {
            // $pdf->Cell(20,6,$row['nim'],1,0);
            $pdf->Cell(10,6,'',0,1);
            
			$pdf->Cell(10,6,$no,1,0);
            $pdf->Cell(40,6,$row["waktu"],1,0);
            $pdf->Cell(40,6,$row["nim"],1,0);
            $pdf->Cell(40,6,$row["nama"],1,0);
            $pdf->Cell(60,6,$row["aktivitas"],1,0);
           

            $no ++;
		 }
		  
		} 


*/


$pdf->Output();











?>