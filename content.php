<?php
// Bagian Home
if ($_GET['module']=='home'){
  if ($_SESSION['leveluser']=='siswa'){
  echo "<br><b class='judul'>Hai $_SESSION[namalengkap]</b><br><p class='garisbawah'></p>
        Selamat datang di <b>E-Learning STIKes Mitra Husada Medan</b>.<br>
        <p>&nbsp;</p>
        <p>";
        $topik = mysql_query("SELECT * FROM info_pengumuman WHERE terbit='Y' order by id_info desc limit 0,1");
        $cek_topik = mysql_num_rows($topik);
        if (!empty($cek_topik)){
          echo"<br>
            <table>
            <tr><th></th><th>Pengumuman Tugas/Quiz </th><th></th></tr>";
            $no=1;
            while($t=mysql_fetch_array($topik)){
                $tgl_posting   = tgl_indo($t[tgl_buat]);
                $pengajar =  mysql_query("SELECT * FROM pengajar WHERE id_pengajar = '$t[pembuat]'");
                $cek_pengajar = mysql_num_rows($pengajar);
                $waktu = $t[waktu_pengerjaan] / 60;
                echo"<tr><td rowspan=6></td><td><b>Judul</b></td><td><b>: $t[judul]</b></td></tr>
                     <tr><td><b>Tanggal Posting</b></td><td><b>: $tgl_posting</b></td></tr>";
                     if(!empty($cek_pengajar)){

                     $p = mysql_fetch_array($pengajar);
                     echo"<tr><td><b>Dosen</b></td><td><b>: $p[nama_lengkap]</b></td></tr>";
                     }else{
                         echo"<tr><td><b>Pembuat</b></td><td><b>: $t[pembuat]</b></td></tr>";
                     }
                     echo"
                          <tr><td><b>Info Soal/Quiz</b></td><td><b>: $t[info]</b></td></tr>
                          ";
            $no++;
            }
            echo"</table>
                  <p class='garisbawah'>";
      }
        
 echo "       </p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>

  <p class='garisbawah'></p><p align='right'><b class='judul'>Login : $hari_ini, 
  <span id='date'></span>, <span id='clock'></span></p>";
  }
}
// Bagian kelas
elseif ($_GET['module']=='kelas'){
  if ($_SESSION['leveluser']=='siswa'){
      include "administrator/modul/mod_kelas/kelas.php";
  }
}

// Bagian siswa
elseif ($_GET['module']=='siswa'){
  if ($_SESSION['leveluser']=='siswa'){
      include "administrator/modul/mod_siswa/siswa.php";
  }
}

// Bagian admin
elseif ($_GET['module']=='admin'){
  if ($_SESSION['leveluser']=='siswa'){
      include "administrator/modul/mod_admin/admin.php";
  }
}

// Bagian mapel
elseif ($_GET['module']=='matapelajaran'){
  if ($_SESSION['leveluser']=='siswa'){
      include "administrator/modul/mod_matapelajaran/matapelajaran.php";
  }
}

// Bagian materi
elseif ($_GET['module']=='materi'){
  if ($_SESSION['leveluser']=='siswa'){
      include "administrator/modul/mod_materi/materi.php";
  }
}

// Bagian materi
elseif ($_GET['module']=='quiz'){
  if ($_SESSION['leveluser']=='siswa'){
      include "administrator/modul/mod_quiz/quiz.php";
  }
}

// Bagian info
elseif ($_GET['module']=='info'){
  if ($_SESSION['leveluser']=='siswa'){
      include "administrator/modul/mod_info/quiz.php";
  }
}

// Bagian materi
elseif ($_GET['module']=='kerjakan_quiz'){
  if ($_SESSION['leveluser']=='siswa'){
      include "administrator/modul/mod_quiz/soal.php";
  }
}

// Bagian materi
elseif ($_GET['module']=='nilai'){
  if ($_SESSION['leveluser']=='siswa'){
      include "daftarnilai.php";
  }
}
?>
