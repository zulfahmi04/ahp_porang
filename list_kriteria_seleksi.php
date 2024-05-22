<?php $seleksi=antiinjec($koneksi, @$_POST['seleksi']); ?>
<div class="judul">Daftar Kriteria Setiap Seleksi</div>
<div class="csstable" >
	<form method="post" enctype="multipart/form-data" action="">
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td width="5%">Seleksi</td>
        <td width="25%">
            <select class="required" name="seleksi" style="width:300px;">
                <?php
                $hseleksi=$koneksi->query("SELECT id_seleksi, seleksi, tahun, catatan FROM ahp_seleksi ORDER BY tahun DESC, id_seleksi DESC");
                while($dseleksi=mysqli_fetch_array($hseleksi)){
                ?>
                <option value="<?php echo $dseleksi['id_seleksi']; ?>" <?php if($dseleksi['id_seleksi']==$seleksi) { echo "selected"; } ?>><?php echo $dseleksi['tahun']." - ".$dseleksi['seleksi']; ?></option>
                <?php } ?>
             </select>
        </td>
        <td width="3%"><button type='submit' name="btn_cari" class="tombol-mini2 w_orange hvr-fade2">Cari</button></td>
	  	<td width="67%">&nbsp;</td>
      </tr>
    </table>
    </form>
    <?php
    if($seleksi=="") {
      $q_per="SELECT id_seleksi, seleksi, tahun, catatan FROM ahp_seleksi ORDER BY tahun DESC, id_seleksi DESC LIMIT 0, 1";
      $h_per=$koneksi->query($q_per);
      $d_per=mysqli_fetch_array($h_per);
      $seleksi=$d_per['id_seleksi'];
    }
    ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td width="3%">No.</td>
        <td width="92%">Nama Kriteria</td>
        <td width="5%">
            <form method="post" enctype="multipart/form-data" action="?h=kriteria-seleksi-input&stat=tambah">
                <input type="hidden" name="seleksi" value="<?php echo $seleksi; ?>" />
                <button type='submit' name="btn_tambah" style="width:98px;" class="tombol-mini2 w_biru hvr-fade">Tambah</button>
            </form>
        </td>
      </tr>
      <?php
	  $no=0;
	  $hquery=$koneksi->query("SELECT b.id_kriteria_seleksi, a.id_kriteria, a.kriteria, a.keterangan
					   FROM ahp_kriteria as a, ahp_kriteria_seleksi as b
					   WHERE a.id_kriteria=b.id_kriteria AND b.id_seleksi='$seleksi' ORDER BY b.id_kriteria_seleksi ASC");
	  $jml_baris=mysqli_num_rows($hquery);
	  while($data=mysqli_fetch_array($hquery)){
		 $no++;
	  ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $data['kriteria']; ?></td>
        <td style="text-align:center;">
			<script type="text/javascript">
            function konfirmasi<?php echo $data[0]; ?>() {
                var answer = confirm("Anda yakin akan menghapus data (<?php echo $data['kriteria']; ?>) ini ?")
                if (answer){
                    window.location = "?h=kriteria-seleksi-input&stat=hapus&id=<?php echo $data[0]; ?>";
                }
            }
            </script>
            <a class="tombol-mini w_merah hvr-fade" onclick="konfirmasi<?php echo $data[0]; ?>()">Hapus</a>
        </td>
      </tr>
      <?php } if(@$_GET['con']!="") { ?>
      <tr>
      	<td><img src="images/ico_cek.png" width="22"></td>
        <td colspan="7" style="color:#360; font-weight:600; font-size:14px;">
			<?php 
				if(@$_GET['con']==1) { echo "Data berhasil ditambahkan."; }
				elseif(@$_GET['con']==2) { echo "Data berhasil diubah."; }
				elseif(@$_GET['con']==3) { echo "Data berhasil dihapus."; }
			?>
		</td>
      </tr>
      <?php } if($jml_baris==0) { ?>
      <tr>
      	<td><img src="images/ico_alert.png" width="22"></td>
        <td colspan="7" style="color:#F30; font-weight:600; font-size:14px;">Belum ada data</td>
      </tr>
      <?php } ?>
    </table>
    <br />
</div>