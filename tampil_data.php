    <div class="row">
        <div class="col-md-12">
        <?php
        // fungsi untuk menampilkan pesan
        // jika alert = "" (kosong)
        // tampilkan pesan "" (kosong)
        if (empty($_GET['alert'])) {
            echo "";
        }
        // jika alert = 1
        // tampilkan pesan Sukses "Data pegawai berhasil disimpan"
        elseif ($_GET['alert'] == 1) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-check-circle"></i> Sukses!</strong> Data pegawai berhasil disimpan.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php
        } 
        // jika alert = 2
        // tampilkan pesan Sukses "Data pegawai berhasil diubah"
        elseif ($_GET['alert'] == 2) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-check-circle"></i> Sukses!</strong> Data pegawai berhasil diubah.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php
        } 
        // jika alert = 3
        // tampilkan pesan Sukses "Data pegawai berhasil dihapus"
        elseif ($_GET['alert'] == 3) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-check-circle"></i> Sukses!</strong> Data pegawai berhasil dihapus.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php
        } 
        // jika alert = 4
        // tampilkan pesan Gagal "NIP sudah ada"
        elseif ($_GET['alert'] == 4) { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-times-circle"></i> Gagal!</strong> NIP <b><?php echo $_GET['nip']; ?></b> sudah ada.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php
        }
        ?>
            
            <!-- Tabel Pegawai untuk menampilkan data pegawai dari database -->
            <table id="tabel-pegawai" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Foto</th>
                        <th>NIP</th>
                        <th>Nama Pegawai</th>
                        <th>Tempat, Tanggal Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>L/P</th>
                        <th>Agama</th>
                        <th>Alamat</th>
                        <th>No. HP</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- datatables serverside processing -->
    <script type="text/javascript">
    $(document).ready(function() {
        // initiate dataTables plugin
        $.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings)
        {
            return {
                "iStart": oSettings._iDisplayStart,
                "iEnd": oSettings.fnDisplayEnd(),
                "iLength": oSettings._iDisplayLength,
                "iTotal": oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            };
        };

        var table = $('#tabel-pegawai').DataTable( {
            "bAutoWidth": false,
            "scrollY": '58vh',
            "scrollCollapse": true,
            "processing": true,
            "serverSide": true,
            "ajax": 'data_pegawai.php',     // panggil file data_pegawai.php untuk menampilkan data pegawai dari database
            "columnDefs": [ 
                { "targets": 0, "data": null, "orderable": false, "searchable": false, "width": '30px', "className": 'center' },
                { "targets": 1, "data": null, "orderable": false, "searchable": false, "width": '45px', "className": 'center',
                  "render": function(data, type, row) {
                      var foto = "<img class=\"foto-thumbnail\" src=\"foto/"+data[ 1 ]+"\" alt=\"Foto Pegawai\">";
                      return foto;
                  } 
                },
                { "targets": 2, "width": '100px', "className": 'center' },
                { "targets": 3, "width": '170px' },
                {   "targets": 4, "width": '190px',
                    "render": function ( data, type, row ) {
                        return data +', '+ row[ 5 ];
                    }
                },
                { "targets": 5, "visible": false },
                { "targets": 6, "width": '30px', "className": 'center' },
                { "targets": 7, "width": '70px', "className": 'center' },
                { "targets": 8, "width": '180px' },
                { "targets": 9, "width": '80px', "className": 'center' },
                {
                  "targets": 10, "data": null, "orderable": false, "searchable": false, "width": '80px', "className": 'center',
                  "render": function(data, type, row) {
                      var btn = "<a style=\"margin-right:7px\" title=\"Ubah\" class=\"btn btn-outline-info btn-sm\" href=\"?page=ubah&nip="+data[ 10 ]+"\"><i class=\"fas fa-edit\"></i></a><span><a title=\"Hapus\" class=\"btn btn-outline-danger btn-sm\" href=\"proses_hapus.php?nip="+data[ 10 ]+"\"><i class=\"fas fa-trash\"></i></a></span>";
                      return btn;
                  } 
                } 
            ],
            "order": [[ 3, "asc" ]],        // urutkan data berdasarkan nama pegawai secara ascending
            "iDisplayLength": 10,           // tampilkan 10 data
            "rowCallback": function (row, data, iDisplayIndex) {
                var info   = this.fnPagingInfo();
                var page   = info.iPage;
                var length = info.iLength;
                var index  = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        } );

        // tampilkan notifikasi saat akan menghapus data
        $('#tabel-pegawai tbody').on( 'click', 'span', function () {
            var data = table.row( $(this).parents('tr') ).data();
            return confirm("Anda yakin ingin menghapus pegawai "+ data[ 3 ] +" ?" );
        } );
    } );
    </script>