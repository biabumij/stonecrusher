<!doctype html>
<html lang="en" class="fixed">
<head>
    <?php echo $this->Templates->Header();?>

    <style type="text/css">
        .table-center th{
            text-align:center;
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
                                <a href="<?php echo site_url('admin/produksi');?>"> <i class="fa fa-sitemap" aria-hidden="true"></i> Produksi</a></li>
                            <li><a>Buat Kunci Bahan Baku</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row animated fadeInUp">
                    <div class="col-sm-12 col-lg-12">
                        <div class="panel">
                            <div class="panel-header"> 
                                <div class="">
                                    <h3 class="">Kunci Bahan Baku Baru</h3>
                                    
                                </div>
                            </div>
                            <div class="panel-content">
                                <form method="POST" action="<?php echo site_url('produksi/submit_kunci_bahan_baku');?>" id="form-po" enctype="multipart/form-data" autocomplete="off">
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
                                                    <th width="50%">URAIAN</th>
													<th width="25%">VOLUME</th>
                                                    <th width="25%">NILAI</th>
                                                </tr>
                                            </thead>
                                            <tbody>
												<tr>
                                                    <td>Pemakaian BBM (1)</td>
													<td><input type="text" id="vol_pemakaian_bbm" name="vol_pemakaian_bbm" class="form-control text-center" value="" required="" autocomplete="off"></td>
                                                    <td><input type="text" id="nilai_pemakaian_bbm" name="nilai_pemakaian_bbm" class="form-control rupiahformat text-center" value="" required="" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td>Pemakaian BBM (2)</td>
													<td><input type="text" id="vol_pemakaian_bbm_2" name="vol_pemakaian_bbm_2" class="form-control text-center" value="" required="" autocomplete="off"></td>
                                                    <td><input type="text" id="nilai_pemakaian_bbm_2" name="nilai_pemakaian_bbm_2" class="form-control rupiahformat text-center" value="" required="" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td>Sisa Boulder</td>
													<td><input type="text" id="vol_nilai_boulder" name="vol_nilai_boulder" class="form-control text-center" value="" required="" autocomplete="off"></td>
                                                    <td><input type="text" id="nilai_boulder" name="nilai_boulder" class="form-control rupiahformat text-center" value="" required="" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td>Sisa BBM Solar</td>
													<td><input type="text" id="vol_nilai_bbm" name="vol_nilai_bbm" class="form-control text-center" value="" required="" autocomplete="off"></td>
                                                    <td><input type="text" id="nilai_bbm" name="nilai_bbm" class="form-control rupiahformat text-center" value="" required="" autocomplete="off"></td>
                                                </tr>
                                            </tbody>
                                        </table>    
                                    </div>
									<br />
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <a href="<?= site_url('admin/produksi');?>" class="btn btn-danger" style="margin-bottom:0; width:10%; font-weight:bold;"><i class="fa fa-close"></i> Batal</a>
                                            <button type="submit" class="btn btn-success" style="width:10%; font-weight:bold;"><i class="fa fa-send"></i> Kirim</button>
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
		//$('input.rupiahformat').number( true, 0,',','.' );

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
            }
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
                $('#produk_a').prop('selectedIndex', 2).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#produk_b').prop('selectedIndex', 1).trigger('change');
            }, 1000);
        });
    </script>


</body>
</html>
