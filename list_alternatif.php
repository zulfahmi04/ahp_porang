<?php $seleksi=antiinjec($koneksi, @$_POST['seleksi']); ?>
<div class="judul">Daftar <?php echo $kasus_objek; ?> (Alternatif)</div>
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
        <td width="30%"><?php echo $kasus_objek; ?></td>
        <td width="49%">Catatan</td>
        <td width="13%">Tgl Terdaftar</td>
        <td width="5%">
            <form method="post" enctype="multipart/form-data" action="?h=alternatif-input&stat=tambah">
                <input type="hidden" name="seleksi" value="<?php echo $seleksi; ?>" />
                <button type='submit' name="btn_tambah" style="width:113px;" class="tombol-mini2 w_biru hvr-fade">Tambah</button>
            </form>
        </td>
      </tr>
      <?php
	  $no=0;
	  $hquery=$koneksi->query("SELECT id_alternatif, nama_alternatif, catatan, tgl_daftar 
					   FROM ahp_alternatif
					   WHERE id_seleksi='$seleksi' ORDER BY id_alternatif ASC");
	  while($data=mysqli_fetch_array($hquery)){
		 $no++;
	  ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $data['nama_alternatif']; ?></td>
        <td><?php echo $data['catatan']; ?></td>
        <td><?php echo date("d/m/Y", strtotime($data['tgl_daftar'])); ?></td>
        <td style="text-align:center;">
			<script type="text/javascript">
            function konfirmasi<?php echo $data[0]; ?>() {
                var answer = confirm("Anda yakin akan menghapus data (<?php echo $data['nama_alternatif']; ?>) ini ?")
                if (answer){
                    window.location = "?h=alternatif-input&stat=hapus&id=<?php echo"$data[0]"; ?>";
                }
            }
            </script>
            <a href="?h=alternatif-input&stat=ubah&seleksi=<?php echo $seleksi; ?>&id=<?php echo $data['id_alternatif']; ?>" class="tombol-mini w_hijau hvr-fade">Ubah</a>
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
      <?php } ?>
    </table>
    <br />
</div>
