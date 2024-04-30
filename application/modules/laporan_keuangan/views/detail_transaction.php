<!doctype html>
<html lang="en" class="fixed">
<head>
    <?php echo $this->Templates->Header();?>

    <style type="text/css">
        .table-center th, .table-center td{
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
                            <li><a>Dashboard</a></li>
                            <li><a>Neraca</a></li>
                            <li><a>Detail Transaksi</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row animated fadeInUp">
                    <div class="col-sm-12 col-lg-12">
                        <div class="panel">
                            <div class="panel-header"> 
                                <h3>Detail Transaksi</h3>
                            </div>
                            <div class="panel-content">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <table class="table table-bordered table-striped table-condensed">
                                            <tr style='background-color:#cccccc; font-weight:bold;'>
                                                <th class="text-center">Tanggal</th>
                                                <th class="text-center">Transaksi</th>
                                                <th class="text-center">Nomor</th>
                                                <th class="text-center">Debit</th>
                                                <th class="text-center">Kredit</th>
                                            </tr>
                                            <?php
                                            $total_biaya = 0;
                                            foreach ($row as $x) {
                                            ?> 
                                            <tr>
                                                <td class="text-center"><?php echo $x['tanggal_transaksi'];?></td>
                                                <td class="text-center">BIAYA</td>
                                                <td class="text-left"><a target="_blank" href="<?= base_url("pmm/biaya/detail_biaya/".$x['id']) ?>"><?php echo $x['nomor_transaksi'];?></a></td>
                                                <td class="text-right"><?php echo number_format($x['debit'],2,',','.');?></td>
                                                <td class="text-right"><?php echo number_format($x['kredit'],2,',','.');?></td>
                                            </tr>
                                            <?php
                                            $total_biaya += $x['kredit'];
                                            }
                                            ?>
                                            <?php
                                            $total_jurnal = 0;
                                            foreach ($row2 as $x) {
                                            ?> 
                                            <tr>
                                                <td class="text-center"><?php echo $x['tanggal_transaksi'];?></td>
                                                <td class="text-center">JURNAL UMUM</td>
                                                <td class="text-left"><a target="_blank" href="<?= base_url("pmm/jurnal_umum/detailJurnal/".$x['id_jurnal']) ?>"><?php echo $x['nomor_transaksi'];?></a></td>
                                                <td class="text-right"><?php echo number_format($x['debit'],2,',','.');?></td>
                                                <td class="text-right"><?php echo number_format($x['kredit'],2,',','.');?></td>
                                            </tr>
                                            <?php
                                            $total_jurnal_debit += $x['debit'];
                                            $total_jurnal += $x['kredit'];
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-right" colspan="3"><b>TOTAL</b></td>
                                                <td class="text-right"><b><?php echo number_format($total_jurnal_debit,2,',','.');?></b></td>
                                                <td class="text-right"><b><?php echo number_format($total_biaya + $total_jurnal,2,',','.');?></b></td>
                                            </tr>
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
    
    <script type="text/javascript">
        var form_control = '';
    </script>
    <?php echo $this->Templates->Footer();?>
    <script src="<?php echo base_url();?>assets/back/theme/vendor/jquery.number.min.js"></script>
    <script src="<?php echo base_url();?>assets/back/theme/vendor/bootbox.min.js"></script>
    
</body>
</html>
