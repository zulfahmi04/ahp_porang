<?php
$stat	= @$_GET['stat'];
$id		= antiinjec($koneksi, @$_GET['id']);
if($stat=="tambah") {
	$tl=date('Y-m-d', strtotime("-15 years"));
}elseif($stat=="ubah") {
	$hdata=$koneksi->query("SELECT id_kriteria, kriteria, keterangan FROM ahp_kriteria WHERE id_kriteria='$id'");
	$data=mysqli_fetch_array($hdata);
}
if(@$_POST['stat_simpan']) {
	
	$id				= antiinjec($koneksi, @$_POST['id']);
	$kriteria		= antiinjec($koneksi, @$_POST['kriteria']);
	$keterangan		= antiinjec($koneksi, @$_POST['keterangan']);
	
	if($stat=="tambah") {
		$d_cek=mysqli_fetch_array($koneksi->query("SELECT count(*) FROM ahp_kriteria WHERE kriteria='$kriteria'"));
		if($d_cek[0]==0) {
			$koneksi->query("INSERT INTO ahp_kriteria(kriteria, keterangan)
					 VALUES ('$kriteria', '$keterangan')");
			?>
			<script language="JavaScript">document.location='?h=kriteria&con=1'</script>
			<?php
		} else {
			//echo "<div class='warning'>Kriteria [$kriteria] sudah ada. </div>";
			?>
			<script language="JavaScript">alert('Kriteria [<?php echo $kriteria; ?>] sudah ada.'); history.go(-1); </script>
			<?php
		}
	} elseif($stat=="ubah") {
		$d_cek=mysqli_fetch_array($koneksi->query("SELECT count(*) FROM ahp_kriteria WHERE kriteria='$kriteria' AND id_kriteria<>'$id'"));
		echo $kriteria;
		if($d_cek[0]==0) {
			$koneksi->query("UPDATE ahp_kriteria SET kriteria='$kriteria', keterangan='$keterangan' WHERE id_kriteria='$id'");
			?>
			<script language="JavaScript">document.location='?h=kriteria&con=2'</script>
			<?php
		} else {
			//echo "<div class='warning'>Kriteria [$kriteria] sudah ada. </div>";
			?>
			<script language="JavaScript">alert('Kriteria [<?php echo $kriteria; ?>] sudah ada.'); history.go(-1); </script>
			<?php
		}
	}
} elseif($stat=="hapus" && $id!="") {
	$koneksi->query("DELETE FROM ahp_kriteria WHERE id_kriteria='$id'");
	?>
	<script language="JavaScript">document.location='?h=kriteria&con=3'</script>
	<?php
}
?>
<div class="judul"><?php if($stat=="tambah") { echo "Tambah"; } elseif($stat=="ubah") { echo "Ubah"; } ?> Kriteria</div>
<section class='form'>
  <form action="?h=kriteria-input&stat=<?php echo $stat; ?>" method="post" enctype="multipart/form-data" novalidate>
  	  <input type="hidden" name="stat_simpan" value="set">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <fieldset>
          <div class="item">
              <label>
                  <span>Nama Kriteria</span>
                  <input data-validate-length-range="5" data-validate-words="1" name="kriteria" value="<?php echo @$data['kriteria']; ?>" placeholder="" required/>
              </label>
              <div class='tooltip help'>
                  <span>?</span>
                  <div class='content'>
                      <b></b>
                      <p>Isi dengan nama kriteria</p>
                  </div>
              </div>
          </div>
          <div class="item">
              <label>
                  <span>Keterangan</span>
                  <textarea required name="keterangan" style="width:200px; height:50px;"><?php echo @$data['keterangan']; ?></textarea>
              </label>
          </div>
      </fieldset>
      <button id='send' type='submit' name="btn_simpan" class="tombol-large w_biru hvr-fade">Simpan Data</button>
      <button id='send' type='button' class="tombol-large w_orange hvr-fade" onclick="window.history.back();">Batal</button>
  </form>
</section>
