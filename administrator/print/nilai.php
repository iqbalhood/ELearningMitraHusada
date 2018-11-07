<?php
include "../../configurasi/koneksi.php";


    $siswa_yangmengerjakan = mysql_query("SELECT id_siswa FROM siswa_sudah_mengerjakan WHERE id_tq = '$_GET[id]'");
    $cek_siswa = mysql_num_rows($siswa_yangmengerjakan);

    if (!empty($cek_siswa)){

    $soal_pilganda = mysql_query("SELECT * FROM quiz_pilganda WHERE id_tq='$_GET[id]'");
    $pilganda = mysql_num_rows($soal_pilganda);
    $soal_esay = mysql_query("SELECT * FROM quiz_esay WHERE id_tq='$_GET[id]'");
    $esay = mysql_num_rows($soal_esay);

    $topik = mysql_query("SELECT * FROM topik_quiz WHERE id_tq='$_GET[id]'");
    $topikujian = mysql_fetch_assoc($topik);

    $dosen = mysql_query("SELECT * FROM pengajar WHERE id_pengajar='$topikujian[pembuat]'");
    $dosenquiz = mysql_fetch_assoc($dosen);

    $makul = mysql_query("SELECT * FROM mata_pelajaran WHERE id_matapelajaran='$topikujian[id_matapelajaran]'");
    $makulquiz = mysql_fetch_assoc($makul);
    
    if (!empty($pilganda) AND !empty($esay)){
    echo "<form><fieldset>
          <legend>siswa yang telah mengikuti ujian</legend>
          <dl class='inline'>";
     echo "<br><div class='information msg'>
     Mata Kuliah: $makulquiz[nama].<br>
     Dosen: $dosenquiz[nama_lengkap].<br>
     Hasil Quiz: $topikujian[judul].<br>
     Tanggal: $topikujian[tgl_buat] s.d $topikujian[tgl_batas].<br>     
    </div>";

    $siswa_yangmengerjakan2 = mysql_query("SELECT * FROM siswa_sudah_mengerjakan WHERE id_tq = '$_GET[id]'");
    echo "<br><table border='1'><thead>
      <tr><th>No</th><th>NPM</th><th>Nama</th><th>Kelas</th><th>Status</th><th>Nilai</th></tr></thead>";
    $no=1;
    while ($t=mysql_fetch_array($siswa_yangmengerjakan2)){
        $siswa = mysql_query("SELECT * FROM siswa WHERE id_siswa = '$t[id_siswa]'");
        $s = mysql_fetch_array($siswa);
        $kelas = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$s[id_kelas]'");
        $k = mysql_fetch_array($kelas);
        $nilai = mysql_query("SELECT * FROM nilai_soal_esay WHERE id_tq='$_GET[id]' AND id_siswa ='$t[id_siswa]'");
        $n = mysql_fetch_array($nilai);
        $nilai2 = mysql_query("SELECT * FROM nilai WHERE id_tq='$_GET[id]' AND id_siswa = '$t[id_siswa]'");
        $n2 = mysql_fetch_array($nilai2);
        echo "<tr><td>$no</td>
                  <td>$s[nis]</td>
                  <td>$s[nama_lengkap]</td>
                  <td>$k[nama]</td>";
                  if ($t['dikoreksi']=='B'){
                      echo "<td>Jawaban soal essay <b>belum di koreksi</b>
                                <br>Nilai Tugas/Quiz Pilihan Ganda : </td>";
                      echo "
                      <td>$n2[persentase]</td></tr>";
                  }else{
                      echo "<td>Jawaban soal essay <b>sudah di koreksi</b><br>Nilai Tugas/Quiz Pilihan Ganda : <br>
                                                     Nilai Tugas/Quiz Essay: $n[nilai]</td>";
                      echo "
                      <td>$n2[persentase]</td></tr>";
                  }
        $no++;
    }
    echo "</table>";
    }
    elseif (empty($pilganda) AND !empty($esay)){
     echo"<form><fieldset>
          <legend>siswa yang telah mengikuti ujian</legend>
          <dl class='inline'>";
     echo "<br><div class='information msg'>
     Mata Kuliah: $makulquiz[nama].<br>
     Dosen: $dosenquiz[nama_lengkap].<br>
     Hasil Quiz: $topikujian[judul].<br>
     Tanggal: $topikujian[tgl_buat] s.d $topikujian[tgl_batas].<br>
    </div>";

    $siswa_yangmengerjakan2 = mysql_query("SELECT * FROM siswa_sudah_mengerjakan WHERE id_tq = '$_GET[id]'");
    echo "<br><table border='1'><thead>
      <tr><th>No</th><th>NPM</th><th>Nama</th><th>Kelas</th><th>Status</th><th>Nilai</th></tr></thead>";
    $no=1;
    while ($t=mysql_fetch_array($siswa_yangmengerjakan2)){
        $siswa = mysql_query("SELECT * FROM siswa WHERE id_siswa = '$t[id_siswa]'");
        $s = mysql_fetch_array($siswa);
        $kelas = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$s[id_kelas]'");
        $k = mysql_fetch_array($kelas);
        $nilai = mysql_query("SELECT * FROM nilai_soal_esay WHERE id_tq='$_GET[id]' AND id_siswa ='$t[id_siswa]'");
        $n = mysql_fetch_array($nilai);
        echo "<tr><td>$no</td>
                  <td>$s[nis]</td>
                  <td>$s[nama_lengkap]</td>
                  <td>$k[nama]</td>";
                  if ($t['dikoreksi']=='B'){
                      echo "<td>Jawaban soal essay <b>belum di koreksi</b></td>";
                      echo "
                      <td></td></tr>";
                  }else{
                      echo "<td>Jawaban soal essay <b>sudah di koreksi</b><br>Nilai Tugas/Quiz Essay: </td>";
                      echo "
                      <td>$n[nilai]</td></tr>";
                  }
        $no++;
    }
    echo "</table>";
    }
    elseif (!empty($pilganda) AND empty($esay)){
     echo "<form><fieldset>
          <legend>siswa yang telah mengikuti ujian</legend>
          <dl class='inline'>";
     echo "<br><div class='information msg'>
     Mata Kuliah: $makulquiz[nama].<br>
     Dosen: $dosenquiz[nama_lengkap].<br>
     Hasil Quiz: $topikujian[judul].<br>
     Tanggal: $topikujian[tgl_buat] s.d $topikujian[tgl_batas].<br>
    </div>";


    $siswa_yangmengerjakan2 = mysql_query("SELECT * FROM siswa_sudah_mengerjakan WHERE id_tq = '$_GET[id]'");
    echo "<br><table border='1'><thead>
      <tr><th>No</th><th>NPM</th><th>Nama</th><th>Kelas</th><th>Status</th><th>Nilai</th></tr></thead>";
    $no=1;
    while ($t=mysql_fetch_array($siswa_yangmengerjakan2)){
        $siswa = mysql_query("SELECT * FROM siswa WHERE id_siswa = '$t[id_siswa]'");
        $s = mysql_fetch_array($siswa);
        $kelas = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$s[id_kelas]'");
        $k = mysql_fetch_array($kelas);
        $nilai = mysql_query("SELECT * FROM nilai_soal_esay WHERE id_tq='$_GET[id]' AND id_siswa ='$t[id_siswa]'");
        $n = mysql_fetch_array($nilai);
        $nilai2 = mysql_query("SELECT * FROM nilai WHERE id_tq='$_GET[id]' AND id_siswa = '$t[id_siswa]'");
        $n2 = mysql_fetch_array($nilai2);
        echo "<tr><td>$no</td>
                  <td>$s[nis]</td>
                  <td>$s[nama_lengkap]</td>
                  <td>$k[nama]</td>";
                  if ($t['dikoreksi']=='B'){
                      echo "<td>Nilai Tugas/Quiz Pilihan Ganda : </td>";
                      echo "<td>$n2[persentase]</td></tr>";
                  }else{
                      echo "<td>Nilai Tugas/Quiz Pilihan Ganda : </td>";
                      echo "<td>$n2[persentase]</td></tr>";
                  }
        $no++;
    }
    echo "</table>";
    }
    elseif (empty($pilganda) AND empty($esay)){
        echo "<script>window.alert('Tidak Ada Soal.');
                window.location=(href='media_admin.php?module=quiz')</script>";
    }
    }else{
        echo "<script>window.alert('Belum ada siswa yang mengikuti ujian.');
                window.location=(href='media_admin.php?module=quiz')</script>";
    }



?>