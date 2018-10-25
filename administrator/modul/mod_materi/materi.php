<script>
function confirmdelete(delUrl) {
if (confirm("Anda yakin ingin menghapus?")) {
document.location = delUrl;
}
}
</script>

<script language="JavaScript" type="text/JavaScript">

 function showpel()
 {
 <?php

 // membaca semua kelas
 $query = "SELECT * FROM kelas";
 $hasil = mysql_query($query);

 // membuat if untuk masing-masing pilihan kelas beserta isi option untuk combobox kedua
 while ($data = mysql_fetch_array($hasil))
 {
   $idkelas = $data['id_kelas'];

   // membuat IF untuk masing-masing kelas
   echo "if (document.form_topik.id_kelas.value == \"".$idkelas."\")";
   echo "{";

   // membuat option mata pelajaran untuk masing-masing kelas
   $query2 = "SELECT * FROM mata_pelajaran WHERE id_kelas = '$idkelas'";
   $hasil2 = mysql_query($query2);
   $content = "document.getElementById('pelajaran').innerHTML = \"<select name='".id_matapelajaran."'>";
   $content .= "<option value=''>Pilih matakuliah/ALL</option>";
   while ($data2 = mysql_fetch_array($hasil2))
   {
       $content .= "<option value='".$data2['id_matapelajaran']."'>".$data2['nama']."</option>";
   }
   $content .= "</select>\";";
   echo $content;
   echo "}else if (document.form_topik.id_kelas.value == '' ){document.getElementById('pelajaran').style.visibility = 'hidden';}else{document.getElementById('pelajaran').style.visibility = 'visible';}\n";
 }

 ?>
 }

 function showpel_pengajar()
 {
 <?php

 // membaca semua kelas
 $query1 = "SELECT * FROM kelas";
 $hasil1 = mysql_query($query1);

 // membuat if untuk masing-masing pilihan kelas beserta isi option untuk combobox kedua
 while ($data1 = mysql_fetch_array($hasil1))
 {
   $idkelas = $data1['id_kelas'];

   // membuat IF untuk masing-masing kelas
   echo "if (document.form_materi_pengajar.id_kelas.value == \"".$idkelas."\")";
   echo "{";

   // membuat option matapelajaran untuk masing-masing kelas
   $query2 = "SELECT * FROM mata_pelajaran WHERE  id_kelas = '$idkelas' AND id_pengajar ='$_SESSION[idpengajar]' ";
   $hasil2 = mysql_query($query2);
   $content = "document.getElementById('pelajaran_pengajar').innerHTML = \"<select name='".id_matapelajaran."' required>";
   $content .= "<option value=''>--Pilih matakuliah--</option>";
   while ($data2 = mysql_fetch_array($hasil2))
   {
       $content .= "<option value='".$data2['id_matapelajaran']."'>".$data2['nama']."</option>";
   }
   $content .= "</select>\";";
   echo $content;
   echo "}\n";
 }

 ?>
 }
</script>
<?php
function fsize($file){
                            $a = array("B", "KB", "MB", "GB", "TB", "PB");
                            $pos = 0;
                            $size = filesize($file);
                            while ($size >= 1024)
                            {
                            $size /= 1024;
                            $pos++;
                            }
                            return round ($size,2)." ".$a[$pos];
                            }
?>

<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href=../css/style.css rel=stylesheet type=text/css>";
  echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
}
else{



$aksi="modul/mod_materi/aksi_materi.php";
switch($_GET[act]){
  // Tampil kelas
  default:
    if ($_SESSION[leveluser]=='admin'){
                
        $tampil_materi = mysql_query("SELECT * FROM file_materi ORDER BY id_kelas");
        $cek_materi = mysql_num_rows($tampil_materi);
        if(!empty($cek_materi)){
        echo "<h2>Manajemen Materi</h2><hr>
          <input class='button blue' type=button value='Tambah Materi' onclick=\"window.location.href='?module=materi&act=tambahmateri';\">";
          echo "<br><br><form method=GET action=''>
          <fieldset>
          <legend>Search</legend>
          <dl class='inline'>
          <input type=text name='module' value='materi' hidden>
          <input type=text name='act' value='searchmateri' hidden>
          <dt><input type=text name='searchtext' placeholder='judul /nama file' size='35'>
          </dt> 
          <dd> &nbsp; <select name='id_kelas'>
          <option value='' selected>pilih kelas/ALL</option>";
          $tampil=mysql_query("SELECT * FROM kelas ORDER BY nama");
          while($r=mysql_fetch_array($tampil)){
          echo "<option value=$r[id_kelas]>$r[nama]</option>";
          }echo "</select>
           <select name='id_pengajar'>
                                                  <option value=''>Pilih dosen/ALL</option>";
                                                  $tampil_pengajar=mysql_query("SELECT * FROM pengajar ORDER BY nama_lengkap");
                                                  while($p=mysql_fetch_array($tampil_pengajar)){
                                                  echo "<option value=$p[id_pengajar]>$p[nama_lengkap]</option>";
                                                  }echo "</select>
                                                  
                                                  <input class='button blue' type=submit value=Search>
                                                  </dd>
           
          
                        
          </dl>
          
          </fieldset></form>";
        echo "<br><br><table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Judul</th><th>Kelas</th><th>Mata Kuliah</th><th>Nama File</th><th>Tgl Posting</th><th>Dosen</th><th>Hits</th><th>Aksi</th></tr></thead>";
       $no=1;
    while ($r=mysql_fetch_array($tampil_materi)){
      $tgl_posting   = tgl_indo($r[tgl_posting]);
       echo "<tr><td>$no</td>
             <td>$r[judul]</td>";
             $kelas = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$r[id_kelas]'");
             $cek_kelas = mysql_num_rows($kelas);
             if(!empty($cek_kelas)){
             while($k=mysql_fetch_array($kelas)){
                 echo "<td><a href=?module=kelas&act=detailkelas&id=$r[id_kelas] title='Detail Kelas'>$k[nama]</td>";
             }
             }else{
                 echo"<td></td>";
             }
             $pelajaran = mysql_query("SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$r[id_matapelajaran]'");
             
             $cek_pelajaran = mysql_num_rows($pelajaran);
             if(!empty($cek_pelajaran)){
             while($p=mysql_fetch_array($pelajaran)){
                echo "<td><a href=?module=matapelajaran&act=detailpelajaran&id=$r[id_matapelajaran] title='Detail pelajaran'>$p[nama]</a></td>";
             }
             }else{
                 echo"<td></td>";
             }

             echo "<td>$r[nama_file]</td>
             <td>$tgl_posting</td>";
             $pelajaran2 = mysql_query("SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$r[id_matapelajaran]'");
             $p2 = mysql_fetch_array($pelajaran2);
             $pengajar2 = mysql_query("SELECT * FROM pengajar WHERE id_pengajar = '$p2[id_pengajar]'");
             $cek_pengajar2 = mysql_num_rows($pengajar2);
             if(!empty($cek_pengajar2)){
                 while ($p3= mysql_fetch_array($pengajar2)){
                 echo "<td><a href=?module=admin&act=detailpengajar&id=$p3[id_pengajar] title='Detail Pengajar'>$p3[nama_lengkap]</a></td>";
             }
             }else{
                 echo "<td>$r[pembuat]</td>";
             }
             echo"<td>$r[hits]</td>
             <td><a href='?module=materi&act=editmateri&id=$r[id_file]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> |
                 <a href=javascript:confirmdelete('$aksi?module=materi&act=hapus&id=$r[id_file]') title='Hapus'><img src='images/icons/cross.png' alt='Delete' /></a></td></tr>";
      $no++;
    }
    echo "</table>";
 
    }else{
        echo "<script>window.alert('Tidak ada materi');
            window.location=(href='?module=home')</script>";
    }
    }
   
 elseif ($_SESSION[leveluser]=='pengajar'){        

    $cek_materi = mysql_query("SELECT * FROM file_materi WHERE pembuat = '$_SESSION[idpengajar]' order by id_file desc");
    
     echo "<h2>Daftar Materi Yang Anda Upload</h2><hr>
          <input class='button blue' type=button value='Tambah Materi' onclick=\"window.location.href='?module=materi&act=tambahmateri';\">";
    echo "<br><br><form method=GET action='' name='form_topik'>
          <fieldset>
          <legend>Search</legend>
          <dl class='inline'>
          <input type=text name='module' value='materi' hidden>
          <input type=text name='act' value='searchmateri' hidden>
          <dt><input type=text name='searchtext' placeholder='judul/nama file' size='35'>
          </dt>           
         <dt><select name='id_kelas' onChange='showpel()' style='width: 205px;'>
         <option value=''>Pilih kelas/ALL</option>";
         $pilih="SELECT * FROM kelas ORDER BY nama";
         $query=mysql_query($pilih);
         while($row=mysql_fetch_array($query)){
         echo"<option value='".$row[id_kelas]."'>".$row[nama]."</option>";
         }
         echo"</select>&nbsp;</dt><dd><div id='pelajaran'></div></dd>
         <dt> <input class='button blue' type=submit value=Search></dt>              
          </dl>          
          </fieldset></form>";
     echo "<br><br><table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Judul</th><th>Kelas</th><th>Mata Kuliah</th><th>Nama File</th><th>Tgl Upload</th><th>Hits</th><th>Aksi</th></tr></thead>";

    $no=1;
    while ($r=mysql_fetch_array($cek_materi)){
      $tgl_posting   = tgl_indo($r[tgl_posting]);
       echo "<tr><td>$no</td>
             <td>$r[judul]</td>";
             $kelas = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$r[id_kelas]'");
             $cek_kelas = mysql_num_rows($kelas);
             if(!empty($cek_kelas)){
             while($k=mysql_fetch_array($kelas)){
                 echo "<td><a href=?module=kelas&act=detailkelas&id=$r[id_kelas] title='Detail Kelas'>$k[nama]</td>";
             }
             }else{
                 echo"<td></td>";
             }
             $pelajaran = mysql_query("SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$r[id_matapelajaran]'");
             $cek_pelajaran = mysql_num_rows($pelajaran);
             if(!empty($cek_pelajaran)){
             while($p=mysql_fetch_array($pelajaran)){
                echo "<td><a href=?module=matapelajaran&act=detailpelajaran&id=$r[id_matapelajaran] title='Detail pelajaran'>$p[nama]</a></td>";
             }
             }else{
                 echo"<td></td>";
             }

             echo "<td>$r[nama_file]</td>
             <td>$tgl_posting</td>             
             <td>$r[hits]</td>
             <td><a href='?module=materi&act=editmateri&id=$r[id_file]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a>  |
            <a href=javascript:confirmdelete('$aksi?module=materi&act=hapus&id=$r[id_file]') title='Hapus'><img src='images/icons/cross.png' alt='Delete' /></a></td></tr>";
                 

     $no++;
    }
    echo"</table>";   
    
    }
    
    else{
        echo"<br><b class='judul'>Materi</b><br><p class='garisbawah'></p>";

        $ambil_siswa = mysql_query("SELECT * FROM siswa WHERE id_siswa = '$_SESSION[idsiswa]'");
        $data_siswa = mysql_fetch_array($ambil_siswa);

        $mapel = mysql_query("SELECT * FROM mata_pelajaran WHERE id_kelas = '$data_siswa[id_kelas]'");
       echo "<table>
          <tr><th>No</th><th>Mata Pelajaran</th><th>Materi</th></tr>";
        $no=1;
        while ($r=mysql_fetch_array($mapel)){
        echo "<tr><td>$no</td>
             <td>$r[nama]</td>";
             echo "<td><input type=button class='tombol' value='Lihat File Materi'
                       onclick=\"window.location.href='?module=materi&act=daftarmateri&id=$r[id_matapelajaran]';\"></td></tr>";
        $no++;
        }
        echo "</table>";


    }
    break;

    case searchmateri:
    if ($_SESSION[leveluser]=='admin'){
        $searchtext =  $_GET['searchtext'];
        $kelas =  $_GET['id_kelas'];
        $pengajar =  $_GET['id_pengajar'];
        if($searchtext <> " " && $kelas <> " " && $pengajar <> " "){
            $query = "SELECT * FROM `file_materi` WHERE (`judul` LIKE '%$searchtext%' OR `nama_file` LIKE '%$searchtext%') AND `id_kelas` LIKE '%$kelas%' AND `pembuat` LIKE '%$pengajar%'";
            
        }
        else if($searchtext <> " " && $kelas == 0 && $pengajar <> " "){
            $query = "SELECT * FROM `file_materi` WHERE (`judul` LIKE '%$searchtext%' OR `nama_file` LIKE '%$searchtext%') AND `pembuat` LIKE '%$pengajar%'";
            
        }
        else if($searchtext <> " " && $kelas <> " " && $pengajar == " "){
            $query = "SELECT * FROM `file_materi` WHERE (`judul` LIKE '%$searchtext%' OR `nama_file` LIKE '%$searchtext%') AND `id_kelas` LIKE '%$kelas%'";
            
        }
        else if($searchtext == " " && $kelas <> " " && $pengajar <> " "){
            $query = "SELECT * FROM `file_materi` WHERE `id_kelas` LIKE '%$kelas%' AND `pembuat` LIKE '%$pengajar%'";
            
        }
        else if($searchtext == " " && $kelas == 0 && $pengajar <> " "){
            $query = "SELECT * FROM `file_materi` WHERE `pembuat` LIKE '%$pengajar%'";
            
        }
        else if($searchtext == " " && $kelas <> " " && $pengajar == " "){
            $query = "SELECT * FROM `file_materi` WHERE `id_kelas` LIKE '%$kelas%'";
            
        }
        else if($searchtext <> " " && $kelas == 0 && $pengajar == " "){
            $query = "SELECT * FROM `file_materi` WHERE `judul` LIKE '%$searchtext%' OR `nama_file` LIKE '%$searchtext%'";
            
        }else{
            $query = "SELECT * FROM `file_materi`";
        }        
        $tampil_materi = mysql_query($query);
        $cek_materi = mysql_num_rows($tampil_materi);
       
        echo "<h2>Manajemen Materi</h2><hr>
          <input class='button blue' type=button value='Tambah Materi' onclick=\"window.location.href='?module=materi&act=tambahmateri';\">";
          echo "<br><br><form method=GET action=''>
          <fieldset>
          <legend>Search</legend>
          <dl class='inline'>
          <input type=text name='module' value='materi' hidden>
          <input type=text name='act' value='searchmateri' hidden>
          <dt><input type=text name='searchtext' placeholder='judul /nama file' size='35'>
          </dt> 
          <dd> &nbsp; <select name='id_kelas'>
          <option value='' selected>pilih kelas/ALL</option>";
          $tampil=mysql_query("SELECT * FROM kelas ORDER BY nama");
          while($r=mysql_fetch_array($tampil)){
          echo "<option value=$r[id_kelas]>$r[nama]</option>";
          }echo "</select>
           <select name='id_pengajar'>
                                                  <option value=''>Pilih dosen/ALL</option>";
                                                  $tampil_pengajar=mysql_query("SELECT * FROM pengajar ORDER BY nama_lengkap");
                                                  while($p=mysql_fetch_array($tampil_pengajar)){
                                                  echo "<option value=$p[id_pengajar]>$p[nama_lengkap]</option>";
                                                  }echo "</select>
                                                  
                                                  <input class='button blue' type=submit value=Search>
                                                  </dd>
           
          
                        
          </dl>
          
          </fieldset></form>";
        echo "<br><br><table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Judul</th><th>Kelas</th><th>Mata Kuliah</th><th>Nama File</th><th>Tgl Posting</th><th>Dosen</th><th>Hits</th><th>Aksi</th></tr></thead>";
       $no=1;
    while ($r=mysql_fetch_array($tampil_materi)){
      $tgl_posting   = tgl_indo($r[tgl_posting]);
       echo "<tr><td>$no</td>
             <td>$r[judul]</td>";
             $kelas = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$r[id_kelas]'");
             $cek_kelas = mysql_num_rows($kelas);
             if(!empty($cek_kelas)){
             while($k=mysql_fetch_array($kelas)){
                 echo "<td><a href=?module=kelas&act=detailkelas&id=$r[id_kelas] title='Detail Kelas'>$k[nama]</td>";
             }
             }else{
                 echo"<td></td>";
             }
             $pelajaran = mysql_query("SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$r[id_matapelajaran]'");
             
             $cek_pelajaran = mysql_num_rows($pelajaran);
             if(!empty($cek_pelajaran)){
             while($p=mysql_fetch_array($pelajaran)){
                echo "<td><a href=?module=matapelajaran&act=detailpelajaran&id=$r[id_matapelajaran] title='Detail pelajaran'>$p[nama]</a></td>";
             }
             }else{
                 echo"<td></td>";
             }

             echo "<td>$r[nama_file]</td>
             <td>$tgl_posting</td>";
             $pelajaran2 = mysql_query("SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$r[id_matapelajaran]'");
             $p2 = mysql_fetch_array($pelajaran2);
             $pengajar2 = mysql_query("SELECT * FROM pengajar WHERE id_pengajar = '$p2[id_pengajar]'");
             $cek_pengajar2 = mysql_num_rows($pengajar2);
             if(!empty($cek_pengajar2)){
                 while ($p3= mysql_fetch_array($pengajar2)){
                 echo "<td><a href=?module=admin&act=detailpengajar&id=$p3[id_pengajar] title='Detail Pengajar'>$p3[nama_lengkap]</a></td>";
             }
             }else{
                 echo "<td>$r[pembuat]</td>";
             }
             echo"<td>$r[hits]</td>
             <td><a href='?module=materi&act=editmateri&id=$r[id_file]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> |
                 <a href=javascript:confirmdelete('$aksi?module=materi&act=hapus&id=$r[id_file]') title='Hapus'><img src='images/icons/cross.png' alt='Delete' /></a></td></tr>";
      $no++;
    }
    echo "</table>";
 
    }else if ($_SESSION[leveluser]=='pengajar'){
        $searchtext =  $_GET['searchtext'];
        $kelas =  $_GET['id_kelas'];
        $pelajaran =  $_GET['id_matapelajaran'];
        if($searchtext <> " " && $kelas <> " " && $pelajaran <> " "){
          $query = "SELECT * FROM `file_materi` WHERE `judul` LIKE '%$searchtext%' AND `id_kelas` LIKE '%$kelas%' AND `id_matapelajaran` LIKE '%$pelajaran%' AND pembuat = '$_SESSION[idpengajar]' order by id_file desc";
       }
       else if($searchtext <> " " && $kelas <> " " && $pelajaran == " "){
          $query = "SELECT * FROM `file_materi` WHERE `judul` LIKE '%$searchtext%' AND `id_kelas` LIKE '%$kelas%' AND pembuat = '$_SESSION[idpengajar]' order by id_file desc";
       }
       else if($searchtext <> " " && $kelas == " " && $pelajaran <> " "){
          $query = "SELECT * FROM `file_materi` WHERE `judul` LIKE '%$searchtext%' AND `id_matapelajaran` LIKE '%$pelajaran%' AND pembuat = '$_SESSION[idpengajar]' order by id_file desc";
      }
      else if($searchtext == " " && $kelas <> " " && $pelajaran <> " "){
          $query = "SELECT * FROM `file_materi` WHERE `id_kelas` LIKE '%$kelas%' AND `id_matapelajaran` LIKE '%$pelajaran%' AND pembuat = '$_SESSION[idpengajar]' order by id_file desc";
      }
      else if($searchtext <> " " && $kelas == " " && $pelajaran == " "){
          $query = "SELECT * FROM `file_materi` WHERE `judul` LIKE '%$searchtext%' AND pembuat = '$_SESSION[idpengajar]' order by id_file desc";
      }  
      else if($searchtext == " " && $kelas <> " " && $pelajaran == " "){
          $query = "SELECT * FROM `file_materi` WHERE `id_kelas` LIKE '%$kelas%' AND pembuat = '$_SESSION[idpengajar]' order by id_file desc";
      }  
      else if($searchtext == " " && $kelas == " " && $pelajaran <> " "){
          $query = "SELECT * FROM `file_materi` WHERE `id_matapelajaran` LIKE '%$pelajaran%' AND pembuat = '$_SESSION[idpengajar]' order by id_file desc";
      }       
       else{
           $query = "SELECT * FROM `file_materi` WHERE pembuat = '$_SESSION[idpengajar]' order by id_file desc";
       }     
        $tampil_materi = mysql_query($query);
        $cek_materi = mysql_num_rows($tampil_materi);
       
        echo "<h2>Daftar Materi Yang Anda Upload</h2><hr>
          <input class='button blue' type=button value='Tambah Materi' onclick=\"window.location.href='?module=materi&act=tambahmateri';\">";
          echo "<br><br><form method=GET action='' name='form_topik'>
          <fieldset>
          <legend>Search</legend>
          <dl class='inline'>
          <input type=text name='module' value='materi' hidden>
          <input type=text name='act' value='searchmateri' hidden>
          <dt><input type=text name='searchtext' placeholder='judul/nama file' size='35'>
          </dt>           
         <dt><select name='id_kelas' onChange='showpel()' style='width: 205px;'>
         <option value=''>Pilih kelas/ALL</option>";
         $pilih="SELECT * FROM kelas ORDER BY nama";
         $query=mysql_query($pilih);
         while($row=mysql_fetch_array($query)){
         echo"<option value='".$row[id_kelas]."'>".$row[nama]."</option>";
         }
         echo"</select>&nbsp;</dt><dd><div id='pelajaran'></div></dd>
         <dt> <input class='button blue' type=submit value=Search></dt>              
          </dl>          
          </fieldset></form>";
        echo "<br><br><table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Judul</th><th>Kelas</th><th>Mata Kuliah</th><th>Nama File</th><th>Tgl Upload</th><th>Hits</th><th>Aksi</th></tr></thead>";
       $no=1;
    while ($r=mysql_fetch_array($tampil_materi)){
      $tgl_posting   = tgl_indo($r[tgl_posting]);
       echo "<tr><td>$no</td>
             <td>$r[judul]</td>";
             $kelas = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$r[id_kelas]'");
             $cek_kelas = mysql_num_rows($kelas);
             if(!empty($cek_kelas)){
             while($k=mysql_fetch_array($kelas)){
                 echo "<td><a href=?module=kelas&act=detailkelas&id=$r[id_kelas] title='Detail Kelas'>$k[nama]</td>";
             }
             }else{
                 echo"<td></td>";
             }
             $pelajaran = mysql_query("SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$r[id_matapelajaran]'");
             
             $cek_pelajaran = mysql_num_rows($pelajaran);
             if(!empty($cek_pelajaran)){
             while($p=mysql_fetch_array($pelajaran)){
                echo "<td><a href=?module=matapelajaran&act=detailpelajaran&id=$r[id_matapelajaran] title='Detail pelajaran'>$p[nama]</a></td>";
             }
             }else{
                 echo"<td></td>";
             }

             echo "<td>$r[nama_file]</td>
             <td>$tgl_posting</td>";
            
             echo"<td>$r[hits]</td>
             <td><a href='?module=materi&act=editmateri&id=$r[id_file]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> |
                 <a href=javascript:confirmdelete('$aksi?module=materi&act=hapus&id=$r[id_file]') title='Hapus'><img src='images/icons/cross.png' alt='Delete' /></a></td></tr>";
      $no++;
    }
    echo "</table>";
 
    }
   
 
    break;


case "daftarmateri":
    if ($_SESSION[leveluser] == 'siswa'){
        
        $p      = new Paging;
        $batas  = 5;
        $posisi = $p->cariPosisi($batas);

        $mapel = mysql_query("SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$_GET[id]'");
        $data_mapel = mysql_fetch_array($mapel);
        $materi = mysql_query("SELECT * FROM file_materi WHERE id_matapelajaran = '$_GET[id]' order by id_file desc LIMIT $posisi,$batas ");
        $cek_materi = mysql_num_rows($materi);
        if (!empty($cek_materi)){
        echo"<br><b class='judul'>Daftar File Materi $data_mapel[nama] </b><br><p class='garisbawah'></p>";
        echo "<form method=GET action='' name='form_topik'>
          <fieldset>
          <dl class='inline'>
          <input type=text name='module' value='materi' hidden>
          <input type=text name='act' value='searchdaftarmateri' hidden>
          <input type=text name='id' value='$_GET[id]' hidden>
          <dt><input type=text name='searchtext' placeholder='judul/nama file' size='35' style='border-radius: 5px; padding:4px 5px;'> <input class='button blue' type=submit value=Search style='font-weight: bold;
          border: 1px solid #0d717e;
          background: #28a0b2;
          color: #fff;       
          display: inline-block;
          zoom: 1;
          *display: inline;
          vertical-align: baseline;
          margin: 0 3px 0 1px; 
          outline: none; 
          cursor: pointer; 
          text-align: center;
          padding: 6px 8px; 
          text-shadow: 1px 1px 1px #555; 
          width: auto; 
          overflow: visible; 
          line-height: 110%;'>
          </dt>                
          </dl>
          </fieldset></form><br>";
        echo "<table>";
        $no=$posisi+1;
        while ($r=mysql_fetch_array($materi)){
        echo "<tr><td rowspan='5'>$no</td>";
             if (!empty($r[nama_file])){
             $pecah = explode(".", $r[nama_file]);
             $ekstensi = $pecah[1];
             if ($ekstensi == 'zip'){
                 echo "<td rowspan='5'><img src='images/zip.png'></td>";
             }
             elseif ($ekstensi == 'rar'){
                 echo "<td rowspan='5'><img src='images/rar.png'></td>";
             }
             elseif ($ekstensi == 'doc'){
                 echo "<td rowspan='5'><img src='images/doc.png'></td>";
             }
             elseif ($ekstensi == 'pdf'){
                 echo "<td rowspan='5'><img src='images/pdf.png'></td>";
             }
             elseif ($ekstensi == 'ppt'){
                 echo "<td rowspan='5'><img src='images/ppt.png'></td>";
             }
             elseif ($ekstensi == 'pptx'){
                 echo "<td rowspan='5'><img src='images/pptx.png'></td>";
             }
             elseif ($ekstensi == 'docx'){
                 echo "<td rowspan='5'><img src='images/doc.png'></td>";
             }
             elseif ($ekstensi == 'mp3'){
                echo "<td rowspan='5'><img src='images/mp3.jpg'></td>";
            }
            elseif ($ekstensi == 'mp4'){
                echo "<td rowspan='5'><img src='images/mp4.png'></td>";
            }
             }else{
                 echo "<td rowspan='5'><img src='images/kosong.png'></td>";
             }
             echo "<td>Judul</td><td>: $r[judul]</td></tr>
             <tr><td>Nama File</td><td>: $r[nama_file]</td></tr>
             <tr><td>Ukuran</td>";
                            if (!empty($r[nama_file])){
                            $file = "files_materi/$r[nama_file]";                            
                            echo "<td>: ". fsize($file)."</td></tr>";
                            }else{
                                echo "<td>: </td></tr>";
                            }
             echo"<tr><td>Tanggal Posting</td><td>: $r[tgl_posting]</td></tr>
             <tr><td colspan=2><input type=button class='tombol' value='Download File'
                       onclick=\"window.location.href='downlot.php?file=$r[nama_file]';\">
                       <b class='judul'>Di download : $r[hits] kali</b></td></tr>";
        $no++;
        }
        echo "</table>";
        $jmldata=mysql_num_rows(mysql_query("SELECT * FROM file_materi WHERE id_matapelajaran = '$_GET[id]'"));
        $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
        $linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

        echo "<div id=paging>$linkHalaman</div><br>";

        echo "<p class='garisbawah'></p><input type=button class='tombol' value='Kembali'
          onclick=self.history.back()>";
    }
    else{
        echo "<script>window.alert('Tidak ada file materi di mata pelajaran ini?');
            window.location=(href='media.php?module=materi')</script>";
    }
    }
    break;

    case "searchdaftarmateri":
    if ($_SESSION[leveluser] == 'siswa'){
        
        $p      = new Paging;
        $batas  = 2;
        $posisi = $p->cariPosisi($batas);

       

        $mapel = mysql_query("SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$_GET[id]'");
        $data_mapel = mysql_fetch_array($mapel);

        $searchtext =  $_GET['searchtext'];
        if($searchtext <> " "){
            $query = "SELECT * FROM `file_materi` WHERE `judul` LIKE '%$searchtext%' OR `nama_file` LIKE '%$searchtext%' AND `id_matapelajaran` = '$_GET[id]' order by id_file desc LIMIT $posisi,$batas";
         }else{
            $query = "SELECT * FROM `file_materi` WHERE `id_matapelajaran` = '$_GET[id]' order by id_file desc LIMIT $posisi,$batas";
         }

         $materi = mysql_query($query);
        $cek_materi = mysql_num_rows($materi);
        if (!empty($cek_materi)){
        echo"<br><b class='judul'>Daftar File Materi $data_mapel[nama] </b><br><p class='garisbawah'></p>";
        echo "<form method=GET action='' name='form_topik'>
          <fieldset>
          <dl class='inline'>
          <input type=text name='module' value='materi' hidden>
          <input type=text name='act' value='searchdaftarmateri' hidden>
          <dt><input type=text name='searchtext' placeholder='judul/nama file' size='35' style='border-radius: 5px; padding:4px 5px;'> <input class='button blue' type=submit value=Search style='font-weight: bold;
          border: 1px solid #0d717e;
          background: #28a0b2;
          color: #fff;       
          display: inline-block;
          zoom: 1;
          *display: inline;
          vertical-align: baseline;
          margin: 0 3px 0 1px; 
          outline: none; 
          cursor: pointer; 
          text-align: center;
          padding: 6px 8px; 
          text-shadow: 1px 1px 1px #555; 
          width: auto; 
          overflow: visible; 
          line-height: 110%;'>
          </dt>                
          </dl>
          </fieldset></form><br>";
        echo "<table>";
        $no=$posisi+1;
        while ($r=mysql_fetch_array($materi)){
        echo "<tr><td rowspan='5'>$no</td>";
             if (!empty($r[nama_file])){
             $pecah = explode(".", $r[nama_file]);
             $ekstensi = $pecah[1];
             if ($ekstensi == 'zip'){
                 echo "<td rowspan='5'><img src='images/zip.png'></td>";
             }
             elseif ($ekstensi == 'rar'){
                 echo "<td rowspan='5'><img src='images/rar.png'></td>";
             }
             elseif ($ekstensi == 'doc'){
                 echo "<td rowspan='5'><img src='images/doc.png'></td>";
             }
             elseif ($ekstensi == 'pdf'){
                 echo "<td rowspan='5'><img src='images/pdf.png'></td>";
             }
             elseif ($ekstensi == 'ppt'){
                 echo "<td rowspan='5'><img src='images/ppt.png'></td>";
             }
             elseif ($ekstensi == 'pptx'){
                 echo "<td rowspan='5'><img src='images/pptx.png'></td>";
             }
             elseif ($ekstensi == 'docx'){
                 echo "<td rowspan='5'><img src='images/doc.png'></td>";
             }
             elseif ($ekstensi == 'mp3'){
                echo "<td rowspan='5'><img src='images/mp3.jpg'></td>";
            }
            elseif ($ekstensi == 'mp4'){
                echo "<td rowspan='5'><img src='images/mp4.png'></td>";
            }
             }else{
                 echo "<td rowspan='5'><img src='images/kosong.png'></td>";
             }
             echo "<td>Judul</td><td>: $r[judul]</td></tr>
             <tr><td>Nama File</td><td>: $r[nama_file]</td></tr>
             <tr><td>Ukuran</td>";
                            if (!empty($r[nama_file])){
                            $file = "files_materi/$r[nama_file]";                            
                            echo "<td>: ". fsize($file)."</td></tr>";
                            }else{
                                echo "<td>: </td></tr>";
                            }
             echo"<tr><td>Tanggal Posting</td><td>: $r[tgl_posting]</td></tr>
             <tr><td colspan=2><input type=button class='tombol' value='Download File'
                       onclick=\"window.location.href='downlot.php?file=$r[nama_file]';\">
                       <b class='judul'>Di download : $r[hits] kali</b></td></tr>";
        $no++;
        }
        echo "</table>";
        $jmldata=mysql_num_rows(mysql_query("SELECT * FROM file_materi WHERE id_matapelajaran = '$_GET[id]'"));
        $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
        $linkHalaman = $p->navSearchHalaman($_GET[halaman], $jmlhalaman);

        echo "<div id=paging>$linkHalaman</div><br>";

        echo "<p class='garisbawah'></p><input type=button class='tombol' value='Kembali'
          onclick=self.history.back()>";
    }
    else{
        echo "<script>window.alert('Tidak ada file materi di mata pelajaran ini?');
            window.location=(href='media.php?module=materi')</script>";
    }
    }
    break;

case "tambahmateri":
    if ($_SESSION[leveluser]=='admin'){
    echo "<form name='form_materi' method=POST action='$aksi?module=materi&act=input_materi' enctype='multipart/form-data'>
     <fieldset>
     <legend>Tambah Materi</legend>
     <dl class='inline'>
    <dt><label>Judul</label></dt>              <dd><input type=text name='judul' size=50 required='required'></dd>
    <dt><label>Kelas</label></dt>              <dd><select name='id_kelas' onChange='showpel_pengajar()' required>
                                          <option value=''>-pilih-</option>";                                          
                                          $cari_kelas = mysql_query("SELECT * FROM kelas ORDER BY nama");
                                          while ($k=mysql_fetch_array($cari_kelas)){
                                          echo"<option value='".$k[id_kelas]."'>".$k[nama]."</option>";
                                          }                                          
                                          echo"</select></dd>
    <dt><label>Pelajaran</label></dt>          <dd><div id='pelajaran'></div></dd>
    <dt><label>File</label></dt>               <dd><input type=file name='fupload' size=40>
    <small>Max size 5mb</small></dd>
    </dl>
          
          <p align=center><input class='button blue' type=submit value=Simpan>
          <input class='button blue' type=button value=Batal onclick=self.history.back()></p>
          
          </fieldset></form>";
    }else{
    echo "
    <form name='form_materi_pengajar' method=POST action='$aksi?module=materi&act=input_materi' enctype='multipart/form-data'>
    <fieldset>
    <legend>Tambah Materi</legend>
    <dl class='inline'>
    <dt><label>Judul</label></dt>              <dd> <input type=text name='judul' size=50 required='required'></dd>
    <dt><label>Kelas</label></dt>              <dd> <select name='id_kelas' onChange='showpel_pengajar()' required>
                                          <option value='' selected>-pilih-</option>";
                                          $pilih= mysql_query("SELECT DISTINCT id_kelas FROM mata_pelajaran WHERE id_pengajar ='$_SESSION[idpengajar]'");
                                          while($row=mysql_fetch_array($pilih)){
                                          $cari_kelas = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$row[id_kelas]'");
                                          while ($k=mysql_fetch_array($cari_kelas)){
                                          echo"<option value='".$k[id_kelas]."'>".$k[nama]."</option>";
                                          }
                                          }
                                          echo"</select></dd>
    <dt><label>Pelajaran</label></dt>          <dd> <div id='pelajaran_pengajar'></div></dd>
    <dt><label>File</label></dt>              <dd> <input type=file name='fupload' size=35 required>
    <small>Max size 5mb</small></dd> 
    <p align=center><input class='button blue' type=submit value=Simpan>
                      <input class='button blue' type=button value=Batal onclick=\"window.location.href='?module=materi';\"></p>
    </dl></fieldset></form>";
    }
    break;

case "editmateri":
    if ($_SESSION[leveluser]=='admin'){
    $edit=mysql_query("SELECT * FROM file_materi WHERE id_file = '$_GET[id]'");
    $m=mysql_fetch_array($edit);
    $isikelas = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$m[id_kelas]'");
    $k=mysql_fetch_array($isikelas);
    $pelajaran = mysql_query("SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$m[id_matapelajaran]'");
    $p=mysql_fetch_array($pelajaran);

    echo "
    <form name='form_materi' method=POST action='$aksi?module=materi&act=edit_materi' enctype='multipart/form-data'>
    <input type=hidden name=id value='$m[id_file]'>
    <fieldset>
     <legend>Edit Materi</legend>
     <dl class='inline'>
    <dt><label>Judul</label></dt>             <dd>: <input type=text name='judul' value='$m[judul]' required='required'></dd>
    <dt><label>Kelas</label></dt>               <dd>: <select name='id_kelas' onChange='showpel()' required>
                                          <option value='".$k[id_kelas]."' selected>".$k[nama]."</option>";
                                          $pilih="SELECT * FROM kelas ORDER BY nama";
                                          $query=mysql_query($pilih);
                                          while($row=mysql_fetch_array($query)){
                                          echo"<option value='".$row[id_kelas]."'>".$row[nama]."</option>";
                                          }
                                          echo"</select></dd>
    <dt><label>Pelajaran</label></dt>           <dd>: <select id='pelajaran' name='id_matapelajaran'>
                                          <option value='".$p[id_matapelajaran]."' selected>".$p[nama]."</option>
                                          </select></dd>
    <dt><label>File</label></dt>                <dd>: $m[nama_file]</dd>
    <dt><label>Ganti File </label></dt>         <dd>: <input type=file name='fupload' size=40>
                                                     <small>Max size 5mb, Apabila file tidak diganti, di kosongkan saja</small></dd>
    </dl>

          <p align=center><input class='button blue' type=submit value=Update>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          <input type=button class='button small white' value='Teruskan materi ke kelas lain' onclick=\"window.location.href='?module=materi&act=teruskanmateri&id=$m[id_file]';\"></input></p>

          </fieldset></form>";
    }
    else{
    $edit=mysql_query("SELECT * FROM file_materi WHERE id_file = '$_GET[id]'");
    $m=mysql_fetch_array($edit);
    $isikelas = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$m[id_kelas]'");
    $k=mysql_fetch_array($isikelas);
    $pelajaran = mysql_query("SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$m[id_matapelajaran]'");
    $p=mysql_fetch_array($pelajaran);

    echo "<form name='form_materi_pengajar' method=POST action='$aksi?module=materi&act=edit_materi' enctype='multipart/form-data'>
    <input type=hidden name=id value='$m[id_file]'>
    <fieldset>
    <legend>Edit Materi</legend>
    <dl class='inline'>
    <dt><label>Judul</label></dt>              <dd>: <input type=text name='judul' value='$m[judul]' size=50></dd>
    <dt><label>Kelas</label></dt>              <dd>: <select name='id_kelas' onChange='showpel_pengajar()'>
                                          <option value='".$k[id_kelas]."' selected>".$k[nama]."</option>";
                                          $pilih="SELECT * FROM kelas WHERE id_pengajar = '$_SESSION[idpengajar]'";
                                          $query=mysql_query($pilih);
                                          while($row=mysql_fetch_array($query)){
                                          echo"<option value='".$row[id_kelas]."'>".$row[nama]."</option>";
                                          }
                                          echo"</select></dd>
    <dt><label>Pelajaran</label></dt>          <dd>: <select id='pelajaran_pengajar' name='id_matapelajaran'>
                                          <option value='".$p[id_matapelajaran]."' selected>".$p[nama]."</option>
                                          </select></dd>
    <dt><label>File</label></dt>              <dd>: $m[nama_file]</dd>
    <dt><label>Ganti File</label></dt>        <dd>: <input type=file name='fupload' size=40>
    <small>Max size 5mb, Apabila file tidak diganti, di kosongkan saja</small></dd>
    <p align=center><input class='button blue' type=submit value=Simpan>
                      <input class='button blue' type=button value=Batal onclick=self.history.back()>
                      <input type=button class='button small white' value='Teruskan materi ke kelas lain' onclick=\"window.location.href='?module=materi&act=teruskanmateri&id=$m[id_file]';\"></input></p>
    </dl></fieldset></form>";
    }
    break;

    case "teruskanmateri":
    if ($_SESSION[leveluser]=='admin'){
    $edit=mysql_query("SELECT * FROM file_materi WHERE id_file = '$_GET[id]'");
    $m=mysql_fetch_array($edit);
    $isikelas = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$m[id_kelas]'");
    $k=mysql_fetch_array($isikelas);
    $pelajaran = mysql_query("SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$m[id_matapelajaran]'");
    $p=mysql_fetch_array($pelajaran);

    echo "
    <form name='form_materi' method=POST action='$aksi?module=materi&act=teruskan_materi' enctype='multipart/form-data'>
    <input type=hidden name=id value='$m[id_file]'>
    <fieldset>
     <legend>Teruskan Materi Untuk kelas lain</legend>
     <dl class='inline'>
    <dt><label>Judul</label></dt>             <dd>: <input type=text name='judul' value='$m[judul]' style='pointer-events: none;></dd>
    <dt><label>Kelas</label></dt>               <dd>: <select name='id_kelas' onChange='showpel()'>
                                          <option value='".$k[id_kelas]."' selected>".$k[nama]."</option>";
                                          $pilih="SELECT * FROM kelas ORDER BY nama";
                                          $query=mysql_query($pilih);
                                          while($row=mysql_fetch_array($query)){
                                          echo"<option value='".$row[id_kelas]."'>".$row[nama]."</option>";
                                          }
                                          echo"</select></dd>
    <dt><label>Pelajaran</label></dt>           <dd>: <select id='pelajaran' name='id_matapelajaran'>
                                          <option value='".$p[id_matapelajaran]."' selected>".$p[nama]."</option>
                                          </select></dd>
    <dt><label>File</label></dt>                <dd>: <input type=text name='nama_file' value='$m[nama_file]' style='pointer-events: none;'></dd>
    
    </dl>

          <p align=center><input class='button blue' type=submit value=Update>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </p>

          </fieldset></form>";
    }
    else{
    $edit=mysql_query("SELECT * FROM file_materi WHERE id_file = '$_GET[id]'");
    $m=mysql_fetch_array($edit);
    $isikelas = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$m[id_kelas]'");
    $k=mysql_fetch_array($isikelas);
    $pelajaran = mysql_query("SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$m[id_matapelajaran]'");
    $p=mysql_fetch_array($pelajaran);

    echo "<form name='form_materi_pengajar' method=POST action='$aksi?module=materi&act=teruskan_materi' enctype='multipart/form-data'>
    <input type=hidden name=id value='$m[id_file]'>
    <fieldset>
    <legend>Teruskan Materi Untuk kelas lain</legend>
    <dl class='inline'>
    <dt><label>Judul</label></dt>              <dd>: <input type=text name='judul' value='$m[judul]' size=50 style='pointer-events: none;'></dd>
    <dt><label>Kelas</label></dt>              <dd>: <select name='id_kelas' onChange='showpel_pengajar()'>
                                          <option value='".$k[id_kelas]."' selected>".$k[nama]."</option>";
                                          $pilih="SELECT * FROM kelas WHERE id_pengajar = '$_SESSION[idpengajar]'";
                                          $query=mysql_query($pilih);
                                          while($row=mysql_fetch_array($query)){
                                          echo"<option value='".$row[id_kelas]."'>".$row[nama]."</option>";
                                          }
                                          echo"</select></dd>
    <dt><label>Pelajaran</label></dt>          <dd>: <select id='pelajaran_pengajar' name='id_matapelajaran'>
                                          <option value='".$p[id_matapelajaran]."' selected>".$p[nama]."</option>
                                          </select></dd>
    <dt><label>File</label></dt>              <dd>: <input type=text name='nama_file' value='$m[nama_file]' style='pointer-events: none;'></dd>
   
    <p align=center><input class='button blue' type=submit value=Simpan>
                      <input class='button blue' type=button value=Batal onclick=self.history.back()>
                      </p>
    </dl></fieldset></form>";
    }
    break;

}
}
?>
