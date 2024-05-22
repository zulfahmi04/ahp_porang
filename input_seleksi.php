<?php
$stat	= @$_GET['stat'];
$id		= antiinjec($koneksi, @$_GET['id']);
if($stat=="tambah") {
	$tl=date('Y-m-d', strtotime("-15 years"));
}elseif($stat=="ubah") {
	$hdata=$koneksi->query("SELECT id_seleksi, seleksi, tahun, catatan FROM ahp_seleksi WHERE id_seleksi='$id'");
	$data=mysqli_fetch_array($hdata);
}
if(@$_POST['stat_simpan']) {
	
	$id				= antiinjec($koneksi, @$_POST['id']);
	$tahun			= antiinjec($koneksi, @$_POST['tahun']);
	$seleksi		= antiinjec($koneksi, @$_POST['seleksi']);
	$catatan		= antiinjec($koneksi, @$_POST['catatan']);
	
	if($stat=="tambah") {
		$d_cek=mysqli_fetch_array($koneksi->query("SELECT count(*) FROM ahp_seleksi WHERE seleksi='$seleksi' AND tahun='$tahun'"));
		if($d_cek[0]==0) {
			$koneksi->query("INSERT INTO ahp_seleksi(seleksi, catatan, tahun)
					 VALUES ('$seleksi', '$catatan', '$tahun')");
			?>
			<script language="JavaScript">document.location='?h=seleksi&con=1'</script>
			<?php
		} else {
			//echo "<div class='warning'>Periode [$seleksi] sudah ada. </div>";
			?>
			<script language="JavaScript">alert('Periode [<?php echo $tahun."-".$seleksi; ?>] sudah ada.'); history.go(-1); </script>
			<?php
		}
	} elseif($stat=="ubah") {
		$d_cek=mysqli_fetch_array($koneksi->query("SELECT count(*) FROM ahp_seleksi WHERE seleksi='$seleksi' AND tahun='$tahun' AND id_seleksi<>'$id'"));
		echo $seleksi;
		if($d_cek[0]==0) {
			$koneksi->query("UPDATE ahp_seleksi SET seleksi='$seleksi', catatan='$catatan', tahun='$tahun' WHERE id_seleksi='$id'");
			?>
			<script language="JavaScript">document.location='?h=seleksi&con=2'</script>
			<?php
		} else {
			//echo "<div class='warning'>Periode [$seleksi] sudah ada. </div>";
			?>
			<script language="JavaScript">alert('Periode [<?php echo $tahun."-".$seleksi; ?>] sudah ada.'); history.go(-1); </script>
			<?php
		}
	}
} elseif($stat=="hapus" && $id!="") {
	$koneksi->query("DELETE FROM ahp_seleksi WHERE id_seleksi='$id'");
	?>
	<script language="JavaScript">document.location='?h=seleksi&con=3'</script>
	<?php
}
?>
<div class="judul"><?php if($stat=="tambah") { echo "Tambah"; } elseif($stat=="ubah") { echo "Ubah"; } ?> Seleksi</div>
<section class='form'>
  <form action="?h=seleksi-input&stat=<?php echo $stat; ?>" method="post" enctype="multipart/form-data" novalidate>
  	  <input type="hidden" name="stat_simpan" value="set">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <fieldset>
          <div class="item">
              <label>
                  <span>Nama Seleksi</span>
                  <input type="text" data-validate-length-range="5" data-validate-words="1" name="seleksi" value="<?php echo @$data['seleksi']; ?>" placeholder="" required/>
              </label>
              <div class='tooltip help'>
                  <span>?</span>
                  <div class='content'>
                      <b></b>
                      <p>Isi dengan nama seleksi (untuk seleksi)</p>
                  </div>
              </div>
          </div>
          <div class="item">
              <label>
                  <span>Tahun Seleksi</span>
                  <input type="number" maxlength="4" name="tahun" data-validate-minmax="2015,9999" value="<?php echo @$data['tahun']; ?>" required style="width:60px;"/>
              </label>
              <div class='tooltip help'>
                  <span>?</span>
                  <div class='content'>
                      <b></b>
                      <p>Isi dengan tahun seleksi (Misal = <?= date("Y") ?>).</p>
                  </div>
              </div>
          </div>
          <div class="item">
              <label>
                  <span>Catatan</span>
                  <textarea required name="catatan" style="width:200px; height:50px;"><?php echo @$data['catatan']; ?></textarea>
              </label>
          </div>
      </fieldset>
      <button id='send' type='submit' name="btn_simpan" class="tombol-large w_biru hvr-fade">Simpan Data</button>
      <button id='send' type='button' class="tombol-large w_orange hvr-fade" onclick="window.history.back();">Batal</button>
  </form>
</section>
