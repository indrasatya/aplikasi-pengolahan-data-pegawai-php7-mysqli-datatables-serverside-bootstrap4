<?php
// panggil file config.php untuk koneksi ke database
require_once "config/config.php";
// jika tombol simpan diklik
if (isset($_POST['simpan'])) {
    // ambil data hasil submit dari form
    $nip                = $mysqli->real_escape_string(trim($_POST['nip']));
    $nama_pegawai       = $mysqli->real_escape_string(trim($_POST['nama_pegawai']));
    $tempat_lahir       = $mysqli->real_escape_string(trim($_POST['tempat_lahir']));
    $tanggal_lahir      = $mysqli->real_escape_string(trim(date('Y-m-d', strtotime($_POST['tanggal_lahir']))));
    $jenis_kelamin      = $mysqli->real_escape_string(trim($_POST['jenis_kelamin']));
    $agama              = $mysqli->real_escape_string(trim($_POST['agama']));
    $alamat             = $mysqli->real_escape_string(trim($_POST['alamat']));
    $no_hp              = $mysqli->real_escape_string(trim($_POST['no_hp']));
    $nama_file          = $_FILES['foto']['name'];
    $tmp_file           = $_FILES['foto']['tmp_name'];
    // Set path folder tempat menyimpan filenya
    $path               = "foto/".$nama_file;

    // perintah query untuk mengecek nip
    $result = $mysqli->query("SELECT nip FROM pegawai WHERE nip='$nip'")
                              or die('Ada kesalahan pada query tampil data nip: '.$mysqli->error);
    $rows = $result->num_rows;
    // jika nip sudah ada
    if ($rows > 0) {
        // tampilkan pesan gagal simpan data
        header("location: index.php?alert=4&nip=$nip");
    }
    // jika nip belum ada
    else {  
        // upload file
        if(move_uploaded_file($tmp_file, $path)) {
            // Jika file berhasil diupload, Lakukan : 
            // perintah query untuk menyimpan data ke tabel pegawai
            $insert = $mysqli->query("INSERT INTO pegawai(nip,nama_pegawai,tempat_lahir,tanggal_lahir,jenis_kelamin,agama,alamat,no_hp,foto)
                                      VALUES('$nip','$nama_pegawai','$tempat_lahir','$tanggal_lahir','$jenis_kelamin','$agama','$alamat','$no_hp','$nama_file')")
                                      or die('Ada kesalahan pada query insert : '.$mysqli->error); 
            // cek query
            if ($insert) {
                // jika berhasil tampilkan pesan berhasil simpan data
                header("location: index.php?alert=1");
            }   
        }
    }
}
// tutup koneksi
$mysqli->close();   
?>