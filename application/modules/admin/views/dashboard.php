<!doctype html>
<html lang="en" class="fixed">
    <head>
    <?php echo $this->Templates->Header();?>
    </head>
    <script src="https://kit.fontawesome.com/591a1bf2f6.js" crossorigin="anonymous"></script>
    <style type="text/css">
        body {
            font-family: helvetica;
        }

        a:hover {
            color: white;
        }

        .chart-container{
            position: relative; max-width: 100%; height:350px; background: #fff;
        }
        
        .highcharts-figure,
        .highcharts-data-table table {
        min-width: 65%;
        max-width: 100%;
        }

        .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #ebebeb;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
        }

        .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
        }

        .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
        padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
        background: #f1f7ff;
        }

        blink {
        -webkit-animation: 2s linear infinite kedip; /* for Safari 4.0 - 8.0 */
        animation: 2s linear infinite kedip;
        }
        /* for Safari 4.0 - 8.0 */
        @-webkit-keyframes kedip { 
        0% {
            visibility: hidden;
        }
        50% {
            visibility: hidden;
        }
        100% {
            visibility: visible;
        }
        }
        @keyframes kedip {
        0% {
            visibility: hidden;
        }
        50% {
            visibility: hidden;
        }
        100% {
            visibility: visible;
        }
        }
    </style>
    <body>
        <div class="wrap">
            
            <?php echo $this->Templates->PageHeader();?>
            
            <div class="page-body">
                <?php echo $this->Templates->LeftBar();?>
                <div class="content">
                    <div class="content-header">
                        <div class="leftside-content-header">
                            <ul class="breadcrumbs">
                                <li><i class="fa fa-home" aria-hidden="true"></i><a href="#">Dashboard</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="content-body">
                        <div class="row animated fadeInUp">
                            <?php include_once("script_dashboard.php"); ?>
                            <?php
                            if(in_array($this->session->userdata('admin_group_id'), array(1,5,6,15))){
                            ?>
                            <div class="col-sm-12" style="background:#fff;background-image:linear-gradient(to right,#999999 0%,#333333 51%,#666666 100%); font-size:18px; border-radius: 10px; padding:10px; margin-bottom:50px;">
                                <figure class="highcharts-figure">
                                    <?php
                                    $query1 = $this->db->select('COUNT(pvp.id) as id')
                                    ->from('pmm_verifikasi_penagihan_pembelian pvp')
                                    ->where("pvp.approve_unit_head = 'TIDAK DISETUJUI'")
                                    ->get()->row_array();

                                    $query2 = $this->db->select('COUNT(ppo.id) as id')
                                    ->from('pmm_purchase_order ppo')
                                    ->where("ppo.status = 'WAITING'")
                                    ->get()->row_array();
                                    
                                    $query = $query1['id'] + $query2['id'];
                                    ?>
                                        <center><b><a target="_blank" href="<?= base_url("pmm/reports/detail_notification/") ?>"><i class="fa-solid fa-clipboard-check"></i> BUTUH PERSETUJUAN KANTOR PUSAT (<blink><?php echo number_format($query,0,',','.');?></blink>)</a><b></center>
                                
                                    <?php
                                    $query = $this->db->select('COUNT(req.id) as id')
                                    ->from('pmm_request_materials req')
                                    ->where("req.status = 'WAITING'")
                                    ->get()->row_array();
                                    
                                    $query = $query['id'];
                                    ?>
                                        <center><b><a target="_blank" href="<?= base_url("pmm/reports/detail_notification_2/") ?>"><i class="fa-solid fa-clipboard-check"></i> BUTUH PERSETUJUAN KA. UNIT BISNIS (<blink><?php echo number_format($query,0,',','.');?></blink>)</a><b></center>
                                    
                                    <!--<?php
                                    if(in_array($this->session->userdata('admin_group_id'), array(1))){
                                    ?>
                                    <?php
                                    $query = $this->db->select('COUNT(id) as id')
                                    ->from('perubahan_sistem')
                                    ->where("status = 'UNPUBLISH'")
                                    ->get()->row_array();
                                    
                                    $query = $query['id'];
                                    ?>
                                        <center><a target="_blank" href="<?= base_url("pmm/reports/detail_notification_3/") ?>"><i class="fa-solid fa-clipboard-check"></i> BUTUH PERSETUJUAN TI & SISTEM (<blink><?php echo number_format($query,0,',','.');?></blink>)</a></center>
                                    <?php
                                    }
                                    ?>-->
                                </figure>    
                            </div>
                            <?php
                            }
                            ?>

                            <br /><br />

                            <div class="col-sm-12">
                                <figure class="highcharts-figure">
                                    <div id="container_laba_rugi_rap" style="border-radius:10px;"></div>
                                    
                                </figure>
                                <br />
                            </div>

                            <div class="col-sm-12">
                                <figure class="highcharts-figure">
                                    <div id="container_evaluasi_bahan" style="border-radius:10px;"></div>
                                    
                                </figure>
                                <br />
                            </div>

                            <div class="col-sm-12">
                                <figure class="highcharts-figure">
                                    <div id="container_evaluasi_alat" style="border-radius:10px;"></div>
                                    
                                </figure>
                                <br />
                            </div>

                            <div class="col-sm-12">
                                <figure class="highcharts-figure">
                                    <div id="container_evaluasi_overhead" style="border-radius:10px;"></div>
                                    
                                </figure>
                                <br />
                            </div>

                            <!-- RAP -->
                            <div class="col-sm-8">			
                                <div role="tabpanel" class="tab-pane" id="rap">
                                    <div class="col-sm-15">
                                    <div class="panel" style="border-radius:10px;">
                                            <div class="panel-heading">
                                                <center><h3 class="panel-title">RAP</h3></center>
                                            </div>
                                            <div style="margin: 20px">
                                                <div id="wait" style=" text-align: center; align-content: center; display: none;">	
                                                    <div>Mohon Tunggu</div>
                                                    <div class="fa-3x">
                                                        <i class="fa fa-spinner fa-spin"></i>
                                                    </div>
                                                </div>				
                                                <div class="table-responsive" id="box-new-rap">
                
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

        <?php echo $this->Templates->Footer();?>
        <script src="<?php echo base_url();?>assets/back/theme/vendor/toastr/toastr.min.js"></script>
        <script src="<?php echo base_url();?>assets/back/theme/vendor/chart-js/chart.min.js"></script>
        <script src="<?php echo base_url();?>assets/back/theme/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
        <script src="<?php echo base_url();?>assets/back/theme/vendor/daterangepicker/moment.min.js"></script>
        <script src="<?php echo base_url();?>assets/back/theme/vendor/number_format.js"></script>
        <script src="<?php echo base_url();?>assets/back/theme/vendor/daterangepicker/daterangepicker.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/back/theme/vendor/daterangepicker/daterangepicker.css">
        <script type="text/javascript" src="<?php echo base_url();?>assets/back/theme/vendor/chart-js/chart.min.js"></script>

        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/series-label.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>

        <script type="text/javascript">
            $(function () {
                var chart;
                $(document).ready(function() {
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'container_laba_rugi_rap',
                            type: 'column',
                            marginRight: 130,
                            marginBottom: 75,
                            backgroundColor: {
                                linearGradient: [0, 0, 700, 500],
                                stops: [
                                    [0, 'rgb(226,226,226)'],
                                    [1, 'rgb(214,214,214)']
                                ]
                            },
                        },
                        title: {
                            style: {
                                color: '#000000',
                                fontWeight: 'bold',
                                fontSize: '14px',
                                fontFamily: 'helvetica'
                            },
                            text: 'PRESENTASE LABA RUGI X RAP',
                            x: -20 //center            
                        },
                        subtitle: {
                            style: {
                                color: '#000000',
                                fontWeight: 'bold',
                                fontSize: '14px',
                                fontFamily: 'helvetica'
                            },
                            text: ''.toUpperCase(),
                            x: -20
                        },
                        xAxis: { //X axis menampilkan data bulan
                            labels: {
                                style: {
                                    color: '#000000',
                                    fontWeight: 'bold',
                                    fontSize: '10px',
                                    fontFamily: 'helvetica'
                                }
                            },
                            categories: ['Januari 25','Februari 25','Maret 25','April 25','Mei 25','Juni 25']
                            //categories: ['Januari 25','Februari 25','Maret 25','April 25','Mei 25','Juni 25','Juli 25','Agustus 25','September 25','Oktober 25','November 25','Desember 25']
                        },
                        yAxis: {
                            //title: {  //label yAxis
                                //text: 'RAP <br /><?php echo number_format(0,0,',','.'); ?>'
                                //text: 'Presentase'
                            //},
                            title: {
                                style: {
                                    color: '#000000',
                                    fontWeight: 'bold',
                                    fontSize: '10px',
                                    fontFamily: 'helvetica'
                                },
                                text: 'Presentase'           
                            },
                            plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080' //warna dari grafik line
                            }],
                            labels: {
                                style: {
                                    color: '#000000',
                                    fontWeight: 'bold',
                                    fontSize: '10px',
                                    fontFamily: 'helvetica'
                                },
                                format: '{value}'
                            },
                            min: -100,
                            max: 100,
                            tickInterval: 20,
                        },
                        tooltip: { 
                        //fungsi tooltip, ini opsional, kegunaan dari fungsi ini 
                        //akan menampikan data di titik tertentu di grafik saat mouseover
                            formatter: function() {
                                    return '<b>'+ this.series.name +'</b><br/>'+ 
                                    ''+ 'Presentase' +': '+ this.y + ' %<br/>';
                                    //''+ 'Vol' +': '+ this.x + '';

                                    //'<b>'+ 'Presentase' +': '+ this.y +'%'</b><br/>'+ 
                                    //'<b>'+ 'Penjualan' +': '+ this.y +'</b><br/>';
                            }
                        },
                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'top',
                            x: -10,
                            y: 100,
                            borderWidth: 0
                        },

                        plotOptions: {
                            spline: {
                                lineWidth: 4,
                                states: {
                                    hover: {
                                        lineWidth: 5
                                    }
                                },
                                marker: {
                                    enabled: true
                                }
                            }
                        },
                
                        series: [{  
                            name: 'RAP',  
                        
                            data: [<?php echo number_format($persentase_laba_kotor_rap_januari25_fix,2,'.',',');?>,<?php echo number_format($persentase_laba_kotor_rap_februari25_fix,2,'.',',');?>,<?php echo number_format($persentase_laba_kotor_rap_maret25_fix,2,'.',',');?>,<?php echo number_format($persentase_laba_kotor_rap_april25_fix,2,'.',',');?>,<?php echo number_format($persentase_laba_kotor_rap_mei25_fix,2,'.',',');?>,<?php echo number_format($persentase_laba_kotor_rap_juni25_fix,2,'.',',');?>],

                            color: '#000000 ',
                            fontWeight: 'bold',
                            fontSize: '10px',
                            fontFamily: 'helvetica'
                        },
                        {  
                            name: 'Realisasi',  
                            
                            data: [<?php echo number_format($persentase_laba_kotor_januari25_fix,2,'.',',');?>,<?php echo number_format($persentase_laba_kotor_februari25_fix,2,'.',',');?>,<?php echo number_format($persentase_laba_kotor_maret25_fix,2,'.',',');?>,<?php echo number_format($persentase_laba_kotor_april25_fix,2,'.',',');?>,<?php echo number_format($persentase_laba_kotor_mei25_fix,2,'.',',');?>,<?php echo number_format($persentase_laba_kotor_juni25_fix,2,'.',',');?>],

                            color: '#f44336',
                            fontWeight: 'bold',
                            fontSize: '10px',
                            fontFamily: 'helvetica',

                            zones: [{
                                
                            }, {
                                dashStyle: 'dot'
                            }]
                        }
                        ]
                    });
                });
                
            });
        </script>

        <script type="text/javascript">
            $(function () {
                var chart;
                $(document).ready(function() {
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'container_evaluasi_bahan',
                            type: 'column',
                            marginRight: 130,
                            marginBottom: 75,
                            backgroundColor: {
                                linearGradient: [0, 0, 700, 500],
                                stops: [
                                    [0, 'rgb(226,226,226)'],
                                    [1, 'rgb(214,214,214)']
                                ]
                            },
                        },
                        title: {
                            style: {
                                color: '#000000',
                                fontWeight: 'bold',
                                fontSize: '14px',
                                fontFamily: 'helvetica'
                            },
                            text: 'EVALUASI BAHAN',
                            x: -20 //center            
                        },
                        subtitle: {
                            style: {
                                color: '#000000',
                                fontWeight: 'bold',
                                fontSize: '14px',
                                fontFamily: 'helvetica'
                            },
                            text: ''.toUpperCase(),
                            x: -20
                        },
                        xAxis: { //X axis menampilkan data bulan
                            labels: {
                                style: {
                                    color: '#000000',
                                    fontWeight: 'bold',
                                    fontSize: '10px',
                                    fontFamily: 'helvetica'
                                }
                            },
                            categories: ['Januari 25','Februari 25','Maret 25','April 25','Mei 25','Juni 25']
                        },
                        yAxis: {
                            //title: {  //label yAxis
                                //text: 'RAP <br /><?php echo number_format(0,0,',','.'); ?>'
                                //text: 'Presentase'
                            //},
                            title: {
                                style: {
                                    color: '#000000',
                                    fontWeight: 'bold',
                                    fontSize: '10px',
                                    fontFamily: 'helvetica'
                                },
                                text: 'Nilai (Juta)'           
                            },
                            plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080' //warna dari grafik line
                            }],
                            labels: {
                                style: {
                                    color: '#000000',
                                    fontWeight: 'bold',
                                    fontSize: '10px',
                                    fontFamily: 'helvetica'
                                },
                                format: '{value}'
                            },
                            min: 0,
                            max: 500,
                            tickInterval: 50,
                        },
                        tooltip: { 
                        //fungsi tooltip, ini opsional, kegunaan dari fungsi ini 
                        //akan menampikan data di titik tertentu di grafik saat mouseover
                            formatter: function() {
                                    return '<b>'+ this.series.name +'</b><br/>'+ 
                                    ''+ 'Bahan' +': '+ this.y + ' Juta<br/>';
                                    //''+ 'Vol' +': '+ this.x + '';

                                    //'<b>'+ 'Presentase' +': '+ this.y +'%'</b><br/>'+ 
                                    //'<b>'+ 'Penjualan' +': '+ this.y +'</b><br/>';
                            }
                        },
                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'top',
                            x: -10,
                            y: 100,
                            borderWidth: 0
                        },

                        plotOptions: {
                            spline: {
                                lineWidth: 4,
                                states: {
                                    hover: {
                                        lineWidth: 5
                                    }
                                },
                                marker: {
                                    enabled: true
                                }
                            }
                        },
                
                        series: [{  
                            name: 'RAP',  
                        
                            data: [<?php echo json_encode($nilai_rap_bahan_januari25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($nilai_rap_bahan_februari25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($nilai_rap_bahan_maret25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($nilai_rap_bahan_april25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($nilai_rap_bahan_mei25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($nilai_rap_bahan_juni25_fix, JSON_NUMERIC_CHECK); ?>],

                            color: '#000000 ',
                            fontWeight: 'bold',
                            fontSize: '10px',
                            fontFamily: 'helvetica'
                        },
                        {  
                            name: 'Realisasi',  
                            
                            data: [<?php echo json_encode($total_nilai_produksi_boulder_januari25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($total_nilai_produksi_boulder_februari25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($total_nilai_produksi_boulder_maret25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($total_nilai_produksi_boulder_april25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($total_nilai_produksi_boulder_mei25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($total_nilai_produksi_boulder_juni25_fix, JSON_NUMERIC_CHECK); ?>],

                            color: '#f44336',
                            fontWeight: 'bold',
                            fontSize: '10px',
                            fontFamily: 'helvetica',

                            zones: [{
                                
                            }, {
                                dashStyle: 'dot'
                            }]
                        }
                        ]
                    });
                });
                
            });
        </script>

        <script type="text/javascript">
            $(function () {
                var chart;
                $(document).ready(function() {
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'container_evaluasi_alat',
                            type: 'column',
                            marginRight: 130,
                            marginBottom: 75,
                            backgroundColor: {
                                linearGradient: [0, 0, 700, 500],
                                stops: [
                                    [0, 'rgb(226,226,226)'],
                                    [1, 'rgb(214,214,214)']
                                ]
                            },
                        },
                        title: {
                            style: {
                                color: '#000000',
                                fontWeight: 'bold',
                                fontSize: '14px',
                                fontFamily: 'helvetica'
                            },
                            text: 'EVALUASI ALAT',
                            x: -20 //center            
                        },
                        subtitle: {
                            style: {
                                color: '#000000',
                                fontWeight: 'bold',
                                fontSize: '14px',
                                fontFamily: 'helvetica'
                            },
                            text: ''.toUpperCase(),
                            x: -20
                        },
                        xAxis: { //X axis menampilkan data bulan
                            labels: {
                                style: {
                                    color: '#000000',
                                    fontWeight: 'bold',
                                    fontSize: '10px',
                                    fontFamily: 'helvetica'
                                }
                            },
                            categories: ['Januari 25','Februari 25','Maret 25','April 25','Mei 25','Juni 25']
                        },
                        yAxis: {
                            //title: {  //label yAxis
                                //text: 'RAP <br /><?php echo number_format(0,0,',','.'); ?>'
                                //text: 'Presentase'
                            //},
                            title: {
                                style: {
                                    color: '#000000',
                                    fontWeight: 'bold',
                                    fontSize: '10px',
                                    fontFamily: 'helvetica'
                                },
                                text: 'Nilai (Juta)'           
                            },
                            plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080' //warna dari grafik line
                            }],
                            labels: {
                                style: {
                                    color: '#000000',
                                    fontWeight: 'bold',
                                    fontSize: '10px',
                                    fontFamily: 'helvetica'
                                },
                                format: '{value}'
                            },
                            min: 0,
                            max: 250,
                            tickInterval: 50,
                        },
                        tooltip: { 
                        //fungsi tooltip, ini opsional, kegunaan dari fungsi ini 
                        //akan menampikan data di titik tertentu di grafik saat mouseover
                            formatter: function() {
                                    return '<b>'+ this.series.name +'</b><br/>'+ 
                                    ''+ 'Alat' +': '+ this.y + ' Juta<br/>';
                                    //''+ 'Vol' +': '+ this.x + '';

                                    //'<b>'+ 'Presentase' +': '+ this.y +'%'</b><br/>'+ 
                                    //'<b>'+ 'Penjualan' +': '+ this.y +'</b><br/>';
                            }
                        },
                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'top',
                            x: -10,
                            y: 100,
                            borderWidth: 0
                        },

                        plotOptions: {
                            spline: {
                                lineWidth: 4,
                                states: {
                                    hover: {
                                        lineWidth: 5
                                    }
                                },
                                marker: {
                                    enabled: true
                                }
                            }
                        },
                
                        series: [{  
                            name: 'RAP',  
                        
                            data: [<?php echo json_encode($nilai_rap_alat_januari25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($nilai_rap_alat_februari25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($nilai_rap_alat_maret25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($nilai_rap_alat_april25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($nilai_rap_alat_mei25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($nilai_rap_alat_juni25_fix, JSON_NUMERIC_CHECK); ?>],

                            color: '#000000 ',
                            fontWeight: 'bold',
                            fontSize: '10px',
                            fontFamily: 'helvetica'
                        },
                        {  
                            name: 'Realisasi',  
                            
                            data: [<?php echo json_encode($nilai_realisasi_alat_januari25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($nilai_realisasi_alat_februari25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($nilai_realisasi_alat_maret25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($nilai_realisasi_alat_april25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($nilai_realisasi_alat_mei25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($nilai_realisasi_alat_juni25_fix, JSON_NUMERIC_CHECK); ?>],

                            color: '#f44336',
                            fontWeight: 'bold',
                            fontSize: '10px',
                            fontFamily: 'helvetica',

                            zones: [{
                                
                            }, {
                                dashStyle: 'dot'
                            }]
                        }
                        ]
                    });
                });
                
            });
        </script>

        <script type="text/javascript">
            $(function () {
                var chart;
                $(document).ready(function() {
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'container_evaluasi_overhead',
                            type: 'column',
                            marginRight: 130,
                            marginBottom: 75,
                            backgroundColor: {
                                linearGradient: [0, 0, 700, 500],
                                stops: [
                                    [0, 'rgb(226,226,226)'],
                                    [1, 'rgb(214,214,214)']
                                ]
                            },
                        },
                        title: {
                            style: {
                                color: '#000000',
                                fontWeight: 'bold',
                                fontSize: '14px',
                                fontFamily: 'helvetica'
                            },
                            text: 'EVALUASI OVERHEAD',
                            x: -20 //center            
                        },
                        subtitle: {
                            style: {
                                color: '#000000',
                                fontWeight: 'bold',
                                fontSize: '14px',
                                fontFamily: 'helvetica'
                            },
                            text: ''.toUpperCase(),
                            x: -20
                        },
                        xAxis: { //X axis menampilkan data bulan
                            labels: {
                                style: {
                                    color: '#000000',
                                    fontWeight: 'bold',
                                    fontSize: '10px',
                                    fontFamily: 'helvetica'
                                }
                            },
                            categories: ['Januari 25','Februari 25','Maret 25','April 25','Mei 25','Juni 25']
                        },
                        yAxis: {
                            //title: {  //label yAxis
                                //text: 'RAP <br /><?php echo number_format(0,0,',','.'); ?>'
                                //text: 'Presentase'
                            //},
                            title: {
                                style: {
                                    color: '#000000',
                                    fontWeight: 'bold',
                                    fontSize: '10px',
                                    fontFamily: 'helvetica'
                                },
                                text: 'Nilai (Juta)'           
                            },
                            plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080' //warna dari grafik line
                            }],
                            labels: {
                                style: {
                                    color: '#000000',
                                    fontWeight: 'bold',
                                    fontSize: '10px',
                                    fontFamily: 'helvetica'
                                },
                                format: '{value}'
                            },
                            min: 0,
                            max: 250,
                            tickInterval: 50,
                        },
                        tooltip: { 
                        //fungsi tooltip, ini opsional, kegunaan dari fungsi ini 
                        //akan menampikan data di titik tertentu di grafik saat mouseover
                            formatter: function() {
                                    return '<b>'+ this.series.name +'</b><br/>'+ 
                                    ''+ 'Overhead' +': '+ this.y + ' Juta<br/>';
                                    //''+ 'Vol' +': '+ this.x + '';

                                    //'<b>'+ 'Presentase' +': '+ this.y +'%'</b><br/>'+ 
                                    //'<b>'+ 'Penjualan' +': '+ this.y +'</b><br/>';
                            }
                        },
                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'top',
                            x: -10,
                            y: 100,
                            borderWidth: 0
                        },

                        plotOptions: {
                            spline: {
                                lineWidth: 4,
                                states: {
                                    hover: {
                                        lineWidth: 5
                                    }
                                },
                                marker: {
                                    enabled: true
                                }
                            }
                        },
                
                        series: [{  
                            name: 'RAP',  
                        
                            data: [<?php echo json_encode($nilai_rap_overhead_januari25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($nilai_rap_overhead_februari25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($nilai_rap_overhead_maret25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($nilai_rap_overhead_april25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($nilai_rap_overhead_mei25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($nilai_rap_overhead_juni25_fix, JSON_NUMERIC_CHECK); ?>],

                            color: '#000000 ',
                            fontWeight: 'bold',
                            fontSize: '10px',
                            fontFamily: 'helvetica'
                        },
                        {  
                            name: 'Realisasi',  
                            
                            data: [<?php echo json_encode($nilai_realisasi_overhead_januari25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($nilai_realisasi_overhead_februari25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($nilai_realisasi_overhead_maret25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($nilai_realisasi_overhead_april25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($nilai_realisasi_overhead_mei25_fix, JSON_NUMERIC_CHECK); ?>,<?php echo json_encode($nilai_realisasi_overhead_juni25_fix, JSON_NUMERIC_CHECK); ?>],

                            color: '#f44336',
                            fontWeight: 'bold',
                            fontSize: '10px',
                            fontFamily: 'helvetica',

                            zones: [{
                                
                            }, {
                                dashStyle: 'dot'
                            }]
                        }
                        ]
                    });
                });
                
            });
        </script>

        <!-- Script RAP -->
        <script type="text/javascript">
            $('#filter_date_new_rap').daterangepicker({
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

            $('#filter_date_new_rap').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                TableNewRAP();
            });
            
            function TableNewRAP()
            {
                $('#wait').fadeIn('fast');   
                $.ajax({
                    type    : "POST",
                    url     : "<?php echo site_url('pmm/reports/new_rap_dashboard'); ?>/"+Math.random(),
                    dataType : 'html',
                    data: {
                        filter_date : $('#filter_date_new_rap').val(),
                    },
                    success : function(result){
                        $('#box-new-rap').html(result);
                        $('#wait').fadeOut('fast');
                    }
                });
            }

            TableNewRAP();
        </script>
    </body>
</html>
