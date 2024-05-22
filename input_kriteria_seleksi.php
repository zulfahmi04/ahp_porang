<?php
$seleksi=antiinjec($koneksi, @$_POST['seleksi']);
$stat	= @$_GET['stat'];
$id		= antiinjec($koneksi, @$_GET['id']);

if(@$_POST['stat_simpan']) {
	
	$seleksi		= antiinjec($koneksi, @$_POST['seleksi']);
	$id_kriteria		= @$_POST['id_kriteria'];
	
	if($stat=="tambah") {
		$jml=count($id_kriteria);
		for($i=0; $i<$jml; $i++) {
			
			$query= "INSERT INTO ahp_kriteria_seleksi(id_seleksi, id_kriteria)
				 	 VALUES ('$seleksi', '$id_kriteria[$i]')";
			$koneksi->query($query);
			
		}
		?>
		<script language="JavaScript">document.location='?h=kriteria-seleksi&con=1'</script>
		<?php
	}
} elseif($stat=="hapus" && $id!="") {
	$koneksi->query("DELETE FROM ahp_kriteria_seleksi WHERE id_kriteria_seleksi='$id'");
	?>
	<script language="JavaScript">document.location='?h=kriteria-seleksi&con=3'</script>
	<?php
}
?>
<div class="judul">Tambah Kriteria Untuk Seleksi (ke Dalam Seleksi)</div>
<div class="csstable" >
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td width="6%">Seleksi</td>
        <td width="47%" style="text-align:left;">: 
		  <?php
          $hseleksi=$koneksi->query("SELECT id_seleksi, seleksi, tahun, catatan FROM ahp_seleksi WHERE id_seleksi='$seleksi'");
          $dseleksi=mysqli_fetch_array($hseleksi);
          echo $dseleksi['tahun']." - ".$dseleksi['seleksi']; 
          ?>
        </td>
	  	<td width="47%">&nbsp;</td>
      </tr>
    </table>
    <form action="?h=kriteria-seleksi-input&stat=<?php echo $stat; ?>" method="post" enctype="multipart/form-data" id="form1">
    <input type="hidden" name="seleksi" value="<?php echo $seleksi; ?>" />
  	<input type="hidden" name="stat_simpan" value="set">
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td width="3%">No.</td>
        <td width="2%"><img src="images/ico_cek.png" width="20px" /></td>
        <td width="36%">Nama Kriteria</td>
        <td width="59%">Keterangan</td>
      </tr>
      <?php
	  $no=0;
	  $hquery=$koneksi->query("SELECT a.id_kriteria, a.kriteria, a.keterangan
					   FROM ahp_kriteria as a
					   WHERE (a.id_kriteria NOT IN (SELECT id_kriteria FROM ahp_kriteria_seleksi WHERE id_seleksi='$seleksi'))
					   ORDER BY a.id_kriteria ASC");
	  $jml_baris=mysqli_num_rows($hquery);
	  while($data=mysqli_fetch_array($hquery)){
		 $no++;
	  ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><input type="checkbox" name="id_kriteria[]" value="<?php echo @$data['id_kriteria']; ?>"/></td>
        <td><?php echo $data['kriteria']; ?></td>
        <td><?php echo $data['keterangan']; ?></td>
      </tr>
      <?php } if($jml_baris==0) { ?>
      <tr>
      	<td><img src="images/ico_alert.png" width="22"></td>
        <td colspan="7" style="color:#F30; font-weight:600; font-size:14px;">Belum ada data</td>
      </tr>
      <?php } ?>
    </table>
    <?php if($jml_baris>0) { ?>
      <button id='send' type='submit' name="btn_simpan" class="tombol-large w_biru hvr-fade">Simpan Data</button>
    <?php } ?>
    </form>
    <br />
</div>
