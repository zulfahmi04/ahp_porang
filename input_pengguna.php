<?php
$stat	= @$_GET['stat'];
$id		= antiinjec($koneksi, @$_GET['id']);
if($stat=="tambah") {
	$tl=date('Y-m-d', strtotime("-15 years"));
}elseif($stat=="ubah") {
	$hdata=$koneksi->query("SELECT id_pengguna, nama, no_telp, username, password, tipe FROM ahp_pengguna WHERE id_pengguna='$id'");
	$data=mysqli_fetch_array($hdata);
}
if(@$_POST['stat_simpan']) {
	
	$id				= antiinjec($koneksi, @$_POST['id']);
	$nama			= antiinjec($koneksi, @$_POST['nama']);
	$no_telp		= antiinjec($koneksi, @$_POST['no_telp']);
	$username		= antiinjec($koneksi, @$_POST['username']);
	$password		= antiinjec($koneksi, @$_POST['password']);
	$password		= md5($password);
	$tipe			= antiinjec($koneksi, @$_POST['tipe']);
	
	if($stat=="tambah") {
		$d_cek=mysqli_fetch_array($koneksi->query("SELECT count(*) FROM ahp_pengguna WHERE username='$username'"));
		if($d_cek[0]==0) {
			$koneksi->query("INSERT INTO ahp_pengguna(nama, no_telp, username, password, tipe)
					 VALUES ('$nama', '$no_telp', '$username', '$password', '$tipe')");
			?>
			<script language="JavaScript">document.location='?h=pengguna&con=1'</script>
			<?php
		} else {
			//echo "<div class='warning'>Periode [$pengguna] sudah ada. </div>";
			?>
			<script language="JavaScript">alert('Pengguna [<?php echo $username; ?>] sudah ada.'); history.go(-1); </script>
			<?php
		}
	} elseif($stat=="ubah") {
		$d_cek=mysqli_fetch_array($koneksi->query("SELECT count(*) FROM ahp_pengguna WHERE username='$username' AND id_pengguna<>'$id'"));
		echo $pengguna;
		if($d_cek[0]==0) {
			$koneksi->query("UPDATE ahp_pengguna SET nama='$nama', no_telp='$no_telp', username='$username', password='$password', tipe='$tipe' WHERE id_pengguna='$id'");
			?>
			<script language="JavaScript">document.location='?h=pengguna&con=2'</script>
			<?php
		} else {
			//echo "<div class='warning'>Periode [$pengguna] sudah ada. </div>";
			?>
			<script language="JavaScript">alert('Periode [<?php echo $tahun."-".$pengguna; ?>] sudah ada.'); history.go(-1); </script>
			<?php
		}
	}
} elseif($stat=="hapus" && $id!="") {
	$koneksi->query("DELETE FROM ahp_pengguna WHERE id_pengguna='$id'");
	?>
	<script language="JavaScript">document.location='?h=pengguna&con=3'</script>
	<?php
}
?>
<div class="judul"><?php if($stat=="tambah") { echo "Tambah"; } elseif($stat=="ubah") { echo "Ubah"; } ?> Pengguna</div>
<section class='form'>
  <form action="?h=pengguna-input&stat=<?php echo $stat; ?>" method="post" enctype="multipart/form-data" novalidate>
  	  <input type="hidden" name="stat_simpan" value="set">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <fieldset>
          <div class="item">
              <label>
                  <span>Nama Lengkap</span>
                  <input data-validate-length-range="3" data-validate-words="1" name="nama" value="<?php echo @$data['nama']; ?>" placeholder="" required type="text"/>
              </label>
              <div class='tooltip help'>
                  <span>?</span>
                  <div class='content'>
                      <b></b>
                      <p>Nama lengkap, tidak boleh disingkat</p>
                  </div>
              </div>
          </div>
          <div class="item" style="clear:both;">
              <label>
                  <span>Nomor Telepon/HP</span>
				  <input type="tel" class="tel" name="no_telp" value="<?php echo @$data['no_telp']; ?>" data-validate-length-range="10,15" required/>
              </label>
              <div class='tooltip help'>
                  <span>?</span>
                  <div class='content'>
                      <b></b>
                      <p>Nomor telepon minimal 10 digit, maksimal 15 digit.</p>
                  </div>
              </div>
          </div>
          <div class="item">
              <label>
                  <span>Hak Akses</span>
                  <select class="required" name="tipe" style="width:210px;">
                      <option value="">-- pilih --</option>
                      <option value="1" <?php if(@$data['tipe']==1) { echo "selected"; } ?>>Normal</option>
                      <option value="2" <?php if(@$data['tipe']==2) { echo "selected"; } ?>>Administrator</option>
                  </select>
              </label>
          </div>
          <div class="item">
              <label>
                  <span>Username</span>
                  <input data-validate-length-range="5,15" <?php if($stat=="ubah") { echo "readonly='readonly'"; } ?> name="username" value="<?php echo @$data['username']; ?>" placeholder="" required type="text"/>
              </label>
              <div class='tooltip help'>
                  <span>?</span>
                  <div class='content'>
                      <b></b>
                      <p>Username 5 s/d 15 karakter</p>
                  </div>
              </div>
          </div>          
          <div class="item">
              <label>
                  <span>Password</span>
                  <input type="password" name="password" value="" <?php if($stat=="ubah") { echo "placeholder='Tulis ulang'"; } ?> data-validate-length-range="6,10" required='required'>
              </label>
              <div class='tooltip help'>
                  <span>?</span>
                  <div class='content'>
                      <b></b>
                      <p>Minimum 6 karakter dan maksimum 10 karakter.</p>
                  </div>
              </div>
          </div>
          <div class="item">
              <label>
                  <span>Ulangi password</span>
                  <input type="password" name="password2" value="" <?php if($stat=="ubah") { echo "placeholder='Tulis ulang'"; } ?> data-validate-linked='password' required='required'>
              </label>
          </div>
      </fieldset>
      <button id='send' type='submit' name="btn_simpan" class="tombol-large w_biru hvr-fade">Simpan Data</button>
      <button id='send' type='button' class="tombol-large w_orange hvr-fade" onclick="window.history.back();">Batal</button>
  </form>
</section>
