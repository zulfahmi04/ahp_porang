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
	
	$id				= $usernama;
	$password_lama	= md5($_POST['password_lama']);
	$password		= md5($_POST['password']);
	$password2		= md5($_POST['password2']);
	
	if($stat=="ubah") {
		$hquery=$koneksi->query("SELECT password FROM ahp_pengguna WHERE username='$usernama'");
		$userdata=mysqli_fetch_array($hquery);

		if ($password_lama<>$userdata['password'])
		{ ?>
			<script language="JavaScript">alert('Password lama salah.');
			document.location='?h=password'</script>
		<?php }
		else
		{
			if (($password<>$password2) or ($password=="") or ($password2==""))
			{ ?>
				<script language="JavaScript">alert('Pasword baru dan password baru ulangi tidak sama (tidak boleh kosong)');
				document.location='?h=password'</script>
			<?php }
			else
			{
				
				$query="UPDATE ahp_pengguna SET password='$password' WHERE username='$usernama'";
				$koneksi->query($query);
				
				?>
				<script language="JavaScript">alert('Perubahan berhasil disimpan. Sistem logout.');
				document.location='logout.php'</script>
				<?php
			}
		}
	}
}
?>
<div class="judul">Ubah Password</div>
<section class='form'>
  <form action="?h=password&stat=ubah" method="post" enctype="multipart/form-data" novalidate>
  	  <input type="hidden" name="stat_simpan" value="set">
      <fieldset>
          <div class="item">
              <label>
                  <span>Password Lama</span>
                  <input type="password" name="password_lama" value="" <?php if($stat=="ubah") { echo "placeholder='Tulis ulang'"; } ?> data-validate-length-range="6,10" required='required'>
              </label>
              <div class='tooltip help'>
                  <span>?</span>
                  <div class='content'>
                      <b></b>
                      <p>Minimum 6 karakter dan maksimum 10 karakter (Password lama adalah password yang Anda gunakan sekarang)</p>
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
