<?php
session_start();
//error_reporting(0);
date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
$seminggu = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
$hari = date("w");
$hari_ini = $seminggu[$hari];

$kasus		="Seleksi Alternatif";
$kasus_objek="Alternatif";

$tgl_sekarang = date("Ymd");
$tgl_skrg     = date("d");
$bln_sekarang = date("m");
$thn_sekarang = date("Y");
$jam_sekarang = date("H:i:s");

$nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                    "Juni", "Juli", "Agustus", "September", 
                    "Oktober", "November", "Desember");
							
function antiinjec($connect, $string = '') {
  if(!empty($string)) {
      $stripsql = $connect->real_escape_string($string);
      return $stripsql;
  }
}
                  
$tgl_full=date("Y-m-d H:i:s");

$sesinf_adminid=1;

function tgl_waktu($data){
	$tgl_waktu=date("d-m-Y H:i:s", strtotime($data));
	return $tgl_waktu;
}
?>
