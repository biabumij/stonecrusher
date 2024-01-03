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
                                            <li><a href="<?= site_url('produksi/form_kunci_bahan_baku'); ?>">Kunci Bahan Baku</a></li>
                                            <li><a href="<?= site_url('produksi/form_kunci_bahan_jadi'); ?>">Kunci Bahan Jadi</a></li>
                                        </ul>
                                    </div>
                                </h3>

                            </div>
                            <div class="panel-content">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#kunci_bahan_baku" aria-controls="kunci_bahan_baku" role="tab" data-toggle="tab" style="border-radius:10px 0px 10px 0px; font-weight:bold;">Kunci Bahan Baku</a>
                                    <li role="presentation"><a href="#kunci_bahan_jadi" aria-controls="kunci_bahan_jadi" role="tab" data-toggle="tab" style="border-radius:10px 0px 10px 0px; font-weight:bold;">Kunci Bahan Jadi</a></li>
                                </ul>

                                <div class="tab-content">

                                    <!-- Table Kunci Bahan Baku -->
                                    <div role="tabpanel" class="tab-pane active" class="tab-pane" id="kunci_bahan_baku">
										<div class="col-sm-4">
											<input type="text" id="filter_date_kunci_bahan_baku" name="filter_date" class="form-control dtpickerange" autocomplete="off" placeholder="Filter By Date">
										</div>
										<br />
										<br />										
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover" id="table_kunci_bahan_baku" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
														<th>Tanggal</th>
                                                        <th>Vol. Akhir Boulder</th>
                                                        <th>Nilai Akhir Boulder</th>
                                                        <th>Vol. Akhir BBM Solar</th>
                                                        <th>Nilai Akhir BBM Solar</th>
														<th>Status</th>
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

                                    <!-- HPP Table Kunci Bahan Jadi -->
                                    <div role="tabpanel" class="tab-pane" id="kunci_bahan_jadi">
										<div class="col-sm-4">
											<input type="text" id="filter_date_kunci_bahan_jadi" name="filter_date" class="form-control dtpickerange" autocomplete="off" placeholder="Filter By Date">
										</div>
										<br />
										<br />										
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover" id="table_kunci_bahan_jadi" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
														<th>Tanggal</th>
                                                        <th>Volume Persediaan Akhir Bahan Jadi</th>
														<th>Nilai Persediaan Akhir Bahan Jadi</th>
														<th>Status</th>
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
	$('input.numberformat').number( true, 2,',','.' );
        $('.dtpicker').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'DD-MM-YYYY'
            }
        });
        $('.dtpicker').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY'));
        });

        $('.dtpickerange').daterangepicker({
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

        var table_kunci_bahan_baku = $('#table_kunci_bahan_baku').DataTable({
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
            paging: false,
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
                    "data": "created_on"
                },
                {
                    "data": "actions"
                }
            ],
            "columnDefs": [
                { "width": "5%", "targets": 0, "className": 'text-center'},
                { "targets": [2, 3, 4, 5], "className": 'text-right'},
            ],
        });

        $('.dtpickerange').on('apply.daterangepicker', function(ev, picker) {
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
                            bootbox.alert('Berhasil Menghapus Kunci Bahan Baku !!');
                        } else if (result.err) {
                            bootbox.alert(result.err);
                        }
                    }
                });
            }
            });
        }

        var table_kunci_bahan_jadi = $('#table_kunci_bahan_jadi').DataTable({
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
            paging: false,
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
                    "data": "status"
                },
                {
                    "data": "actions"
                }
            ],
            "columnDefs": [
                { "width": "5%", "targets": 0, "className": 'text-center'},
                { "targets": [2, 3], "className": 'text-right'},
            ],
        });

        $('.dtpickerange').on('apply.daterangepicker', function(ev, picker) {
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
                            bootbox.alert('Berhasil Menghapus Kunci Bahan Jadi !!');
                        } else if (result.err) {
                            bootbox.alert(result.err);
                        }
                    }
                });
            }
            });
        }

    </script>

</body>
</html>