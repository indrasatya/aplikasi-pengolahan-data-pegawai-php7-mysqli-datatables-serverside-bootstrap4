<?php
ob_start();
// panggil file config.php untuk koneksi ke database
require_once "config/config.php";
// panggil fungsi untuk format tanggal
include "config/fungsi_tanggal.php";
?>

<!-- Bagian halaman HTML yang akan konvert -->
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Data Pegawai</title>
        <!-- Custom CSS -->
        <link rel="stylesheet" type="text/css" href="assets/css/laporan.css" />
    </head>
    <body>
        <div id="title">
            DATA PEGAWAI 
        </div>
        <br>
        <table width="100%" border="0.3" cellpadding="0" cellspacing="0">
            <thead style="background:#e8ecee">
                <tr class="tr-title">
                    <th height="30" align="center" valign="middle">No.</th>
                    <th height="30" align="center" valign="middle">Foto</th>
                    <th height="30" align="center" valign="middle">NIP</th>
                    <th height="30" align="center" valign="middle">Nama Pegawai</th>
                    <th height="30" align="center" valign="middle">Tempat, Tanggal Lahir</th>
                    <th height="30" align="center" valign="middle">Jenis Kelamin</th>
                    <th height="30" align="center" valign="middle">Agama</th>
                    <th height="30" align="center" valign="middle">Alamat</th>
                    <th height="30" align="center" valign="middle">No. Hp</th>
                </tr>
            </thead>
            <tbody>
            <?php  
            $no = 1;
            // fungsi query untuk menampilkan data dari tabel pegawai
            $result = $mysqli->query("SELECT * FROM pegawai ORDER BY nama_pegawai ASC")
                                      or die('Ada kesalahan pada query tampil data pegawai: '.$mysqli->error);
            $rows = $result->num_rows;
            // jika data ada, tampilkan data
            if ($rows > 0) {
                while ($data = $result->fetch_assoc()) { ?>
                    <tr>
                        <td width="40" height="25" align="center" valign="middle"><?php echo $no; ?></td>
                        <td style="padding:3.7px 3px;" width="45" height="25" align="center" valign="middle"><img class="foto-thumbnail" src="foto/<?php echo $data['foto']; ?>" alt="Foto Pegawai"></td>
                        <td width="150" height="25" align="center" valign="middle"><?php echo $data['nip']; ?></td>
                        <td style="padding-left:5px;" width="180" height="25" valign="middle"><?php echo $data["nama_pegawai"]; ?></td>
                        <td style="padding-left:5px;" width="150" height="25" valign="middle"><?php echo $data["tempat_lahir"]; ?>, <?php echo date('d-m-Y', strtotime($data['tanggal_lahir'])); ?></td>
                        <td width="90" height="25" align="center" valign="middle"><?php echo $data["jenis_kelamin"]; ?></td>
                        <td width="120" height="25" align="center" valign="middle"><?php echo $data["agama"]; ?></td>
                        <td style="padding-left:5px;" width="220" height="25" valign="middle"><?php echo $data["alamat"]; ?></td>
                        <td width="100" height="25" align="center" valign="middle"><?php echo $data["no_hp"]; ?></td>
                    </tr>
                 <?php
                    $no++;
                } 
            // jika data tidak ada, tampilkan tabel kosong
            } else { ?>
                <tr>
                    <td width="40" height="25" align="center" valign="middle"></td>
                    <td style="padding:3.7px 3px;" width="45" height="25" align="center" valign="middle"></td>
                    <td width="150" height="25" align="center" valign="middle"></td>
                    <td style="padding-left:5px;" width="180" height="25" valign="middle"></td>
                    <td style="padding-left:5px;" width="150" height="25" valign="middle"></td>
                    <td width="90" height="25" align="center" valign="middle"></td>
                    <td width="120" height="25" align="center" valign="middle"></td>
                    <td style="padding-left:5px;" width="220" height="25" valign="middle"></td>
                    <td width="100" height="25" align="center" valign="middle"></td>
                </tr>
            <?php
            } ?>
            </tbody>
        </table>

        <div id="footer-tanggal">
            Bandarlampung, <?php echo tgl_eng_to_ind(date("d-m-Y")); ?>
        </div>
        <div id="footer-titik">
            ..........................................................
        </div>
    </body>
</html>
<!-- Akhir halaman HTML yang akan di konvert -->

<?php
$filename="Data Pegawai.pdf"; // nama file pdf yang dihasilkan nantinya
//==========================================================================================================
$content = ob_get_clean();
$content = '<page style="font-family: freeserif">'.($content).'</page>';
// panggil library html2pdf
require_once('assets/plugins/html2pdf_v4.03/html2pdf.class.php');
try
{
    $html2pdf = new HTML2PDF('L','Folio','en', false, 'ISO-8859-15',array(10, 10, 10, 10));
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output($filename);
}
catch(HTML2PDF_exception $e) { echo $e; }
?>