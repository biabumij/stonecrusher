<!doctype html>
<html lang="en" class="fixed">
<head>
    <?php echo $this->Templates->Header();?>

    <style type="text/css">
        body{
			font-family: helvetica;
	  	}
    </style>
</head>

<body>
    <div class="wrap">
        <?php echo $this->Templates->PageHeader();?>
        <div class="page-body">
            <?php echo $this->Templates->LeftBar();?>
            <div class="content">
                <div class="content-header">
                    <div class="leftside-content-header">
                        <ul class="breadcrumbs">
                            <li><i class="fa fa-sitemap" aria-hidden="true"></i><a href="<?php echo site_url('admin');?>">Dashboard</a></li>
                            <li>
                                <a href="<?php echo site_url('admin/produksi');?>">Kunci & Approval</a></li>
                            <li><a>Kunci Bahan Jadi</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row animated fadeInUp">
                    <div class="col-sm-12 col-lg-12">
                        <div class="panel">
                            <div class="panel-header"> 
                                <div class="">
                                    <h3 class="">Kunci Bahan Jadi</h3>
                                    
                                </div>
                            </div>
                            <div class="panel-content">
                                <form method="POST" action="<?php echo site_url('produksi/submit_kunci_bahan_jadi');?>" id="form-po" enctype="multipart/form-data" autocomplete="off">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label>Tanggal</label>
                                        </div>
										 <div class="col-sm-2">
                                            <input type="text" class="form-control dtpicker" name="date" required="" value="" />
                                        </div>                          
                                    </div>
                                    <br />
                                    <div class="table-responsive">
                                        <table id="table-product" class="table table-bordered table-striped table-condensed table-center">
                                            <thead>
                                                <tr>
                                                    <th width="5%">NO.</th>
                                                    <th width="35%" class="text-left">URAIAN</th>
													<th width="30%" class="text-right">VOLUME AKHIR BAHAN JADI</th>
                                                    <th width="30%" class="text-right">NILAI AKHIR BAHAN JADI</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">1.</td>
                                                    <td>Bahan Jadi</td>
													<td>
                                                        <input type="number" step=".01" min="0" name="volume" id="volume" class="form-control text-right numberformat" required="" value="0"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="nilai" id="nilai" class="form-control text-right" required="" value="0"/>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>    
                                    </div>
									<br />
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <a href="<?= site_url('admin/kunci_&_approval');?>" class="btn btn-danger" style="margin-bottom:0; width:15%; font-weight:bold; border-radius:10px;"><i class="fa fa-close"></i> Batal</a>
                                            <button type="submit" class="btn btn-success" style="width:15%; font-weight:bold; border-radius:10px;"><i class="fa fa-send"></i> Kirim</button>
                                        </div>
                                    </div>
								</form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
    <script type="text/javascript">
        var form_control = '';
    </script>
    <?php echo $this->Templates->Footer();?>

    <script src="<?php echo base_url();?>assets/back/theme/vendor/jquery.number.min.js"></script>
    
    <script src="<?php echo base_url();?>assets/back/theme/vendor/daterangepicker/moment.min.js"></script>
    <script src="<?php echo base_url();?>assets/back/theme/vendor/daterangepicker/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/back/theme/vendor/daterangepicker/daterangepicker.css">
   
    <script src="<?php echo base_url();?>assets/back/theme/vendor/bootbox.min.js"></script>

    

    <script type="text/javascript">
        
        $('.form-select2').select2();

        $('input.numberformat').number( true, 2,',','.' );
        tinymce.init({
          selector: 'textarea#about_text',
          height: 200,
          menubar: false,
        });
        $('.dtpicker').daterangepicker({
            singleDatePicker: true,
            showDropdowns : true,
            locale: {
              format: 'DD-MM-YYYY'
            },
            minDate: new Date(2023, 07, 01),
        });
        $('.dtpicker').on('apply.daterangepicker', function(ev, picker) {
              $(this).val(picker.startDate.format('DD-MM-YYYY'));
              // table.ajax.reload();
        });



        $('#form-po').submit(function(e){
            e.preventDefault();
            var currentForm = this;
            bootbox.confirm({
                message: "Apakah anda yakin untuk proses data ini ?",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if(result){
                        currentForm.submit();
                    }
                    
                }
            });
            
        });
		
		$(document).ready(function() {
            setTimeout(function(){
                $('#produk_a').prop('selectedIndex', 3).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#produk_b').prop('selectedIndex', 4).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#produk_c').prop('selectedIndex', 1).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#produk_d').prop('selectedIndex', 2).trigger('change');
            }, 1000);
        });
		
    </script>


</body>
</html>
