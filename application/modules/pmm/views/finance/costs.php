<!doctype html>
<html lang="en" class="fixed">
<head>
    <?php echo $this->Templates->Header();?>
    <style>
        body {
            font-family: helvetica;
        }
    </style>
</head>

<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />

<body>
<div class="wrap">
    
    <?php echo $this->Templates->PageHeader();?>

    <div class="page-body">
        <?php echo $this->Templates->LeftBar();?>
        <div class="content">
            <div class="content-header">
                <div class="leftside-content-header">
                    <ul class="breadcrumbs">
                        <li><a><i class="fa fa-home" aria-hidden="true"></i>Dashboard</a></li>
                        <li><a>Biaya</a></li>
                    </ul>
                </div>
            </div>
            <div class="row animated fadeInUp">
                <div class="col-sm-12 col-lg-12">
                    <div class="panel" style="background: linear-gradient(90deg, #f8f8f8 20%, #dddddd 40%, #f8f8f8 80%);">
                        <div class="panel-header">
                            <h3 class="section-subtitle">Biaya</h3>
                        </div>
                        <div class="panel-content">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="<?= base_url("pmm/biaya/tambah_biaya") ?>" class="btn btn-info" style="border-radius:10px; font-weight:bold;"><i class="fa fa-plus"></i> Buat Biaya Umum & Adm.</a>
                                </div>
                            </div>
                            <ul class="nav nav-tabs" role="tablist">
                                <?php
                                if(in_array($this->session->userdata('admin_group_id'), array(1,5,6,9,13))){
                                ?>
                                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab" style="border-radius:10px 0px 10px 0px; font-weight:bold;">Biaya Umum & Adm.</a></li>
                                <?php
                                }
                                ?>

                                <?php
                                if(in_array($this->session->userdata('admin_group_id'), array(7,10,11,12,14,15,16,17))){
                                ?>
                                <li role="presentation" class="active"><a href="#home_2" aria-controls="home_2" role="tab" data-toggle="tab" style="border-radius:10px 0px 10px 0px; font-weight:bold;">Bulan Ini</a></li>
                                <li role="presentation"><a href="#home_3" aria-controls="home_3" role="tab" data-toggle="tab" style="border-radius:10px 0px 10px 0px; font-weight:bold;">Semua</a></li>
                                <?php
                                }
                                ?>
                            </ul>
                            <div class="tab-content">
                                <?php
                                if(in_array($this->session->userdata('admin_group_id'), array(1,5,6,9,13))){
                                ?>
                                <div role="tabpanel" class="tab-pane active" id="home">
                                    <br />
                                    <div class="col-sm-4">
                                        <input type="text" id="filter_date_biaya" name="filter_date" class="form-control dtpickerange" autocomplete="off" placeholder="Filter By Date">
                                    </div>
                                    <br /><br />
                                    <div class="table-responsive">
                                        <h3 class="text-center"></h3>
                                        <div class="table-responsive">
                                                <table class="table table-striped table-hover" id="table_biaya" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Tanggal</th>
                                                            <th>Nomor</th>
                                                            <th>Penerima</th>
                                                            <th>Total</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    
                                                    </tbody>
                                                </table>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>

                                <?php
                                if(in_array($this->session->userdata('admin_group_id'), array(7,10,11,12,14,15,16,17))){
                                ?>
                                <div role="tabpanel" class="tab-pane active" id="home_2">
                                    <br />
                                    <div class="col-sm-3">
                                        <input type="text" id="filter_date_biaya_2" name="filter_date" class="form-control dtpickerange" autocomplete="off" placeholder="Filter By Date">
                                    </div>
                                    <button style="background-color:#88b93c; border:1px solid black; border-radius:10px; line-height:30px;"><a href="<?php echo site_url('pmm/biaya/tambah_biaya'); ?>"><b style="color:white;">BUAT BIAYA BUA</b></a></button>
                                    <br />
                                    <br />
                                    <h3 class="text-center"></h3>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover" id="table_biaya_2" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Nomor</th>
                                                    <th>Penerima</th>
                                                    <th>Total</th>
                                                    <th>Status</th>
                                                </tr> 
                                            </thead>
                                            <tbody>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="home_3">
                                    <br />
                                    <div class="col-sm-3">
                                        <input type="text" id="filter_date_biaya_3" name="filter_date" class="form-control dtpickerange" autocomplete="off" placeholder="Filter By Date">
                                    </div>
                                    <button style="background-color:#88b93c; border:1px solid black; border-radius:10px; line-height:30px;"><a href="<?php echo site_url('pmm/biaya/tambah_biaya'); ?>"><b style="color:white;">BUAT BIAYA BUA</b></a></button>
                                    <br />
                                    <br />
                                    <h3 class="text-center"></h3>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover" id="table_biaya_3" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Nomor</th>
                                                    <th>Penerima</th>
                                                    <th>Total</th>
                                                    <th>Status</th>
                                                </tr> 
                                            </thead>
                                            <tbody>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>

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
        var form_control = '';
    </script>
	
    <script>
    let po = [];
    let dataPo = 0;
    function cekPO(th){
        let lengthDataChecked = $('input:checkbox:checked').length;
        if(lengthDataChecked == 0){
            po = [];
        }
        if($(th).is(":checked")){
            po.push($(th).attr('data-po'));
            if($(th).attr('data-po') != po[0] ){
                $(th).prop("checked", false);
                alert("Nomor PO yang anda pilih tidak sama !");
            }
        }
        else if($(th).is(":not(:checked)")){
                
        }
    }
    // }, 1000);
    </script>
	
    <script type="text/javascript">

        $('input.numberformat').number( true, 2,',','.' );
        
        $('.dtpicker').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'DD-MM-YYYY'
            }
        });
        $('.dtpicker').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY'));
            // table.ajax.reload();
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
		
        var table_biaya = $('#table_biaya').DataTable( {"bAutoWidth": false,
            ajax: {
                processing: true,
                serverSide: true,
                url: '<?php echo site_url('pmm/biaya/table_biaya');?>',
                type : 'POST',
				data: function(d) {
                    d.filter_date = $('#filter_date_biaya').val();
                }
            },
            columns: [
                { "data": "no" },
                { "data": "tanggal"},
                { "data": "nomor_transaksi" },
                { "data": "penerima" },
                { "data": "jumlah_total" },
                { "data": "status"}
            ],
            "columnDefs": [
                { "width": "5%", "targets": 0, "className": 'text-center'},
                { "targets": 4, "className": 'text-right'},
            ],
            responsive: true,
            pageLength: 25,
        });
		
		$('#filter_date_biaya').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
        table_biaya.ajax.reload();
		});

        $(function (){
            $("#btn_production").click(function(e){
                var checked = $("#table-production input[type=checkbox]:checked").length;
                
                if (checked > 0) {
                    let data = "";
                    $('input[type=checkbox]').each(function () {
                        data += (this.checked ? ($(this).val()+",") : "");
                    });
                    cekLenth = data.length-1;
                    data = data.substring(0,cekLenth);
                    window.location = "<?= base_url('pmm/finance/penagihan_penjualan/') ?>"+data;
                } else {
                    alert("Anda harus memilih data terlebih dahulu");
                    return false;
                }
               
            });
        });

        // alert("oke");
        


        function OpenForm(id='')
        {   
            
            $('#modalForm').modal('show');
            $('#id').val('');
            // table_detail.ajax.reload();
            if(id !== ''){
                $('#id').val(id);
                getData(id);
            }
        }

        $('#modalForm form').submit(function(event){
            $('#btn-form').button('loading');
            $.ajax({
                type    : "POST",
                url     : "<?php echo site_url('pmm/form_client'); ?>/"+Math.random(),
                dataType : 'json',
                data: $(this).serialize(),
                success : function(result){
                    $('#btn-form').button('reset');
                    if(result.output){
                        $("#modalForm form").trigger("reset");
                        table.ajax.reload();
                        $('#modalForm').modal('hide');
                    }else if(result.err){
                        bootbox.alert(result.err);
                    }
                }
            });

            event.preventDefault();
            
        });

        function getData(id)
        {
            $.ajax({
                type    : "POST",
                url     : "<?php echo site_url('pmm/get_client'); ?>",
                dataType : 'json',
                data: {id:id},
                success : function(result){
                    if(result.output){
                        $('#id').val(result.output.id);
                        $('#client_name').val(result.output.client_name);
                        $('#contract').val(result.output.contract);
                        $('#status').val(result.output.status);
                    }else if(result.err){
                        bootbox.alert(result.err);
                    }
                }
            });
        }


        function DeleteData(id)
        {
            bootbox.confirm("Apakah Anda yakin untuk menghapus data ini ?", function(result){ 
                // console.log('This was logged in the callback: ' + result); 
                if(result){
                    $.ajax({
                        type    : "POST",
                        url     : "<?php echo site_url('pmm/delete_client'); ?>",
                        dataType : 'json',
                        data: {id:id},
                        success : function(result){
                            if(result.output){
                                table.ajax.reload();
                                bootbox.alert('Berhasil menghapus!!');
                            }else if(result.err){
                                bootbox.alert(result.err);
                            }
                        }
                    });
                }
            });
        }
        
        var table_biaya_2 = $('#table_biaya_2').DataTable( {"bAutoWidth": false,
            ajax: {
                processing: true,
                serverSide: true,
                url: '<?php echo site_url('pmm/biaya/table_biaya_2');?>',
                type : 'POST',
				data: function(d) {
                    d.filter_date = $('#filter_date_biaya_2').val();
                }
            },
            columns: [
                { "data": "no" },
                { "data": "tanggal"},
                { "data": "nomor_transaksi" },
                { "data": "penerima" },
                { "data": "jumlah_total" },
                { "data": "status"}
            ],
            "columnDefs": [
                { "width": "5%", "targets": 0, "className": 'text-center'},
                { "targets": 4, "className": 'text-right'},
            ],
            responsive: true,
            pageLength: 25,
        });
		
		$('#filter_date_biaya_2').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
            table_biaya_2.ajax.reload();
		});

        var table_biaya_3 = $('#table_biaya_3').DataTable( {"bAutoWidth": false,
            ajax: {
                processing: true,
                serverSide: true,
                url: '<?php echo site_url('pmm/biaya/table_biaya_3');?>',
                type : 'POST',
				data: function(d) {
                    d.filter_date = $('#filter_date_biaya_3').val();
                }
            },
            columns: [
                { "data": "no" },
                { "data": "tanggal"},
                { "data": "nomor_transaksi" },
                { "data": "penerima" },
                { "data": "jumlah_total" },
                { "data": "status"}
            ],
            "columnDefs": [
                { "width": "5%", "targets": 0, "className": 'text-center'},
                { "targets": 4, "className": 'text-right'},
            ],
            responsive: true,
            pageLength: 25,
        });
		
		$('#filter_date_biaya_3').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
            table_biaya_3.ajax.reload();
		});
    </script>
    
	<script type="text/javascript">
        var form_control = '';
    </script>

</body>
</html>
