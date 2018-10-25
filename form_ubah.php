	<?php
    if (isset($_GET['nip'])) {
    	// ambil data get dari form
        $nip = $_GET['nip'];
        // fungsi query untuk menampilkan data dari tabel pegawai berdasarkan nip
        $result = $mysqli->query("SELECT * FROM pegawai WHERE nip='$nip'") or die('Query Error: '.$mysqli->error);
        $data = $result->fetch_assoc();
    	// buat variabel untuk menampung data
		$nip           = $data['nip'];
		$nama_pegawai  = $data['nama_pegawai'];
		$tempat_lahir  = $data['tempat_lahir'];
		$tanggal_lahir = date('d-m-Y', strtotime($data['tanggal_lahir']));
		$jenis_kelamin = $data['jenis_kelamin'];
		$agama         = $data['agama'];
		$alamat        = $data['alamat'];
		$no_hp         = $data['no_hp'];
		$foto          = $data['foto'];
		// tutup koneksi
        $mysqli->close(); 
    }
    ?>

	<div class="row">
        <div class="col-md-12">
			<div class="alert alert-info" role="alert">
  				<i class="fas fa-edit"></i> Ubah Data Pegawai
			</div>

			<div class="card">
			  	<div class="card-body">
			    	<form class="needs-validation" action="proses_ubah.php" method="post" enctype="multipart/form-data" novalidate>
					  	<div class="row">
					    	<div class="col">
					      		<div class="form-group col-md-12">
									<label>NIP</label>
									<input type="text" class="form-control" name="nip" maxlength="18" onKeyPress="return goodchars(event,'0123456789',this)" autocomplete="off" value="<?php echo $nip; ?>" readonly required>
									<div class="invalid-feedback">NIP tidak boleh kosong.</div>
								</div>

								<div class="form-group col-md-12">
									<label>Tempat Lahir</label>
									<input type="text" class="form-control" name="tempat_lahir" autocomplete="off" value="<?php echo $tempat_lahir; ?>" required>
									<div class="invalid-feedback">Tempat Lahir tidak boleh kosong.</div>
								</div>

								<div class="form-group col-md-12">
									<label class="mb-3">Jenis Kelamin</label>
								<?php
              					if ($jenis_kelamin=='Laki-laki') { ?>
									<div class="custom-control custom-radio">
									    <input type="radio" class="custom-control-input" id="customControlValidation2" name="jenis_kelamin" value="Laki-laki" checked required>
									    <label class="custom-control-label" for="customControlValidation2">Laki-laki</label>
									</div>
									<div class="custom-control custom-radio mb-4">
									    <input type="radio" class="custom-control-input" id="customControlValidation3" name="jenis_kelamin" value="Perempuan" required>
									    <label class="custom-control-label" for="customControlValidation3">Perempuan</label>
									    <div class="invalid-feedback">Pilih salah satu jenis kelamin.</div>
									</div>
								 <?php
              					} else { ?>
									<div class="custom-control custom-radio">
									    <input type="radio" class="custom-control-input" id="customControlValidation2" name="jenis_kelamin" value="Laki-laki" required>
									    <label class="custom-control-label" for="customControlValidation2">Laki-laki</label>
									</div>
									<div class="custom-control custom-radio mb-4">
									    <input type="radio" class="custom-control-input" id="customControlValidation3" name="jenis_kelamin" value="Perempuan" checked required>
									    <label class="custom-control-label" for="customControlValidation3">Perempuan</label>
									    <div class="invalid-feedback">Pilih salah satu jenis kelamin.</div>
									</div>
              					<?php } ?>
								</div>
								
					      		<div class="form-group col-md-12">
									<label>Agama</label>
									<select class="form-control" name="agama" autocomplete="off" required>
								      	<option value="<?php echo $agama; ?>"><?php echo $agama; ?></option>
										<option value="Islam">Islam</option>
										<option value="Kristen Protestan">Kristen Protestan</option>
										<option value="Kristen Katolik">Kristen Katolik</option>
										<option value="Hindu">Hindu</option>
										<option value="Buddha">Buddha</option>
								    </select>
									<div class="invalid-feedback">Agama tidak boleh kosong.</div>
								</div>
					    	</div>

					    	<div class="col">
								<div class="form-group col-md-12">
									<label>Nama Pegawai</label>
									<input type="text" class="form-control" name="nama_pegawai" autocomplete="off" value="<?php echo $nama_pegawai; ?>" required>
									<div class="invalid-feedback">Nama Pegawai tidak boleh kosong.</div>
								</div>

								<div class="form-group col-md-12">
									<label>Tanggal Lahir</label>
									<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="tanggal_lahir" autocomplete="off" value="<?php echo $tanggal_lahir; ?>" required>
									<div class="invalid-feedback">Tanggal Lahir tidak boleh kosong.</div>
								</div>

								<div class="form-group col-md-12">
									<label>Alamat</label>
									<textarea class="form-control" rows="2" name="alamat" autocomplete="off" required><?php echo $alamat; ?></textarea>
									<div class="invalid-feedback">Alamat tidak boleh kosong.</div>
								</div>

								<div class="form-group col-md-12">
									<label>No. HP</label>
									<input type="text" class="form-control" name="no_hp" maxlength="13" onKeyPress="return goodchars(event,'0123456789',this)" autocomplete="off" value="<?php echo $no_hp; ?>" required>
									<div class="invalid-feedback">No. HP tidak boleh kosong.</div>
								</div>
					    	</div>

					    	<div class="col">
					    		<div class="form-group col-md-12">
									<label>Foto Pegawai</label>
    								<input type="file" class="form-control-file mb-3" id="foto" name="foto" onchange="return validasiFile()" autocomplete="off" value="<?php echo $foto; ?>">
									<div id="imagePreview"><img class="foto-preview" src="foto/<?php echo $foto; ?>"/></div>
								</div>
					    	</div>
					  	</div>

					  	<div class="my-md-4 pt-md-1 border-top"> </div>

						<div class="form-group col-md-5">
			                <input type="submit" class="btn btn-info btn-submit" name="simpan" value="Simpan">
				  		</div>
					</form>
			  	</div>
			</div>
        </div>
	</div>

