<?php

include "../configurasi/koneksi.php";
require('pdf/fpdf.php');
$pdf=new FPDF();
$pdf->AddPage('L');

$id = $_GET['id'];

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
$pdf->Cell(40,6,'NPM',1,0);
$pdf->Cell(90,6,'Nama',1,0);
$pdf->Cell(60,6,'Kelas',1,0);
$pdf->Cell(60,6,'Nilai',1,0);





$siswa_yangmengerjakan2 = mysql_query("SELECT * FROM siswa_sudah_mengerjakan WHERE id_tq = '$_GET[id]'");
$no=1;

while ($t=mysql_fetch_array($siswa_yangmengerjakan2)){
    $siswa = mysql_query("SELECT * FROM siswa WHERE id_siswa = '$t[id_siswa]'");
            $s = mysql_fetch_array($siswa);
            $kelas = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$s[id_kelas]'");
            $k = mysql_fetch_array($kelas);
            $nilai = mysql_query("SELECT * FROM nilai_soal_esay WHERE id_tq='$_GET[id]' AND id_siswa ='$t[id_siswa]'");
            $n = mysql_fetch_array($nilai);

            $nomorinduk = $s['nis'];
            $nama_lengkap = $s['nama_lengkap'];
            $nama_kelas = $k['nama'];
            $nilai ="";
            if ($t['dikoreksi']=='B'){
                $nilai = "0";
            }else{
                $nilai = $n['nilai'];
            }

            $pdf->Cell(10,6,'',0,1);
            $pdf->Cell(10,6,$no,1,0);
            $pdf->Cell(40,6,$nomorinduk,1,0);
            $pdf->Cell(90,6,$nama_lengkap,1,0);
            $pdf->Cell(60,6,$nama_kelas,1,0);
            $pdf->Cell(60,6,$nilai,1,0);       

  $no++;
}


$pdf->Output();






?>