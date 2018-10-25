<!-- Aplikasi Pengolahan Data Pegawai dengan PHP 7, MySQLi, DataTables ServerSide, dan Bootstrap 4
***************************************************************************************************
* Developer    : Indra Styawantoro
* Company      : Indra Studio
* Release Date : Oktober 2018
* Update       : -
* Website      : www.indrasatya.com
* E-mail       : indra.setyawantoro@gmail.com
* Phone / WA   : +62-813-7778-3334
-->

<?php  
// panggil file config.php untuk koneksi ke database
require_once "config/config.php";
?>

<!doctype html>
<html lang="en">
  	<head>
	    <!-- Required meta tags -->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Aplikasi CRUD dengan PHP, MySQLi, Ajax, DataTables ServerSide, dan Bootstrap 4">
	    <meta name="keywords" content="Aplikasi CRUD dengan PHP, MySQLi, Ajax, DataTables ServerSide, dan Bootstrap 4">
	    <meta name="author" content="Indra Styawantoro">
		
		<!-- favicon -->
    	<link rel="shortcut icon" href="assets/img/favicon.png">
	    <!-- Bootstrap CSS -->
	    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	    <!-- DataTables CSS -->
	    <link rel="stylesheet" type="text/css" href="assets/plugins/DataTables/css/dataTables.bootstrap4.min.css">
        <!-- datepicker CSS -->
        <link rel="stylesheet" type="text/css" href="assets/plugins/datepicker/css/datepicker.min.css">
	    <!-- Font Awesome CSS -->
	    <link rel="stylesheet" type="text/css" href="assets/plugins/fontawesome-free-5.4.1-web/css/all.min.css">
	    <!-- Custom CSS -->
	    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
        <!-- Fungsi untuk membatasi karakter yang diinputkan -->
        <script type="text/javascript" src="assets/js/fungsi_validasi_karakter.js"></script>
        <!-- jQuery -->
        <script type="text/javascript" src="assets/js/jquery-3.3.1.js"></script>

	    <title>Data Pegawai</title>
  	</head>
  	<body>
  		<div class="container-fluid">
	    	<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
                <h5 class="my-0 mr-md-auto font-weight-normal text-info"><i class="fas fa-user title-icon"></i> Data Pegawai</h5>
            <?php  
            // fungsi untuk menampilkan menu sesuai dengan halaman
            // jika halaman = tampil data, maka tampilkan menu Tambah, Cetak, Export
            if (empty($_GET["page"])) { ?>
                <a class="btn btn-outline-info" href="?page=tambah" role="button"><i class="fas fa-plus"></i> Tambah</a> &nbsp; &nbsp;
                <a class="btn btn-outline-warning" href="cetak.php" target="_blank" role="button"><i class="fas fa-print"></i> Cetak</a> &nbsp; &nbsp;
                <a class="btn btn-outline-success" href="export.php" role="button"><i class="fas fa-file-excel"></i> Export</a>
            <?php
            } 
            // jika halaman = tambah atau ubah, maka tampilkan menu Kembali
            else { ?>
                <a class="btn btn-outline-info" href="index.php" role="button"><i class="fas fa-arrow-left"></i> Kembali</a>
            <?php
            } 
            ?>
				
			</div>
		</div>

		<div class="container-fluid">
		<?php
        // fungsi untuk menampilkan halaman
        // tampilkan halaman tampil data pada saat aplikasi pertama dijalankan
        if (empty($_GET["page"])) {
            include "tampil_data.php";
        } 
        // jika halaman = tambah, maka tampilkan halaman form tambah data
        elseif ($_GET['page']=='tambah') {
            include "form_tambah.php";
        } 
        // jika halaman = ubah, maka tampilkan halaman form ubah data
        elseif ($_GET['page']=='ubah') {
            include "form_ubah.php";
        } 
        ?>
		</div>
        
        <div class="container-fluid">
            <footer class="pt-4 my-md-4 pt-md-3 border-top">
                <div class="row">
                    <div class="col-12 col-md center">
                        &copy; 2018 - <a class="text-info" href="http://www.indrasatya.com/">www.indrasatya.com</a>
                    </div>
                </div>
            </footer>
        </div>

	    <!-- Optional JavaScript -->
	    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
	    <script type="text/javascript" src="assets/js/popper.min.js"></script>
	    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
        <!-- fontawesome js -->
	    <script type="text/javascript" src="assets/plugins/fontawesome-free-5.4.1-web/js/all.min.js"></script>
        <!-- DataTables js -->
	    <script type="text/javascript" src="assets/plugins/DataTables/js/jquery.dataTables.min.js"></script>
	    <script type="text/javascript" src="assets/plugins/DataTables/js/dataTables.bootstrap4.min.js"></script>
        <!-- datepicker js -->
        <script type="text/javascript" src="assets/plugins/datepicker/js/bootstrap-datepicker.min.js"></script>

        <script type="text/javascript">
        $(document).ready(function() {
            // datepicker plugin
            $('.date-picker').datepicker({
                autoclose: true,
                todayHighlight: true
            });
        } );

        // Validasi Form
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        // validasi image dan preview image sebelum upload
        function validasiFile() {
            var fileInput         = document.getElementById('foto');
            var filePath          = fileInput.value;
            var fileSize          = $('#foto')[0].files[0].size;
            // tentukan extension yang diperbolehkan
            var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
            // Jika tipe file yang diupload tidak sesuai dengan allowedExtensions, tampilkan pesan :
            if (!allowedExtensions.exec(filePath)) {
                alert('Tipe file foto tidak sesuai. Harap unggah file foto yang memiliki tipe *.jpg atau *.png');
                fileInput.value = '';
                document.getElementById('imagePreview').innerHTML = '<img class="foto-preview" src="foto/default_user.png"/>';
                return false;
            } 
            // jika ukuran file yang diupload lebih dari sama dengan 1 Mb
            else if (fileSize >= 1000000) {
                alert('Ukuran file foto lebih dari 1 Mb. Harap unggah file foto yang memiliki ukuran maksimal 1 Mb.');
                fileInput.value = '';
                document.getElementById('imagePreview').innerHTML = '<img class="foto-preview" src="foto/default_user.png"/>';
                return false;
            }
            // selain itu
            else {
                // Image preview
                if (fileInput.files && fileInput.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                    document.getElementById('imagePreview').innerHTML = '<img class="foto-preview" src="'+e.target.result+'"/>';
                };
            reader.readAsDataURL(fileInput.files[0]);
            }
        }}
        </script>
  	</body>
</html>
