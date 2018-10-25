<?php
// panggil file config.php untuk koneksi ke database
require_once "config/config.php";
// jika tombol simpan diklik
if (isset($_POST['simpan'])) {
    if (isset($_POST['nip'])) {
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

        // jika foto tidak diubah
        if (empty($nama_file)) {
            // perintah query untuk mengubah data pada tabel pegawai
            $update = $mysqli->query("UPDATE pegawai SET nama_pegawai   = '$nama_pegawai',
                                                         tempat_lahir   = '$tempat_lahir',
                                                         tanggal_lahir  = '$tanggal_lahir',
                                                         jenis_kelamin  = '$jenis_kelamin',
                                                         agama          = '$agama',
                                                         alamat         = '$alamat',
                                                         no_hp          = '$no_hp'
                                                   WHERE nip            = '$nip'")
                                      or die('Ada kesalahan pada query update : '.$mysqli->error);
            // cek query
            if ($update) {
                // jika berhasil tampilkan pesan berhasil ubah data
                header("location: index.php?alert=2");
            }
        }
        // jika foto diubah
        else {
            // upload file
            if(move_uploaded_file($tmp_file, $path)) {
                // Jika file berhasil diupload, Lakukan : 
                // perintah query untuk mengubah data pada tabel pegawai
                $update = $mysqli->query("UPDATE pegawai SET nama_pegawai   = '$nama_pegawai',
                                                             tempat_lahir   = '$tempat_lahir',
                                                             tanggal_lahir  = '$tanggal_lahir',
                                                             jenis_kelamin  = '$jenis_kelamin',
                                                             agama          = '$agama',
                                                             alamat         = '$alamat',
                                                             no_hp          = '$no_hp',
                                                             foto           = '$nama_file'
                                                       WHERE nip            = '$nip'")
                                          or die('Ada kesalahan pada query update : '.$mysqli->error);
                // cek query
                if ($update) {
                    // jika berhasil tampilkan pesan berhasil ubah data
                    header("location: index.php?alert=2");
                }   
            }
        }
    }
}
// tutup koneksi
$mysqli->close();   
?>