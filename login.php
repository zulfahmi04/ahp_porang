<?php
include "config/library.php";
include "config/koneksi.php";

$h=antiinjec($koneksi, @$_GET['h']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LOGIN | SPK Metode AHP - Analityc Hierarchy Process</title>
<link href="css/font.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/style_login.css">

</head>

<body>
	<div id="paling_atas">Sistem Pendukung Keputusan Metode AHP</div>
	<div id="atas">
    </div>
    
    <div id="wrap">
      <div id="regbar">
        <div id="navthing">
         <div id="dalam">
          <h2><a href="#" id="loginform">Login Sistem</a></h2>
            <div class="login">
              <div class="arrow-up"></div>
              <div class="formholder">
                <div class="randompad">
                <form name="login" action="login.php" method="post" enctype="multipart/form-data">
                   <fieldset>
                     <label name="email">Username</label>
                     <input type="text" name="username" />
                     <label name="password">Password</label>
                     <input type="password" name="password" />
                     <input type="submit" value="Login" name="btn_login"/>
                   </fieldset>
                </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div id="content_nya">
		<?php
		  if(@$_POST['btn_login']) {
            $username=antiinjec($koneksi, @$_POST['username']);
            $password=md5(@$_POST['password']);
            
            $query="SELECT id_pengguna, nama, no_telp, username, password, tipe FROM ahp_pengguna WHERE username='$username' AND password='$password'";
            echo $query;
			      $hasil=$koneksi->query($query);
            $userjum=$hasil->fetch_array();
            if ($userjum['username']<>"") {
                $_SESSION['sesNamaPengguna']=$userjum['username'];
                $_SESSION['sesTipePengguna']=$userjum['tipe'];
            ?>
                <script language="JavaScript">document.location='./'</script>
            <?php
            } else {
                echo "<div class='warning'>Username atau Password yang Anda masukkan salah/tidak cocok.</div>";
            }
		  }
        ?>
    	<h3>Sistem Pendukung Keputusan <?php echo $kasus; ?> Metode AHP</h3>
        Sistem ini membantu pengambil keputusan dalam menyeleksi <?php echo $kasus_objek; ?> dengan membandingkan setiap <?php echo $kasus_objek; ?> pada setiap kriteria, 
        metode yang digunakan adalah AHP (<i>Analityc Hierarchy Process</i>).<br /><br />
        Untuk dapat masuk ke sistem Anda harus login terlebih dahulu, klik tulisan <b>LOGIN SISTEM</b> di atas.
        Untuk login gunakan username <span style="color:#F60; font-weight:bold;">"admin"</span> dan password <span style="color:#F60; font-weight:bold;">"1234567"</span>
    </div>
    
<script src='js/jquery_login.js'></script>
<script>
	$('input[type="submit"]').mousedown(function(){
	  $(this).css('background', '#2ecc71');
	});
	$('input[type="submit"]').mouseup(function(){
	  $(this).css('background', '#1abc9c');
	});
	
	$('#loginform').click(function(){
	  $('.login').fadeToggle('slow');
	  $(this).toggleClass('green');
	});
	
	$(document).mouseup(function (e)
	{
		var container = $(".login");
	
		if (!container.is(e.target) // if the target of the click isn't the container...
			&& container.has(e.target).length === 0) // ... nor a descendant of the container
		{
			container.hide();
			$('#loginform').removeClass('green');
		}
	});
</script>

</body>
</html>