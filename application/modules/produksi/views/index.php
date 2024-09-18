<!doctype html>
<html lang="en" class="fixed">

<head>
    <?php echo $this->Templates->Header(); ?>
    <style type="text/css">
        body {
            font-family: helvetica;
        }

        .tab-pane {
            padding-top: 20px;
        }

        .select2-container--default .select2-results__option[aria-disabled=true] {
            display: none;
        }
    </style>
</head>
<body>
    <div class="wrap">

        <?php echo $this->Templates->PageHeader(); ?>

        <div class="page-body">
            <?php echo $this->Templates->LeftBar(); ?>
            <div class="content">
                <div class="content-header">
                    <div class="leftside-content-header">
                        <ul class="breadcrumbs">
                            <li><i class="fa fa-sitemap" aria-hidden="true"></i><a href="<?php echo site_url('admin'); ?>">Dashboard</a></li>
                            <li><a><?php echo $row[0]->menu_name; ?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="row animated fadeInUp">
                    <div class="col-sm-12 col-lg-12">
                        <div class="panel" style="background: linear-gradient(90deg, #f8f8f8 20%, #dddddd 40%, #f8f8f8 80%);">
                            <div class="panel-header">
                                <h3 class="section-subtitle">
                                    <?php echo $row[0]->menu_name; ?>
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius:10px; font-weight:bold;">
                                            <i class="fa fa-plus"></i> Buat <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="<?= site_url('produksi/form_kalibrasi'); ?>">Kalibrasi</a></li>
											<li><a href="<?= site_url('produksi/form_agregat'); ?>">Komposisi Agregat</a></li>
											<li><a href="<?= site_url('produksi/form_produksi_harian'); ?>">Produksi Harian</a></li>
											<li><a href="<?= site_url('produksi/form_produksi_campuran'); ?>">Produksi Campuran</a></li>
                                            <li><a href="javascript:void(0);" onclick="OpenForm()">Stock Opname</a></li>
                                            <li><a href="<?= site_url('produksi/form_kunci_bahan_baku'); ?>">Kunci Bahan Baku</a></li>
                                            <li><a href="<?= site_url('produksi/form_kunci_bahan_jadi'); ?>">Kunci Bahan Jadi</a></li>
                                            <?php
                                            if(in_array($this->session->userdata('admin_group_id'), array(1))){
                                            ?>
                                            <li><a href="<?= site_url('produksi/form_rakor'); ?>">Kunci Data Rakor</a></li>
                                            <?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </h3>
                            </div>
                            <div class="panel-content">
                                <ul class="nav nav-tabs" role="tablist">
									<li role="presentation"  class="active"><a href="#kalibrasi" aria-controls="kalibrasi" role="tab" data-toggle="tab" style="border-radius:10px 0px 10px 0px; font-weight:bold;">Kalibrasi</a></li>
									<li role="presentation"><a href="#komposisi_agregat" aria-controls="komposisi_agregat" role="tab" data-toggle="tab" style="border-radius:10px 0px 10px 0px; font-weight:bold;">Komposisi Agregat</a></li>
									<li role="presentation"><a href="#produksi_harian" aria-controls="produksi_harian" role="tab" data-toggle="tab" style="border-radius:10px 0px 10px 0px; font-weight:bold;">Produksi Harian</a></li>
									<li role="presentation"><a href="#produksi_campuran" aria-controls="produksi_campuran" role="tab" data-toggle="tab" style="border-radius:10px 0px 10px 0px; font-weight:bold;">Produksi Campuran</a></li>
                                    <li role="presentation"><a href="#material_on_site" aria-controls="material_on_site" role="tab" data-toggle="tab" style="border-radius:10px 0px 10px 0px; font-weight:bold;">Stock Opname</a></li>
                                    <li role="presentation"><a href="#kunci_bahan_baku" aria-controls="kunci_bahan_baku" role="tab" data-toggle="tab" style="border-radius:10px 0px 10px 0px; font-weight:bold;">Kunci Bahan Baku</a></li>
                                    <li role="presentation"><a href="#kunci_bahan_jadi" aria-controls="kunci_bahan_jadi" role="tab" data-toggle="tab" style="border-radius:10px 0px 10px 0px; font-weight:bold;">Kunci Bahan Jadi</a></li>
                                    <?php
                                    if(in_array($this->session->userdata('admin_group_id'), array(1))){
                                    ?>
                                    <li role="presentation"><a href="#rakor" aria-controls="rakor" role="tab" data-toggle="tab" style="border-radius:10px 0px 10px 0px; font-weight:bold;">Kunci Data Rakor</a></li>
                                    <?php
                                    }
                                    ?>
                                </ul>

                                <div class="tab-content">
									
									<div role="tabpanel" class="tab-pane" id="material_on_site">
                                        <?php include_once "material_on_site.php"; ?>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="material_usage">
                                        <?php include_once "material_usage.php"; ?>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="rakor">
                                        <?php include_once "rakor.php"; ?>
                                    </div>
									
										
									<!-- Table Kalibrasi -->
									<?php			
										$judul = $this->db->order_by('id', 'asc')->get_where('pmm_kalibrasi')->result_array();
									?>
                                    <div role="tabpanel" class="tab-pane active" id="kalibrasi">
										<div class="col-sm-4">
											<input type="text" id="filter_date_kalibrasi" name="filter_date" class="form-control dtpickerange" autocomplete="off" placeholder="Filter By Date">
										</div>
										<div class="col-sm-4">
											<select id="jobs_type" name="jobs_type" class="form-control select2">
												<option value="">Pilih Judul</option>
												<?php
												foreach ($judul as $key => $jd) {
												?>
													<option value="<?php echo $jd['jobs_type']; ?>"><?php echo $jd['jobs_type']; ?></option>
												<?php
												}
												?>
											</select>
										</div>
										<br />
										<br />										
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-center" id="table_kalibrasi" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
														<th>Tanggal</th>
														<th>Nomor Kalibrasi</th>
                                                        <th>Judul</th>
														<th>Lampiran</th>
                                                        <th>Hapus</th>
                                                        <th>Cetak</th>
                                                        <th>Status</th>
														
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                   
                                                </tfoot>
                                            </table>
                                        </div>
									</div>

                                    <!-- Table Komposisi Agregat -->
                                    <div role="tabpanel" class="tab-pane" id="komposisi_agregat">
										<div class="col-sm-4">
											<input type="text" id="filter_date_agregat" name="filter_date" class="form-control dtpickerange" autocomplete="off" placeholder="Filter By Date">
										</div>
										<br />
										<br />										
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-center" id="table_agregat" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
														<th>Tanggal</th>
														<th>Nomor Komposisi</th>
                                                        <th>Judul</th>
														<th>Lampiran</th>
                                                        <th>Hapus</th>
                                                        <th>Cetak</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                   
                                                </tfoot>
                                            </table>
                                        </div>
									</div>
										
									<!-- Table Produksi Harian -->
									<div role="tabpanel" class="tab-pane" id="produksi_harian">
										<div class="col-sm-4">
											<input type="text" id="filter_date_produksi_harian" name="filter_date" class="form-control dtpickerange" autocomplete="off" placeholder="Filter By Date">
										</div>
										<br />
										<br />
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-center" id="table_produksi_harian" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>	
                                                        <th>Tanggal</th>
														<th>Nomor Produksi Harian</th>	
														<th>Durasi Produksi (Jam)</th>
														<th>Pemakaian Bahan Baku (Ton)</th>
														<th>Kapasitas Produksi (Ton/Jam)</th>
														<th>Keterangan</th>
                                                        <th>Lampiran</th>
                                                        <th>Hapus</th>
                                                        <th>Cetak</th>
                                                        <th>Status</th>												
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                   
                                                </tfoot>
                                            </table>
                                        </div>
									</div>
									
									<!-- Table Produksi Campuran -->
									<?php			
										$no_prod = $this->db->order_by('id', 'asc')->get_where('pmm_produksi_campuran', array('status' => 'PUBLISH'))->result_array();
									?>
									<div role="tabpanel" class="tab-pane" id="produksi_campuran">
										<div class="col-sm-4">
											<input type="text" id="filter_date_produksi_campuran" name="filter_date" class="form-control dtpickerange" autocomplete="off" placeholder="Filter By Date">
										</div>
										<div class="col-sm-4">
											<select id="no_prod" name="no_prod" class="form-control select2">
												<option value="">Pilih Nomor Produksi Campuran</option>
												<?php
												foreach ($no_prod as $key => $prod) {
												?>
													<option value="<?php echo $prod['no_prod']; ?>"><?php echo $prod['no_prod']; ?></option>
												<?php
												}
												?>
											</select>
										</div>
										<br />
										<br />
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-center" id="table_produksi_campuran" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>	
                                                        <th>Tanggal</th>
														<th>Nomor Produksi Campuran</th>	
														<th>Uraian</th>
														<th>Satuan</th>
														<th>Volume</th>
														<th>Keterangan</th>
                                                        <th>Lampiran</th>
                                                        <th>Hapus</th>
                                                        <th>Cetak</th>
                                                        <th>Status</th>											
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                   
                                                </tfoot>
                                            </table>
                                        </div>
									</div>

                                    <!-- Table Kunci Bahan Baku -->
									<div role="tabpanel" class="tab-pane" id="kunci_bahan_baku">
										<div class="col-sm-4">
											<input type="text" id="filter_date_kunci_bahan_baku" name="filter_date" class="form-control dtpickerange" autocomplete="off" placeholder="Filter By Date">
										</div>
										<br />
										<br />
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-center" id="table_kunci_bahan_baku" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>	
                                                        <th>Tanggal</th>
														<th>Vol. Pemakaian BBM (1)</th>	
														<th>Nilai Pemakaian BBM (1)</th>
                                                        <th>Vol. Pemakaian BBM (2)</th>	
														<th>Nilai Pemakaian BBM (2)</th>
														<th>Vol. Boulder</th>
														<th>Nilai Boulder</th>
														<th>Vol. BBM Solar</th>
                                                        <th>Nilai BBM Solar</th>
                                                        <th>Hapus</th>										
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                   
                                                </tfoot>
                                            </table>
                                        </div>
									</div>

                                    <!-- Table Kunci Bahan Jadi -->
									<div role="tabpanel" class="tab-pane" id="kunci_bahan_jadi">
										<div class="col-sm-4">
											<input type="text" id="filter_date_kunci_bahan_jadi" name="filter_date" class="form-control dtpickerange" autocomplete="off" placeholder="Filter By Date">
										</div>
										<br />
										<br />
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-center" id="table_kunci_bahan_jadi" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>	
                                                        <th>Tanggal</th>
														<th>Vol. Persediaan Bahan Jadi</th>
														<th>Nilai Persedian Bahan Jadi</th>
                                                        <th>Nilai BPP</th>
                                                        <th>Hapus</th>										
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                   
                                                </tfoot>
                                            </table>
                                        </div>
									</div>
										           
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <?php echo $this->Templates->Footer(); ?>

    <script src="<?php echo base_url(); ?>assets/back/theme/vendor/jquery.number.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/back/theme/vendor/bootbox.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/back/theme/vendor/daterangepicker/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/back/theme/vendor/daterangepicker/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/back/theme/vendor/daterangepicker/daterangepicker.css">
    
    <script type="text/javascript">
	$('#dtpickerange').daterangepicker({
        autoUpdateInput: false,
        locale: {
            format: 'DD-MM-YYYY'
        },
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        showDropdowns: true,
		});
		
		var table_kalibrasi = $('#table_kalibrasi').DataTable( {"bAutoWidth": false,
            ajax: {
                processing: true,
                serverSide: true,
                url: '<?php echo site_url('produksi/table_kalibrasi'); ?>',
                type: 'POST',
                data: function(d) {
                    d.filter_date = $('#filter_date_kalibrasi').val();
					d.jobs_type = $('#jobs_type').val();
                }
            },
            responsive: true,
            "deferRender": true,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
            },
            columns: [
				{
                    "data": "no"
                },
				{
                    "data": "tanggal_kalibrasi"
                },
				{
                    "data": "no_kalibrasi"
                },
				{
                    "data": "jobs_type"
                },
				{
                    "data": "lampiran"
                },
                {
					"data": "actions"
				},
                {
					"data": "print"
				},
                {
                    "data": "status"
                }
            ],
            "columnDefs": [
                { "width": "5%", "targets": 0, "className": 'text-center'},
            ],
        });
		
		$('#jobs_type').change(function() {
        table_kalibrasi.ajax.reload();
		});
		
		$('#filter_date_kalibrasi').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
        table_kalibrasi.ajax.reload();
		});

        function DeleteDataKalibrasi(id) {
        bootbox.confirm("Anda yakin akan menghapus data ini ?", function(result) {
            // console.log('This was logged in the callback: ' + result); 
            if (result) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('produksi/delete_kalibrasi'); ?>",
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(result) {
                        if (result.output) {
                            table_kalibrasi.ajax.reload();
                            bootbox.alert('<b>Berhasil Menghapus Kalibrasi</b>');
                        } else if (result.err) {
                            bootbox.alert(result.err);
                        }
                    }
                });
            }
            });
        }

        var table_agregat = $('#table_agregat').DataTable( {"bAutoWidth": false,
            ajax: {
                processing: true,
                serverSide: true,
                url: '<?php echo site_url('produksi/table_agregat'); ?>',
                type: 'POST',
                data: function(d) {
                    d.filter_date = $('#filter_date_agregat').val();
                }
            },
            responsive: true,
            "deferRender": true,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
            },
            columns: [
				{
                    "data": "no"
                },
				{
                    "data": "date_agregat"
                },
				{
                    "data": "no_komposisi"
                },
				{
                    "data": "jobs_type"
                },
				{
                    "data": "lampiran"
                },
                {
					"data": "actions"
				},
                {
					"data": "print"
				},
                {
                    "data": "status"
                }
            ],
            "columnDefs": [
                { "width": "5%", "targets": 0, "className": 'text-center'},
            ],
        });
		
		$('#filter_date_agregat').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
        table_agregat.ajax.reload();
		});

        function DeleteAgregat(id) {
        bootbox.confirm("Anda yakin akan menghapus data ini ?", function(result) {
            // console.log('This was logged in the callback: ' + result); 
            if (result) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('produksi/delete_agregat'); ?>",
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(result) {
                        if (result.output) {
                            table_agregat.ajax.reload();
                            bootbox.alert('<b>Berhasil Menghapus Komposisi Agregat</b>');
                        } else if (result.err) {
                            bootbox.alert(result.err);
                        }
                    }
                });
            }
            });
        }
		
		var table_produksi_harian = $('#table_produksi_harian').DataTable( {"bAutoWidth": false,
            ajax: {
                processing: true,
                serverSide: true,
                url: '<?php echo site_url('produksi/table_produksi_harian'); ?>',
                type: 'POST',
                data: function(d) {
                    d.filter_date = $('#filter_date_produksi_harian').val();
                }
            },
            responsive: true,
            "deferRender": true,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
            },
            columns: [
				{
                    "data": "no"
                },
				{
                    "data": "date_prod"
                },
				{
                    "data": "no_prod"
                },
				{
                    "data": "duration"
                },
				{
                    "data": "used"
                },
				{
                    "data": "capacity"
                },
				{
                    "data": "memo"
                },
                {
                    "data": "lampiran"
                },
                {
					"data": "actions"
				},
                {
					"data": "print"
				},
                {
                    "data": "status"
                }
            ],
            "columnDefs": [
                { "width": "5%", "targets": 0, "className": 'text-center'},
                { "targets": [3, 4, 5], "className": 'text-right'},
            ],
        });
		
		$('#filter_date_produksi_harian').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
        table_produksi_harian.ajax.reload();
		});

        function DeleteProduksiHarian(id) {
        bootbox.confirm("Anda yakin akan menghapus data ini ?", function(result) {
            // console.log('This was logged in the callback: ' + result); 
            if (result) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('produksi/delete_produksi_harian'); ?>",
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(result) {
                        if (result.output) {
                            table_produksi_harian.ajax.reload();
                            bootbox.alert('<b>Berhasil Menghapus Produksi Harian</b>');
                        } else if (result.err) {
                            bootbox.alert(result.err);
                        }
                    }
                });
            }
            });
        }
		
		var table_produksi_campuran = $('#table_produksi_campuran').DataTable( {"bAutoWidth": false,
            ajax: {
                processing: true,
                serverSide: true,
                url: '<?php echo site_url('produksi/table_produksi_campuran'); ?>',
                type: 'POST',
                data: function(d) {
                    d.filter_date = $('#filter_date_produksi_campuran').val();
					d.no_prod = $('#no_prod').val();
                }
            },
            responsive: true,
            "deferRender": true,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
            },
            columns: [
				{
                    "data": "no"
                },
				{
                    "data": "date_prod"
                },
				{
                    "data": "no_prod"
                },
				{
                    "data": "uraian"
                },
				{
                    "data": "measure_convert"
                },
				{
                    "data": "volume_convert"
                },
				{
                    "data": "memo"
                },
                {
                    "data": "lampiran"
                },
                {
					"data": "actions"
				},
                {
					"data": "print"
				},
                {
                    "data": "status"
                }
            ],
            "columnDefs": [
                { "width": "5%", "targets": 0, "className": 'text-center'},
                { "targets": 5, "className": 'text-right'},
            ],
        });
		
		$('#filter_date_produksi_campuran').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
        table_produksi_campuran.ajax.reload();
		});
		
		$('#no_prod').change(function() {
        table_produksi_campuran.ajax.reload();
		});

        function DeleteProduksiCampuran(id) {
        bootbox.confirm("Anda yakin akan menghapus data ini ?", function(result) {
            // console.log('This was logged in the callback: ' + result); 
            if (result) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('produksi/delete_produksi_campuran'); ?>",
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(result) {
                        if (result.output) {
                            table_produksi_campuran.ajax.reload();
                            bootbox.alert('<b>Berhasil Menghapus Produksi Campuran</b>');
                        } else if (result.err) {
                            bootbox.alert(result.err);
                        }
                    }
                });
            }
            });
        }

        var table_kunci_bahan_baku = $('#table_kunci_bahan_baku').DataTable( {"bAutoWidth": false,
            ajax: {
                processing: true,
                serverSide: true,
                url: '<?php echo site_url('produksi/table_kunci_bahan_baku'); ?>',
                type: 'POST',
                data: function(d) {
                    d.filter_date = $('#filter_date_kunci_bahan_baku').val();
                }
            },
            responsive: true,
            "deferRender": true,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
            },
            columns: [
				{
                    "data": "no"
                },
				{
                    "data": "date"
                },
				{
                    "data": "vol_pemakaian_bbm"
                },
				{
                    "data": "nilai_pemakaian_bbm"
                },
				{
                    "data": "vol_pemakaian_bbm_2"
                },
				{
                    "data": "nilai_pemakaian_bbm_2"
                },
				{
                    "data": "vol_nilai_boulder"
                },
                {
                    "data": "nilai_boulder"
                },
                {
					"data": "vol_nilai_bbm"
				},
                {
					"data": "nilai_bbm"
				},
                {
                    "data": "actions"
                }
            ],
            "columnDefs": [
                { "width": "5%", "targets": 0, "className": 'text-center'},
                { "targets": [2,3,4,5,6,7,8,9], "className": 'text-right'},
            ],
        });
		
		$('#filter_date_kunci_bahan_baku').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
        table_kunci_bahan_baku.ajax.reload();
		});

        function DeleteKunciBahanBaku(id) {
        bootbox.confirm("Anda yakin akan menghapus data ini ?", function(result) {
            // console.log('This was logged in the callback: ' + result); 
            if (result) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('produksi/delete_kunci_bahan_baku'); ?>",
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(result) {
                        if (result.output) {
                            table_kunci_bahan_baku.ajax.reload();
                            bootbox.alert('<b>Berhasil Menghapus Kunci Bahan Baku</b>');
                        } else if (result.err) {
                            bootbox.alert(result.err);
                        }
                    }
                });
            }
            });
        }

        var table_kunci_bahan_jadi = $('#table_kunci_bahan_jadi').DataTable( {"bAutoWidth": false,
            ajax: {
                processing: true,
                serverSide: true,
                url: '<?php echo site_url('produksi/table_kunci_bahan_jadi'); ?>',
                type: 'POST',
                data: function(d) {
                    d.filter_date = $('#filter_date_kunci_bahan_jadi').val();
                }
            },
            responsive: true,
            "deferRender": true,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
            },
            columns: [
				{
                    "data": "no"
                },
				{
                    "data": "date"
                },
				{
                    "data": "volume"
                },
				{
                    "data": "nilai"
                },
                {
                    "data": "bpp"
                },
                {
                    "data": "actions"
                }
            ],
            "columnDefs": [
                { "width": "5%", "targets": 0, "className": 'text-center'},
                { "targets": [2,3,4], "className": 'text-right'},
            ],
        });
		
		$('#filter_date_kunci_bahan_jadi').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
        table_kunci_bahan_jadi.ajax.reload();
		});

        function DeleteKunciBahanJadi(id) {
        bootbox.confirm("Anda yakin akan menghapus data ini ?", function(result) {
            // console.log('This was logged in the callback: ' + result); 
            if (result) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('produksi/delete_kunci_bahan_jadi'); ?>",
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(result) {
                        if (result.output) {
                            table_kunci_bahan_jadi.ajax.reload();
                            bootbox.alert('<b>Berhasil Menghapus Kunci Bahan Jadi</b>');
                        } else if (result.err) {
                            bootbox.alert(result.err);
                        }
                    }
                });
            }
            });
        }
	
    </script>

    <?php include_once("script_material_on_site.php"); ?>
    
    <?php include_once("script_material_usage.php"); ?>

    <?php include_once("script_rakor.php"); ?>

</body>

</html>