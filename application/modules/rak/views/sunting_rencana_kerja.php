<!doctype html>
<html lang="en" class="fixed">
<head>
    <?php echo $this->Templates->Header();?>

    <style type="text/css">
        body{
			font-family: helvetica;
	  	}
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
            <div class="content" style="padding:0;">
                <div class="content-header">
                    <div class="leftside-content-header">
                        <ul class="breadcrumbs">
                            <li><i class="fa fa-money" aria-hidden="true"></i>RAP</li>
                            
                            <li><a>Rencana Kerja</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row animated fadeInUp">
                    <div class="col-sm-12 col-lg-12">
                        <div class="panel">
                            <div class="panel-header"> 
                                <div class="">
                                    <h3 class="">Rencana Kerja</h3>
                                    
                                </div>
                            </div>
                            <div class="panel-content">
                                <form method="POST" action="<?php echo site_url('rak/submit_sunting_rencana_kerja');?>" id="form-po" enctype="multipart/form-data" autocomplete="off">
                                    <input type="hidden" name="id" value="<?= $rak["id"] ?>">
                                    <table class="table table-bordered table-striped">
                                        <?php
                                        $tanggal = $rak['tanggal_rencana_kerja'];
                                        $date = date('Y-m-d',strtotime($tanggal));
                                        ?>
                                        <?php
                                        function tgl_indo($date){
                                            $bulan = array (
                                                1 =>   'Januari',
                                                'Februari',
                                                'Maret',
                                                'April',
                                                'Mei',
                                                'Juni',
                                                'Juli',
                                                'Agustus',
                                                'September',
                                                'Oktober',
                                                'November',
                                                'Desember'
                                            );
                                            $pecahkan = explode('-', $date);
                                            
                                            // variabel pecahkan 0 = tanggal
                                            // variabel pecahkan 1 = bulan
                                            // variabel pecahkan 2 = tahun
                                        
                                            return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
                                            
                                        }
                                        ?>
                                        <tr>
                                            <th width="200px">Tanggal</th>
                                            <td>: <?= tgl_indo(date($date)); ?></td>
                                        </tr>
                                        <tr>
                                            <th width="100px">Lampiran</th>
                                            <td>:  
                                                <?php foreach($lampiran as $l) : ?>                                    
                                                <a href="<?= base_url("uploads/rak_biaya/".$l["lampiran"]) ?>" target="_blank">Lihat bukti  <?= $l["lampiran"] ?> <br></a></td>
                                                <?php endforeach; ?>
                                        </tr>
                                    </table>
                                    <table id="table-product" class="table table-bordered table-striped table-condensed table-center">
                                        <thead>
                                            <tr class="text-center">
                                                <th width="5%">NO.</th>
                                                <th width="30%">URAIAN</th>
                                                <th width="20%">VOLUME</th>
                                                <th width="35%">HARGA SATUAN</th>
                                                <th width="20%">SATUAN</th>                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">1.</td>
                                                <td class="text-left">Batu Split 0 - 0,5 (Abu Batu)</td>
                                                <td class="text-right"><input type="text" id="vol_produk_a" name="vol_produk_a" class="form-control numberformat text-right" value="<?php echo number_format($rak["vol_produk_a"],2,',','.');?>" onchange="changeData(1)"  autocomplete="off"></td>
                                                <td class="text-right"><input type="text" id="price_a" name="price_a" class="form-control rupiahformat text-right" value="<?= $rak['price_a'] ?>" autocomplete="off"></td>
                                                <td class="text-center">Ton</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">2.</td>
                                                <td class="text-left">Batu Split 0,5 - 1</td>
                                                <td class="text-right"><input type="text" id="vol_produk_b" name="vol_produk_b" class="form-control numberformat text-right" value="<?php echo number_format($rak["vol_produk_b"],2,',','.');?>" onchange="changeData(1)"  autocomplete="off"></td>
                                                <td class="text-right"><input type="text" id="price_b" name="price_b" class="form-control rupiahformat text-right" value="<?= $rak['price_b'] ?>" autocomplete="off"></td>
                                                <td class="text-center">Ton</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">3.</td>
                                                <td class="text-left">Batu Split 1 - 1,5</td>
                                                <td class="text-right"><input type="text" id="vol_produk_c" name="vol_produk_c" class="form-control numberformat text-right" value="<?php echo number_format($rak["vol_produk_c"],2,',','.');?>" onchange="changeData(1)"  autocomplete="off"></td>
                                                <td class="text-right"><input type="text" id="price_c" name="price_c" class="form-control rupiahformat text-right" value="<?= $rak['price_c'] ?>" autocomplete="off"></td>
                                                <td class="text-center">Ton</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">4.</td>
                                                <td class="text-left">Batu Split 1 - 2</td>
                                                <td class="text-right"><input type="text" id="vol_produk_d" name="vol_produk_d" class="form-control numberformat text-right" value="<?php echo number_format($rak["vol_produk_d"],2,',','.');?>" onchange="changeData(1)"  autocomplete="off"></td>
                                                <td class="text-right"><input type="text" id="price_d" name="price_d" class="form-control rupiahformat text-right" value="<?= $rak['price_d'] ?>" autocomplete="off"></td>
                                                <td class="text-center">Ton</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">5.</td>
                                                <td class="text-left">Batu Split 2 - 3</td>
                                                <td class="text-right"><input type="text" id="vol_produk_e" name="vol_produk_e" class="form-control numberformat text-right" value="<?php echo number_format($rak["vol_produk_e"],2,',','.');?>" onchange="changeData(1)"  autocomplete="off"></td>
                                                <td class="text-right"><input type="text" id="price_e" name="price_e" class="form-control rupiahformat text-right" value="<?= $rak['price_e'] ?>" autocomplete="off"></td>
                                                <td class="text-center">Ton</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" class="text-right">GRAND TOTAL</td>
                                                <td>
                                                <input type="text" id="sub-total-val" name="sub_total" value="0" class="form-control numberformat tex-left text-right" readonly="">
                                                </td>
                                                <td></td>
                                            </tr> 
                                        </tfoot>
                                    </table>
									<br />
                                    <table id="table-product" class="table table-bordered table-striped table-condensed table-center">
                                        <thead>
                                            <tr class="text-center">
                                                <th width="5%">NO.</th>
                                                <th width="15%">KEBUTUHAN BAHAN</th>
                                                <th width="10%">VOLUME</th>
                                                <th width="40%">PENAWARAN</th>
                                                <th width="30%">HARGA SATUAN</th>                                 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">1.</td>
                                                <td>Boulder</td>
                                                <td class="text-right"><input type="text" id="vol_boulder" name="vol_boulder" class="form-control numberformat text-right" value="<?php echo number_format($rak["vol_boulder"],2,',','.');?>" autocomplete="off"></td>
                                                <td class="text-center"><select id="penawaran_id_boulder" name="penawaran_id_boulder" class="form-control">
                                                    <option value="">Pilih Penawaran</option>
                                                    <?php

                                                    foreach ($boulder as $key => $sm) {
                                                        ?>
                                                        <option value="<?php echo $sm['penawaran_id'];?>" data-supplier_id="<?php echo $sm['supplier_id'];?>" data-measure="<?php echo $sm['measure'];?>" data-price="<?php echo $sm['price'];?>" data-tax_id="<?php echo $sm['tax_id'];?>" data-tax="<?php echo $sm['tax'];?>" data-penawaran_id="<?php echo $sm['penawaran_id'];?>"><?php echo $sm['nama'];?> - <?php echo $sm['nomor_penawaran'];?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                </td>
                                                <td>
                                                    <input type="text" id="price_boulder" name="price_boulder" class="form-control rupiahformat text-right" value=""  readonly="" autocomplete="off">
                                                    <input type="hidden" id="measure_boulder" name="measure_boulder" class="form-control text-right" value=""  readonly="" autocomplete="off">
                                                    <input type="hidden" id="tax_id_boulder" name="tax_id_boulder" class="form-control text-right" value=""  readonly="" autocomplete="off">
                                                    <input type="hidden" id="pajak_id_boulder" name="pajak_id_boulder" class="form-control text-right" value=""  readonly="" autocomplete="off">
                                                    <input type="hidden" id="supplier_id_boulder" name="supplier_id_boulder" class="form-control text-right" value=""  readonly="" autocomplete="off">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="text-center">5.</td>
                                                <td>BBM Solar</td>
                                                <td class="text-right"><input type="text" id="vol_bbm_solar" name="vol_bbm_solar" class="form-control numberformat text-right" value="<?php echo number_format($rak["vol_bbm_solar"],2,',','.');?>" autocomplete="off"></td>
                                                <td class="text-center"><select id="penawaran_id_solar" name="penawaran_id_solar" class="form-control">
                                                    <option value="">Pilih Penawaran</option>
                                                    <?php

                                                    foreach ($solar as $key => $sm) {
                                                        ?>
                                                        <option value="<?php echo $sm['penawaran_id'];?>" data-supplier_id="<?php echo $sm['supplier_id'];?>" data-measure="<?php echo $sm['measure'];?>" data-price="<?php echo $sm['price'];?>" data-tax_id="<?php echo $sm['tax_id'];?>" data-tax="<?php echo $sm['tax'];?>" data-pajak_id="<?php echo $sm['pajak_id'];?>" data-pajak="<?php echo $sm['pajak'];?>" data-penawaran_id="<?php echo $sm['penawaran_id'];?>"><?php echo $sm['nama'];?> - <?php echo $sm['nomor_penawaran'];?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                </td>
                                                <td>
                                                    <input type="text" id="price_solar" name="price_solar" class="form-control rupiahformat text-right" value=""  readonly="" autocomplete="off">
                                                    <input type="hidden" id="measure_solar" name="measure_solar" class="form-control text-right" value=""  readonly="" autocomplete="off">
                                                    <input type="hidden" id="tax_id_solar" name="tax_id_solar" class="form-control text-right" value=""  readonly="" autocomplete="off">
                                                    <input type="hidden" id="pajak_id_solar" name="pajak_id_solar" class="form-control text-right" value=""  readonly="" autocomplete="off">
                                                    <input type="hidden" id="supplier_id_solar" name="supplier_id_solar" class="form-control text-right" value=""  readonly="" autocomplete="off">
                                                </td>
                                            </tr>
                                               
                                        </tbody>
                                    </table>
                                    <br />
                                    <table id="table-product" class="table table-bordered table-striped table-condensed table-center">
                                        <thead>
                                            <tr class="text-center">
                                                <th width="5%">NO.</th>
                                                <th width="45%">BUA</th>
                                                <th width="50%">NILAI</th>                                 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">1.</td>
                                                <td>BUA</td>
                                                <td colspan="2">
                                                    <input type="text" id="overhead" name="overhead" class="form-control rupiahformat text-right" value=""  autocomplete="off">
                                                </td>
                                            </tr>		
                                        </tbody>
                                    </table>  
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <a href="<?= site_url('admin/rencana_kerja');?>" class="btn btn-danger" style="margin-bottom:0px; width:10%; font-weight:bold; border-radius:10px;"><i class="fa fa-close"></i> Batal</a>
                                            <button type="submit" class="btn btn-success" style="width:10%; font-weight:bold; border-radius:10px;"><i class="fa fa-send"></i> Kirim</button>
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

        $('input.numberformat').number(true, 2,',','.' );
        $('input.rupiahformat').number(true, 0,',','.' );

        $('.dtpicker').daterangepicker({
            singleDatePicker: true,
            showDropdowns : true,
            locale: {
              format: 'DD-MM-YYYY'
            }
        });
        $('.dtpicker').on('apply.daterangepicker', function(ev, picker) {
              $(this).val(picker.startDate.format('DD-MM-YYYY'));
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

        function changeData(id)
        {
			var vol_produk_a = $('#vol_produk_a').val();
            var vol_produk_b = $('#vol_produk_b').val();
            var vol_produk_c = $('#vol_produk_c').val();
            var vol_produk_d = $('#vol_produk_d').val();
            var vol_produk_e = $('#vol_produk_e').val();

			vol_produk_a = ( vol_produk_a);
            $('#vol_produk_a').val(vol_produk_a);
            vol_produk_b = ( vol_produk_b);
            $('#vol_produk_b').val(vol_produk_b);
            vol_produk_c = ( vol_produk_c);
            $('#vol_produk_c').val(vol_produk_c);
            vol_produk_d = ( vol_produk_d);
            $('#vol_produk_d').val(vol_produk_d);
            vol_produk_e = ( vol_produk_e);
            $('#vol_produk_e').val(vol_produk_e);
            getTotal();
        }

        function getTotal()
        {
            var sub_total = $('#sub-total-val').val();

            sub_total = parseFloat($('#vol_produk_a').val()) + parseFloat($('#vol_produk_b').val()) + parseFloat($('#vol_produk_c').val()) + parseFloat($('#vol_produk_d').val()) + parseFloat($('#vol_produk_e').val());
            
            $('#sub-total-val').val(sub_total);
            $('#sub-total').text($.number( sub_total, 2,',','.' ));

            total_total = parseFloat(sub_total);
            $('#total-val').val(total_total);
            $('#total').text($.number( total_total, 2,',','.' ));
        }

        $(document).ready(function(){

            $('#penawaran_id_boulder').val(<?= $rak['penawaran_id_boulder'];?>).trigger('change');
            $('#penawaran_id_solar').val(<?= $rak['penawaran_id_solar'];?>).trigger('change');
        });

        $('#penawaran_id_boulder').change(function(){
            var penawaran_id = $(this).find(':selected').data('penawaran_id');
            $('#penawaran_id_boulder').val(penawaran_id);
			var price = $(this).find(':selected').data('price');
            $('#price_boulder').val(price);
            var supplier_id = $(this).find(':selected').data('supplier_id');
            $('#supplier_id_boulder').val(supplier_id);
            var measure = $(this).find(':selected').data('measure');
            $('#measure_boulder').val(measure);
            var tax_id = $(this).find(':selected').data('tax_id');
            $('#tax_id_boulder').val(tax_id);
            var pajak_id = $(this).find(':selected').data('pajak_id');
            $('#pajak_id_boulder').val(pajak_id);
        });

        $('#penawaran_id_solar').change(function(){
            var penawaran_id = $(this).find(':selected').data('penawaran_id');
            $('#penawaran_id_solar').val(penawaran_id);
			var price = $(this).find(':selected').data('price');
            $('#price_solar').val(price);
            var supplier_id = $(this).find(':selected').data('supplier_id');
            $('#supplier_id_solar').val(supplier_id);
            var measure = $(this).find(':selected').data('measure');
            $('#measure_solar').val(measure);
            var tax_id = $(this).find(':selected').data('tax_id');
            $('#tax_id_solar').val(tax_id);
            var pajak_id = $(this).find(':selected').data('pajak_id');
            $('#pajak_id_solar').val(pajak_id);
        });

        $(document).ready(function(){
            $('#overhead').val(<?= $rak['overhead'];?>).trigger('change');
        });

    </script>


</body>
</html>
