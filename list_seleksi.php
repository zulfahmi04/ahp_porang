<div class="judul">Daftar Seleksi</div>
<div class="csstable" >
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td width="3%">No.</td>
        <td width="5%">Tahun</td>
        <td width="32%">Seleksi (Nama Seleksi)</td>
        <td width="50%">Catatan</td>
        <td width="10%"><a href="?h=seleksi-input&stat=tambah" class="tombol-mini w_biru hvr-fade" style="width:98px;">Tambah</a></td>
      </tr>
      <?php
	  $no=0;
	  $hquery=$koneksi->query("SELECT id_seleksi, seleksi, tahun, catatan FROM ahp_seleksi ORDER BY id_seleksi ASC");
	  while($data=mysqli_fetch_array($hquery)){
		 $no++;
	  ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $data['tahun']; ?></td>
        <td><?php echo $data['seleksi']; ?></td>
        <td><?php echo $data['catatan']; ?></td>
        <td width="10%" style="text-align:center;">
			<script type="text/javascript">
            function konfirmasi<?php echo $data[0]; ?>() {
                var answer = confirm("Anda yakin akan menghapus data (<?php echo $data['tahun']."-".$data['seleksi']; ?>) ini ?")
                if (answer){
                    window.location = "?h=seleksi-input&stat=hapus&id=<?php echo"$data[0]"; ?>";
                }
            }
            </script>
            <a href="?h=seleksi-input&stat=ubah&id=<?php echo $data['id_seleksi']; ?>" class="tombol-mini w_hijau hvr-fade">Ubah</a>
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
