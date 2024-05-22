<?php
$seleksi=antiinjec($koneksi, @$_REQUEST['seleksi']);
$stat	= @$_GET['stat'];
$id		= antiinjec($koneksi, @$_REQUEST['id']);
if($stat=="tambah") {
	$td=date('Y-m-d');
}elseif($stat=="ubah") {
	$hdata=$koneksi->query("SELECT nama_alternatif, catatan, tgl_daftar FROM ahp_alternatif WHERE id_alternatif='$id'");
	$data=mysqli_fetch_array($hdata);
	$td=@$data['tgl_daftar'];
}
if(@$_POST['stat_simpan']) {
	
	$id				= antiinjec($koneksi, @$_POST['id']);
	$nama_alternatif= antiinjec($koneksi, @$_POST['nama_alternatif']);
	$catatan		= antiinjec($koneksi, @$_POST['catatan']);
	$tgl_daftar		= antiinjec($koneksi, @$_POST['tgl_daftar']);
	$seleksi		= antiinjec($koneksi, @$_POST['seleksi']);
	
	if($stat=="tambah") {
		$koneksi->query("INSERT INTO ahp_alternatif(nama_alternatif, catatan, tgl_daftar, id_seleksi)
				 VALUES ('$nama_alternatif', '$catatan', '$tgl_daftar', '$seleksi')");
		?>
		<script language="JavaScript">document.location='?h=alternatif&con=1'</script>
		<?php
	} elseif($stat=="ubah") {
		$koneksi->query("UPDATE ahp_alternatif SET nama_alternatif='$nama_alternatif', catatan='$catatan', tgl_daftar='$tgl_daftar' 
				 WHERE id_alternatif='$id'");
		?>
		<script language="JavaScript">document.location='?h=alternatif&con=2'</script>
		<?php
	}
} elseif($stat=="hapus" && $id!="") {
	$koneksi->query("DELETE FROM ahp_alternatif WHERE id_alternatif='$id'");
	?>
	<script language="JavaScript">document.location='?h=alternatif&con=3'</script>
	<?php
}
?>
<div class="judul"><?php if($stat=="tambah") { echo "Tambah"; } elseif($stat=="ubah") { echo "Ubah"; } ?> <?php echo $kasus_objek; ?></div>
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
<section class='form'>
  <form action="?h=alternatif-input&stat=<?php echo $stat; ?>" method="post" enctype="multipart/form-data" novalidate>
  	  <input type="hidden" name="stat_simpan" value="set">
      <input type="hidden" name="seleksi" value="<?php echo $seleksi; ?>" />
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <fieldset>
          <div class="item">
              <label>
                  <span>Nama <?php echo $kasus_objek; ?></span>
                  <input data-validate-length-range="3" data-validate-words="1" name="nama_alternatif" value="<?php echo @$data['nama_alternatif']; ?>" placeholder="" required/>
              </label>
              <div class='tooltip help'>
                  <span>?</span>
                  <div class='content'>
                      <b></b>
                      <p>Name <?php echo $kasus_objek; ?>, tidak boleh disingkat</p>
                  </div>
              </div>
          </div>
          <div class="item">
              <label>
                  <span>Catatan</span>
                  <textarea required name="catatan" style="width:200px; height:50px;"><?php echo @$data['catatan']; ?></textarea>
              </label>
          </div>
          <div class="item" style="clear:both;">
              <label>
                  <span>Tanggal Daftar</span>
                  <input class='date' type="date" name="tgl_daftar" value="<?php echo @$td; ?>" required='required'>
              </label>
          </div>
      </fieldset>
      <button id='send' type='submit' name="btn_simpan" class="tombol-large w_biru hvr-fade">Simpan Data</button>
      <button id='send' type='button' class="tombol-large w_orange hvr-fade" onclick="window.history.back();">Batal</button>
  </form>
</section>
