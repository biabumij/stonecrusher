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
                            <li><a>Laporan Keuangan</a></li>
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
                                    <div class="col-sm-12">
                                        <table class="table table-bordered table-striped table-condensed">
                                            <tr style='background-color:#cccccc; font-weight:bold;'>
                                                <th class="text-center" width="11%">Tanggal</th>
                                                <th class="text-center" width="10%">Transaksi</th>
                                                <th class="text-center" width="10%">Biaya</th>
                                                <th class="text-center" width="10%">Jurnal</th>
                                                <th class="text-center" width="10%">Terima</th>
                                                <th class="text-center" width="10%">Transfer</th>
                                                <th class="text-center" width="13%">Debit</th>
                                                <th class="text-center" width="13%">Kredit</th>
                                                <th class="text-center" width="13%">Saldo</th>
                                            </tr>
                                            <?php
                                            $total_kredit = 0;
                                            $total_debit = 0;
                                            
                                            foreach ($row as $x) {

                                            if ($x['debit']==0) { $jumlah_debit = $x['debit'];} else
                                            {$jumlah_debit = $x['debit'];}

                                            if ($x['kredit']==0) { $jumlah_kredit = $x['kredit'];} else
                                            {$jumlah_kredit = $x['kredit'];}
                                            
                                            if ($jumlah_debit==0) { $jumlah_saldo = $jumlah_saldo + $jumlah_debit - $jumlah_kredit;} else
                                            {$jumlah_saldo = $jumlah_saldo + $jumlah_debit;}

                                            $trx_biaya = $this->db->select('t.akun as id, sum(t.debit) as debit, sum(t.kredit) as kredit')
                                            ->from('transactions t')
                                            ->where("t.tanggal_transaksi between '$date1' and '$date2'")
                                            ->where("t.akun = 1")
                                            ->group_by('t.akun')
                                            ->get()->row_array();
                                            ?> 
                                            <tr>
                                                <td class="text-center"><?php echo $x['tanggal_transaksi'];?></td>
                                                <td class="text-center"><?php echo $x['transaksi'];?></td>
                                                <td class="text-left"><a target="_blank" href="<?= base_url("pmm/biaya/detail_biaya/".$x['biaya_id']) ?>"><?php echo $x['trx_biaya'];?></a></td>
                                                <td class="text-left"><a target="_blank" href="<?= base_url("pmm/jurnal_umum/detailJurnal/".$x['jurnal_id']) ?>"><?php echo $x['trx_jurnal'];?></a></td>
                                                <td class="text-left"><a target="_blank" href="<?= base_url("pmm/finance/detailTerima/".$x['terima_id']) ?>"><?php echo $x['trx_terima'];?></a></td>
                                                <td class="text-left"><a target="_blank" href="<?= base_url("pmm/finance/detailTransfer/".$x['transfer_id']) ?>"><?php echo $x['trx_transfer'];?></a></td>
                                                <td class="text-right"><?php echo number_format($x['debit'],0,',','.');?></td>
                                                <td class="text-right"><?php echo number_format($x['kredit'],0,',','.');?></td>
                                                <td class="text-right"><?php echo number_format($jumlah_saldo,0,',','.');?></td>
                                            </tr>
                                            <?php
                                            $total_debit += $x['debit'];
                                            $total_kredit += $x['kredit'];
                                            }
                                            ?>

                                            <tr>
                                                <td class="text-right" colspan="6"><b>TOTAL</b></td>
                                                <td class="text-right"><b><?php echo number_format($total_debit,0,',','.');?></b></td>
                                                <td class="text-right"><b><?php echo number_format($total_kredit,0,',','.');?></b></td>
                                                <td class="text-right"><b><?php echo number_format($total_debit - $total_kredit,0,',','.');?></b></td>
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
