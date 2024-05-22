<div class="judul">Daftar Pengguna Sistem</div>
<div class="csstable" >
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td width="3%">No.</td>
        <td width="14%">Username</td>
        <td width="19%">Nama Lengkap</td>
        <td width="10%">No Telp</td>
        <td width="46%">Hak Akses</td>
        <td width="8%"><a href="?h=pengguna-input&stat=tambah" class="tombol-mini w_biru hvr-fade" style="width:98px;">Tambah</a></td>
      </tr>
      <?php
	  $no=0;
	  $hquery=$koneksi->query("SELECT id_pengguna, nama, no_telp, username, tipe FROM ahp_pengguna ORDER BY id_pengguna ASC");
	  while($data=mysqli_fetch_array($hquery)){
		 $no++;
		 if($data['tipe']==1) { $tipe_adm="Normal"; }
		 elseif($data['tipe']==2) { $tipe_adm="Administrator"; }
	  ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $data['username']; ?></td>
        <td><?php echo $data['nama']; ?></td>
        <td><?php echo $data['no_telp']; ?></td>
        <td><?php echo $tipe_adm; ?></td>
        <td width="8%" style="text-align:center;">
			<script type="text/javascript">
            function konfirmasi<?php echo $data[0]; ?>() {
                var answer = confirm("Anda yakin akan menghapus data (<?php echo $data['username']; ?>) ini ?")
                if (answer){
                    window.location = "?h=pengguna-input&stat=hapus&id=<?php echo"$data[0]"; ?>";
                }
            }
            </script>
            <a href="?h=pengguna-input&stat=ubah&id=<?php echo $data['id_pengguna']; ?>" class="tombol-mini w_hijau hvr-fade">Ubah</a>
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
      </tr>
      <?php } ?>
    </table>
</table>
    <br />
</div>
