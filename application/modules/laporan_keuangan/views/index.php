<!doctype html>
<html lang="en" class="fixed">
    <head>
        <?php echo $this->Templates->Header(); ?>
        <style type="text/css">
            body {
                font-family: helvetica;
            }
            
            .mytable thead th {
            background-color:	#e69500;
            color: #ffffff;
            text-align: center;
            vertical-align: middle;
            padding: 5px;
            }
            
            .mytable tbody td {
            padding: 5px;
            }
            
            .mytable tfoot td {
            background-color:	#e69500;
            color: #FFFFFF;
            padding: 5px;
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
                                <li><i class="fa fa-bar-chart" aria-hidden="true"></i>Laporan</li>
                                <li><a><?php echo $row[0]->menu_name; ?></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row animated fadeInUp">
                        <div class="col-sm-12 col-lg-12">
                            <div class="panel" style="background: linear-gradient(90deg, #ebe1d2 20%, #ebe1d2 40%, #ebe1d2 80%);">
                                <div class="panel-content">
                                    <div class="panel-header">
                                        <h3 class="section-subtitle"><b><?php echo $row[0]->menu_name; ?></b></h3>
                                    </div>
                                    <div class="tab-content">
                                        
                                        <div role="tabpanel" class="tab-pane active" id="laba_rugi">
                                            <br />
                                            <div class="row">
                                                <div width="100%">
                                                    <div class="panel panel-default">                                            
                                                        <div class="col-sm-5">
                                                            <p><b><h5>Laporan Laba Rugi</h5></b></p>
                                                            <a href="#laporan-laba-rugi-new" aria-controls="laporan-laba-rugi-new" role="tab" data-toggle="tab" class="btn btn-primary" style="border-radius:10px; font-weight:bold;">Lihat Laporan</a>										
                                                        </div>													
                                                    </div>
                                                    <div class="panel panel-default">                                            
                                                        <div class="col-sm-5">
                                                            <p><b><h5>Biaya</h5></b></p>
                                                            <a href="<?= site_url('laporan/laporan_biaya'); ?>" class="btn btn-primary" style="border-radius:10px; font-weight:bold;">Lihat Laporan</a>
                                                        </div>													
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="col-sm-5">
                                                            <p><b><h5>Cash Flow</h5></b></p>
                                                            <a href="#cash_flow" aria-controls="cash_flow" role="tab" data-toggle="tab" class="btn btn-primary" style="border-radius:10px; font-weight:bold;">Lihat Laporan</a>										
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-default">                                            
                                                        <div class="col-sm-5">
                                                            <p><b><h5>Neraca</h5></b></p>
                                                            <a href="#neraca" aria-controls="neraca" role="tab" data-toggle="tab" class="btn btn-primary" style="border-radius:10px; font-weight:bold;">Lihat Laporan</a>										
                                                        </div>													
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Laporan Laba Rugi Baru -->
                                        <div role="tabpanel" class="tab-pane" id="laporan-laba-rugi-new">
                                            <div class="col-sm-15">
                                            <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title"><b>Laporan Laba Rugi</b></h3>
                                                        <a href="laporan_keuangan">Kembali</a>
                                                    </div>
                                                    <div style="margin: 20px">
                                                        <div class="row">
                                                            <form action="<?php echo site_url('laporan/laporan_laba_rugi_new_print');?>" target="_blank">
                                                                <div class="col-sm-3">
                                                                    <input type="text" id="filter_date_new" name="filter_date" class="form-control dtpicker"  autocomplete="off" placeholder="Filter By Date">
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <button type="submit" class="btn btn-default" style="border-radius:10px; font-weight:bold;"><i class="fa fa-print"></i>  Print</button>
                                                                </div>
                                                            </form>
                                                            
                                                        </div>
                                                        <br />
                                                        <div id="wait" style=" text-align: center; align-content: center; display: none;">	
                                                            <div>Please Wait</div>
                                                            <div class="fa-3x">
                                                            <i class="fa fa-spinner fa-spin"></i>
                                                            </div>
                                                        </div>				
                                                        <div class="table-responsive" id="box-ajax-new">													
                                                        
                        
                                                        </div>
                                                    </div>
                                            </div>
                                            
                                            </div>
                                        </div>

                                        <!-- Cash Flow -->
                                        <div role="tabpanel" class="tab-pane" id="cash_flow">
                                            <div class="col-sm-15">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">Cash Flow</h3>
                                                        <a href="laporan_keuangan">Kembali</a>
                                                    </div>
                                                    <div style="margin: 20px">
                                                        <div class="row">
                                                            <form action="<?php echo site_url('laporan/cetak_cash_flow');?>" target="_blank">
                                                                <div class="col-sm-3">
                                                                    <button type="submit" class="btn btn-default" style="border-radius:10px; font-weight:bold;"><i class="fa fa-print"></i>  Print</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <br />
                                                        <div id="wait-cash-flow" style=" text-align: center; align-content: center; display: none;">	
                                                            <div>Please Wait</div>
                                                            <div class="fa-3x">
                                                            <i class="fa fa-spinner fa-spin"></i>
                                                            </div>
                                                        </div>				
                                                        <div class="table-responsive" id="cash-flow">
                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Neraca -->
                                        <div role="tabpanel" class="tab-pane" id="neraca">
                                            <div class="col-sm-15">
                                            <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title"><b>Neraca</b></h3>
                                                        <a href="laporan_keuangan">Kembali</a>
                                                    </div>
                                                    <div style="margin: 20px">
                                                        <div class="row">
                                                            <form action="<?php echo site_url('laporan/neraca_print');?>" target="_blank">
                                                                <div class="col-sm-3">
                                                                    <input type="text" id="filter_date_neraca" name="filter_date" class="form-control dtpicker"  autocomplete="off" placeholder="Filter By Date">
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <button type="submit" class="btn btn-default" style="border-radius:10px; font-weight:bold;"><i class="fa fa-print"></i>  Print</button>
                                                                </div>
                                                            </form>
                                                            
                                                        </div>
                                                        <br />
                                                        <div id="wait-neraca" style=" text-align: center; align-content: center; display: none;">	
                                                            <div>Please Wait</div>
                                                            <div class="fa-3x">
                                                            <i class="fa fa-spinner fa-spin"></i>
                                                            </div>
                                                        </div>				
                                                        <div class="table-responsive" id="table-neraca">													
                                                        
                        
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
                </div>
            </div>
        </div>
        <?php echo $this->Templates->Footer(); ?>
        <script src="<?php echo base_url(); ?>assets/back/theme/vendor/daterangepicker/moment.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/back/theme/vendor/daterangepicker/daterangepicker.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/back/theme/vendor/daterangepicker/daterangepicker.css">
        <script src="<?php echo base_url(); ?>assets/back/theme/vendor/bootbox.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/back/theme/vendor/jquery.number.min.js"></script>
        <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>

        <!-- Script Laba Rugi Baru-->
		<script type="text/javascript">
            $('#filter_date_new').daterangepicker({
                autoUpdateInput : false,
                showDropdowns: true,
                locale: {
                format: 'DD-MM-YYYY'
                },
                minDate: new Date(2023, 07, 01),	
                ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(30, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            });

            $('#filter_date_new').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                TableDateLabaRugiNew();
            });


            function TableDateLabaRugiNew()
            {
                $('#wait').fadeIn('fast');   
                $.ajax({
                    type    : "POST",
                    url     : "<?php echo site_url('pmm/reports/laba_rugi_new'); ?>/"+Math.random(),
                    dataType : 'html',
                    data: {
                        filter_date : $('#filter_date_new').val(),
                    },
                    success : function(result){
                        $('#box-ajax-new').html(result);
                        $('#wait').fadeOut('fast');
                    }
                });
            }

            //TableDateLabaRugiNew();
		</script>

        <!-- Script Cash Flow -->
		<script type="text/javascript">
			$('#filter_date_cash_flow').daterangepicker({
            autoUpdateInput : false,
			showDropdowns: true,
            locale: {
              format: 'DD-MM-YYYY'
            },
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(30, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
			});

			$('#filter_date_cash_flow').on('apply.daterangepicker', function(ev, picker) {
				  $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
				  CashFlow();
			});


			function CashFlow()
			{
				$('#wait-cash-flow').fadeIn('fast');   
				$.ajax({
					type    : "POST",
					url     : "<?php echo site_url('pmm/reports/cash_flow'); ?>/"+Math.random(),
					dataType : 'html',
					data: {
						filter_date : $('#filter_date_cash_flow').val(),
					},
					success : function(result){
						$('#cash-flow').html(result);
						$('#wait-cash-flow').fadeOut('fast');
					}
				});
			}

			CashFlow();
        </script>

        <!-- Neraca-->
		<script type="text/javascript">
            $('#filter_date_neraca').daterangepicker({
                autoUpdateInput : false,
                showDropdowns: true,
                locale: {
                format: 'DD-MM-YYYY'
                },
                minDate: new Date(2023, 07, 01),	
                ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(30, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            });

            $('#filter_date_neraca').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                TableNeraca();
            });


            function TableNeraca()
            {
                $('#wait').fadeIn('fast');   
                $.ajax({
                    type    : "POST",
                    url     : "<?php echo site_url('pmm/reports/neraca'); ?>/"+Math.random(),
                    dataType : 'html',
                    data: {
                        filter_date : $('#filter_date_neraca').val(),
                    },
                    success : function(result){
                        $('#table-neraca').html(result);
                        $('#wait-neraca').fadeOut('fast');
                    }
                });
            }

            //TableNeraca();
		</script>
    </body>
</html>