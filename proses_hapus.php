<?php
// panggil file config.php untuk koneksi ke database
require_once "config/config.php";
// jika tombol simpan diklik
if (isset($_GET['nip'])) {
    // ambil data get dari form 
    $nip = $_GET['nip'];

    // perintah query untuk menampilkan data foto pegawai berdasarkan nip
    $result = $mysqli->query("SELECT foto FROM pegawai WHERE nip='$nip'")
                              or die('Ada kesalahan pada query tampil data nip: '.$mysqli->error);
    $data = $result->fetch_assoc();
    $foto = $data['foto'];

    // hapus file foto dari folder foto
    $hapus_file = unlink("foto/$foto");
    // cek hapus file
    if ($hapus_file) {
        // jika file berhasil dihapus jalankan perintah query untuk menghapus data pada tabel pegawai
        $delete = $mysqli->query("DELETE FROM pegawai WHERE nip='$nip'")
                                  or die('Ada kesalahan pada query delete : '.$mysqli->error);
        // cek hasil query
        if ($delete) {
            // jika berhasil tampilkan pesan berhasil delete data
            header("location: index.php?alert=3");
        }
    }
}
// tutup koneksi
$mysqli->close();   
?>